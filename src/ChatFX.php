<?php

declare(strict_types=1);

namespace Alacksch\ChatFX;

use Alacksch\ChatFX\FX\Color;
use Alacksch\ChatFX\FX\FX;
use InvalidArgumentException;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use Alacksch\ChatFX\Commands\ChatFXCommand;
use pocketmine\utils\TextFormat;
use Alacksch\ChatFX\FX\Rainbow;

class ChatFX extends PluginBase {
    private static ChatFX $instance;
    public array $colors = [];
    public array $CFXUsers = [];

    public function onLoad(): void {
        $this->register(new Color('white', '§fWhite', TextFormat::WHITE));
        $this->register(new Color('black', '§0Black', TextFormat::BLACK));
        $this->register(new Color('darkblue', '§1Dark Blue', TextFormat::DARK_BLUE));
        $this->register(new Color('darkgreen', '§2Dark Green', TextFormat::DARK_GREEN));
        $this->register(new Color('darkaqua', '§3Dark Aqua', TextFormat::DARK_AQUA));
        $this->register(new Color('darkred', '§4Dark Red', TextFormat::DARK_RED));
        $this->register(new Color('darkpurple', '§5Dark Purple', TextFormat::DARK_PURPLE));
        $this->register(new Color('gold', '§6Gold', TextFormat::GOLD));
        $this->register(new Color('gray', '§7Gray', TextFormat::GRAY));
        $this->register(new Color('darkgray', '§8Dark Gray', TextFormat::DARK_GRAY));
        $this->register(new Color('blue', '§9Blue', TextFormat::BLUE));
        $this->register(new Color('green', '§aGreen', TextFormat::GREEN));
        $this->register(new Color('aqua', '§bAqua', TextFormat::AQUA));
        $this->register(new Color('red', '§cRed', TextFormat::RED));
        $this->register(new Color('lightpurple', '§dLight Purple', TextFormat::LIGHT_PURPLE));
        $this->register(new Color('yellow', '§eYellow', TextFormat::YELLOW));
        $this->register(new Rainbow('rainbow', '§cR§e§ba§6i§an§db§co§6w'));
        self::$instance = $this;
    }
    public function onEnable(): void {
        $this->getServer()->getPluginManager()->registerEvents(new ChatListener(), $this);
        Server::getInstance()->getCommandMap()->register("chatfx", new ChatFXCommand($this));
    }
    public static function getInstance(): ChatFX {
        return self::$instance;
    }
    public function register(FX $color): void {
        $this->colors[$color->getId()] = $color;
    }
    public function getEffect(string $color): FX{
        return $this->colors[$color];
    }
    public function getEffectByDisplay(string $display, bool $weak = true): FX {
        foreach ($this->colors as $color) {
            if ((!$weak && $color->getDisplay() === $display) xor ($weak && strtolower(TextFormat::clean($color->getDisplay())) === strtolower(TextFormat::clean($display)))) return $color;
        }
        throw new InvalidArgumentException("No effect with display $display found");
    }
}
