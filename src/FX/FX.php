<?php

namespace Alacksch\ChatFX\FX;

use pocketmine\command\CommandSender;
use pocketmine\player\Player;

abstract class FX {
    private string $id;
    private string $displayName;

    public function __construct(string $id, string $displayName) {
        $this->id = $id;
        $this->displayName = $displayName;
    }
    public abstract function formatText(Player $player, string $text): string;

    final public function getId(): string{
        return $this->id;
    }
    final public function getDisplay(): string{
        return $this->displayName;
    }
    final public function getPermission(): string{
        return 'chatfx.cfx.' . $this->getId();
    }
    final public function canUse(CommandSender $sender): bool {
        return $sender->hasPermission('chatfx.cfx.*') || $sender->getServer()->isOp($sender->getName());
    }
}