<?php

declare(strict_types=1);

namespace Seyrxn\ChatFX\fx;

use pocketmine\utils\TextFormat;
use pocketmine\Player;

class Rainbow extends FX
{
	private const COLORS = [
		TextFormat::WHITE,
		TextFormat::GOLD,
		TextFormat::BLUE,
		TextFormat::GREEN,
		TextFormat::AQUA,
		TextFormat::RED,
		TextFormat::LIGHT_PURPLE,
		TextFormat::YELLOW
	];

	public function formatText(Player $player, string $string): string
	{
		$message = TextFormat::RESET;
		$strSplit = str_split($string);//TODO second parameter for split slider
		foreach ($strSplit as $i => $letter) {
			if ($letter === ' ') {
				$message .= $letter;
			} else {
				$color = self::COLORS[$i % count(self::COLORS)];
                $message .= $color . $letter;
			}
		}
		return $message;
	}
}