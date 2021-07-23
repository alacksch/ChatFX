<?php

declare(strict_types=1);

namespace Alacksch\ChatFX\fx;

use pocketmine\player\Player;
use pocketmine\utils\TextFormat;

//Bounces between colors
class PingPong extends FX
{
    /** @var string[] */
    private array $colors;

    //Add colors to constructor
    public function __construct(string $id, string $display, string ...$colors)
    {
        parent::__construct($id, $display);
        $this->colors = $colors;
    }

    public function formatText(Player $player, string $string): string
    {
        $message = TextFormat::RESET;
        $strSplit = str_split($string);//TODO second parameter for split slider
        $index = 0;
        // True = right, False = left
        $direction = false;
        foreach ($strSplit as $i => $letter) {
            if ($letter === ' ') {
                $message .= $letter;
            } else {
                if ($index >= (count($this->colors) - 1) || $index <= 0) {
                    $direction = !$direction;
                }
                $color = $this->colors[$index];
                $message .= $color . $letter;
                if ($direction) {
                    $index++;
                } else {
                    $index--;
                }
            }
        }
        return $message;
    }
}