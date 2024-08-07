<?php

namespace Alacksch\ChatFX\Commands;

use Alacksch\ChatFX\ChatFX;
use forms\CustomForm;
use forms\CustomFormResponse;
use forms\element\Dropdown;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\plugin\Plugin;
use pocketmine\plugin\PluginOwned;

class ChatFXCommand extends Command implements PluginOwned {
    private $chatfx;

    public function __construct(ChatFX $chatFX) {
        $this->chatfx = $chatFX;
        parent::__construct("chatfx", "Change your messages color", "", ["cfx"]);
        $this->setPermission("chatfx.cmd");
        $this->setPermissionMessage("You do not have the permission to run this command!");
    }
    public function execute(CommandSender $sender, string $commandLabel, array $args): void {
        if (!$sender instanceof Player) {
            $sender->sendMessage("Use this command in-game");
        } else {
            $colors = [];
            foreach ($this->chatfx->colors as $fx) {
                 if ($fx->canUse($sender)) {
                     $colors[] = $fx->getDisplay();
                 }
            }
            $sender->sendForm(new CustomForm("ChatFX", [
                new Dropdown("Select your chat effect", $colors),
            ], function(Player $player, CustomFormResponse $response) : void{
                $dropdown = $response->getDropdown();
                $player->sendMessage("Your chat color has been changed to: " . $dropdown->getSelectedOption());
                $this->chatfx->CFXUsers[$player->getName()] = $this->chatfx->getEffectByDisplay($dropdown->getSelectedOption());
            }));
        }
    }
    public function getOwningPlugin(): Plugin {
        return ChatFX::getInstance();
    }
}
