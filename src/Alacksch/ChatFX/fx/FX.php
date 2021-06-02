<?php

declare(strict_types=1);

namespace Alacksch\ChatFX\fx;

abstract class FX
{
	private string $id;
	private string $display;

	public function __construct(string $id, string $display)
	{
		$this->id = $id;
		$this->display = $display;
	}

	public abstract function formatText(Player $player, string $string): string;

	final public function getId(): string
	{
		return $this->id;
	}

	final public function getDisplay(): string
	{
		return $this->display;
	}

	final public function getPermission(): string
	{
		return 'chatfx.fx.' . $this->getId();
	}

	final public function canUse(Player $player): bool
	{
		return $player->hasPermission($this->getPermission());
	}

}