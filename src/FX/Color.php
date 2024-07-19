<?php

namespace Alacksch\ChatFX\FX;

use pocketmine\player\Player;
use pocketmine\utils\TextFormat;

class Color extends FX {
    private string $color;
    public function __construct(string $id, string $display, string $color)
    {
        parent::__construct($id, $display);
        $this->color = $color;
    }
    public function formatText(Player $player, string $text): string {
        return TextFormat::RESET . $this->color . $text;
    }
}