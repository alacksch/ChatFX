<?php

declare(strict_types=1);

namespace Seyrxn\ChatFX\fx;

use pocketmine\utils\TextFormat;
use pocketmine\Player;

class Color extends FX
{
	private string $color;

	//Add color to constructor
	public function __construct(string $id, string $display, string $color)
	{
		parent::__construct($id, $display);
		$this->color = $color;
	}

	public function formatText(Player $player, string $string): string
	{
		return TextFormat::RESET . $this->color . $string;
	}
}