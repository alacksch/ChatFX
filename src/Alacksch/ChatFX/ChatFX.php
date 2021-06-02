<?php

declare(strict_types=1);

namespace Alacksch\ChatFX;

use Alacksch\ChatFX\Commands\ChatFXCommand;
use Alacksch\ChatFX\fx\Color;
use Alacksch\ChatFX\fx\FX;
use Alacksch\ChatFX\fx\PingPong;
use Alacksch\ChatFX\fx\Rainbow;
use Alacksch\ChatFX\fx\Random;
use InvalidArgumentException;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;

class ChatFX extends PluginBase
{
	/** @var FX[] */
	public array $CFXUsers = [];
	/** @var FX[] */
	public array $effects = [];

	public function onLoad(): void
	{
		$this->register(new Color('white', '§fWhite', TextFormat::WHITE));
		$this->register(new Color('black', '§0Black', TextFormat::BLACK));
		$this->register(new Color('dark blue', '§1Dark Blue', TextFormat::DARK_BLUE));
		$this->register(new Color('dark green', '§2Dark Green', TextFormat::DARK_GREEN));
		$this->register(new Color('dark aqua', '§3Dark Aqua', TextFormat::DARK_AQUA));
		$this->register(new Color('dark red', '§4Dark Red', TextFormat::DARK_RED));
		$this->register(new Color('dark purple', '§5Dark Purple', TextFormat::DARK_PURPLE));
		$this->register(new Color('gold', '§6Gold', TextFormat::GOLD));
		$this->register(new Color('gray', '§7Gray', TextFormat::GRAY));
		$this->register(new Color('dark gray', '§8Dark Gray', TextFormat::DARK_GRAY));
		$this->register(new Color('blue', '§9Blue', TextFormat::BLUE));
		$this->register(new Color('green', '§aGreen', TextFormat::GREEN));
		$this->register(new Color('aqua', '§bAqua', TextFormat::AQUA));
		$this->register(new Color('red', '§cRed', TextFormat::RED));
		$this->register(new Color('light purple', '§dLight Purple', TextFormat::LIGHT_PURPLE));
		$this->register(new Color('yellow', '§eYellow', TextFormat::YELLOW));
		$this->register(new Rainbow('rainbow', '§cR§e§ba§6i§an§db§co§6w'));
		$this->register(new PingPong('pingpong test', '§cPi§ang§6Po§ang §cTe§ast', TextFormat::RED, TextFormat::GREEN, TextFormat::GOLD));
		$this->register(new PingPong('pingpong germany', '§0Pi§cng§6Po§cng §0Ge§crm§0an§cy', TextFormat::BLACK, TextFormat::RED, TextFormat::GOLD));
		$this->register(new Random('random test', '§5R§da§5nd§do§5m §dT§5e§ds§5t', TextFormat::LIGHT_PURPLE, TextFormat::DARK_PURPLE));
	}

	public function onEnable(): void
	{
		$this->getServer()->getCommandMap()->register("ChatFX", new ChatFXCommand($this));
		$this->getServer()->getPluginManager()->registerEvents(new ChatListener($this), $this);
	}

	public function register(FX $effect): void
	{
		$this->effects[$effect->getId()] = $effect;
	}

	public function getEffect(string $id): FX
	{
		return $this->effects[$id];
	}

	public function getEffectByDisplay(string $display, bool $weak = true): FX
	{
		foreach ($this->effects as $effect) {
			if ((!$weak && $effect->getDisplay() === $display) xor ($weak && strtolower(TextFormat::clean($effect->getDisplay())) === strtolower(TextFormat::clean($display)))) return $effect;
		}
		throw new InvalidArgumentException("No effect with display $display found");
	}
}