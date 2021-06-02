<?php

declare(strict_types=1);

namespace Alacksch\ChatFX\fx;

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
		$strSplit = str_split($string, 2);//TODO second parameter for split slider
		$index = 0;
		// True = right, False = left
		$direction = true;
		foreach ($strSplit as $i => $letter) {
			if ($letter === ' ') {
				$string .= $letter;
			} else {
				if ($direction) {
					$index++;
					if ($index >= count($this->colors)) {
						$direction = false;
					}
				} else {
					$index--;
					if ($index <= 0) {
						$direction = true;
					}
				}
				$color = $this->colors[$index];
				$string .= $color . $letter;
			}
		}
		return $message;
	}
}