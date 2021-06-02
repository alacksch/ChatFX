<?php

declare(strict_types=1);

namespace Alacksch\ChatFX\fx;

use pocketmine\utils\TextFormat;
use pocketmine\Player;

class Rainbow extends FX
{
	private const COLORS = [
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

	public function formatText(Player $player, string $string): string
	{
		$message = TextFormat::RESET;
		$strSplit = str_split($string);//TODO second parameter for split slider
		foreach ($strSplit as $i => $letter) {
			if ($letter === ' ') {
				$string .= $letter;
			} else {
				$color = self::COLORS[$i % count(self::COLORS)];
				$string .= $color . $letter;
			}
		}
		return $message;
	}
}