<?php

declare(strict_types=1);

namespace Alacksch\ChatFX;

use Alacksch\ChatFX\Commands\ChatFXCommand;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;

class ChatFX extends PluginBase {
    public array $CFXUsers = [];
    public function onEnable() {
        $this->getServer()->getCommandMap()->register("ChatFX", new ChatFXCommand($this));
        $this->getServer()->getPluginManager()->registerEvents(new ChatListener($this), $this);
    }
}
