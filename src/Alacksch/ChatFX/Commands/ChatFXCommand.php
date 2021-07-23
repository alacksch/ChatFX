<?php
declare(strict_types=1);

namespace Alacksch\ChatFX\Commands;

use Alacksch\ChatFX\ChatFX;
use jojoe77777\FormAPI\CustomForm;
use pocketmine\command\CommandSender;
use pocketmine\command\defaults\VanillaCommand;
use pocketmine\plugin\Plugin;
use pocketmine\utils\TextFormat;
use pocketmine\player\Player;

class ChatFXCommand extends VanillaCommand
{
    /** @var ChatFX */
    public ChatFX $plugin;

    public function __construct(ChatFX $plugin)
    {
        parent::__construct("chatfx", "Customize your chat format", "/chatfx", ["cfx"]);
        $this->setPermission("chatfx.cfx");
        $this->plugin = $plugin;
    }

    /**
     * @return ChatFX
     */
    public function getPlugin(): Plugin
    {
        return $this->plugin;
    }
    public function MainForm(Player $player)
    {
        $effects = [];
        foreach ($this->plugin->effects as $fx) if ($fx->canUse($player)) $effects[] = $fx->getDisplay();
        $form = new CustomForm(function (Player $player, $data) use ($effects) {
            if($effects != null) {
                $effect = $this->plugin->getEffectByDisplay($effects[$data[1]]);
                $this->plugin->CFXUsers[$player->getName()] = $effect;
                $player->sendMessage(TextFormat::YELLOW . 'Your chat effect has been set to ' . $effect->getDisplay());
            }
            return true;
        });
        $form->setTitle('§cChat§eFX settings');
        $form->addLabel('You may use "White" to reset your chat color to default.');
        if($effects != null) {
            $form->addDropdown('Effects', $effects);
        } else {
            $form->addLabel('You do not have the permission to use any colors.');
        }
        $player->sendForm($form);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool
    {
        if (!$sender->hasPermission($this->getPermission())) {
            $sender->sendMessage("§cYou do not have permissions to run this command.");
            return true;
        }
        if (!$sender instanceof Player) {
            $sender->sendMessage("§cPlease run the command in-game.");
            return true;
        }
        switch ($args[0] ?? "cfx") {
            case "cfx":
                $this->MainForm($sender);
        }
        return true;
    }
}
