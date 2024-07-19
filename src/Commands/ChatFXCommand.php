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
    public function __construct() {
        parent::__construct("chatfx", "Change your messages color", "", ["cfx"]);
        $this->setPermission("chatfx.cmd");
        $this->setPermissionMessage("You do not have the permission to run this command!");
    }
    public function execute(CommandSender $sender, string $aliasUsed, array $args): void {
        if (!$sender instanceof Player) {
            $sender->sendMessage("Use this command in-game");
        } else {
            $colors = [];

            foreach ($this->getOwningPlugin()->$colors as $fx) {
                 if ($fx->canUse($sender)) {
                     $colors[] = $fx->getDisplay();
                 }
            }
            $sender->sendForm(new CustomForm("ChatFX", [
                new Dropdown("Select your chat effect", $colors),
            ], function(Player $player, CustomFormResponse $response) : void{
                $dropdown = $response->getDropdown();
                $player->sendMessage("Your chat color has been changed to: " . $dropdown->getSelectedOption());
                $this->getOwningPlugin()->CFXUsers[$player->getName()] = $this->getOwningPlugin()->getEffectByDisplay($dropdown->getSelectedOption());
            }));
        }
    }
    public function getOwningPlugin(): Plugin {
        return ChatFX::getInstance();
    }
}
