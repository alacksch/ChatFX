<?php

declare(strict_types=1);

namespace Alacksch\ChatFX;

use Alacksch\ChatFX\Commands\ChatFXCommand;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;

class ChatFX extends PluginBase {
    public array $CFXUsers = [];
    public array $colors = [
        TextFormat::WHITE,
        TextFormat::BLACK,
        TextFormat::DARK_BLUE,
        TextFormat::DARK_GREEN,
        TextFormat::DARK_AQUA,
        TextFormat::DARK_RED,
        TextFormat::DARK_PURPLE,
        TextFormat::GOLD,
        TextFormat::GRAY,
        TextFormat::DARK_GRAY,
        TextFormat::BLUE,
        TextFormat::GREEN,
        TextFormat::AQUA,
        TextFormat::RED,
        TextFormat::LIGHT_PURPLE,
        TextFormat::YELLOW
    ];
    public function onEnable() {
        $this->getServer()->getCommandMap()->register("ChatFX", new ChatFXCommand($this));
        $this->getServer()->getPluginManager()->registerEvents(new ChatListener($this), $this);
    }
    public function Rainbow(string $message): string {
        $string = '';
        foreach(str_split($message) as $letter) {
            if($letter === ' ') {
                $string .= $letter;
            } else {
                $string .= current($this->colors) . $letter;
                if(next($this->colors) === false) {
                    reset($this->colors);
                }
            }
        }
        return $string;
    }
}