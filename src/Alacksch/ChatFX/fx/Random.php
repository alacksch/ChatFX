<?php

declare(strict_types=1);

namespace Alacksch\ChatFX\fx;

use pocketmine\utils\TextFormat;

//Applies a random color of a set of colors
class Random extends FX
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
		foreach ($strSplit as $i => $letter) {
			if ($letter === ' ') {
				$string .= $letter;
			} else {
				$color = $this->colors[array_rand($this->colors)];
				$string .= $color . $letter;
			}
		}
		return $message;
	}
}