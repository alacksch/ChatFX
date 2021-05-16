<?php
declare(strict_types=1);

namespace Alacksch\ChatFX\Commands;

use Alacksch\ChatFX\ChatFX;
use jojoe77777\FormAPI\CustomForm;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\Player;
use pocketmine\plugin\Plugin;
use pocketmine\utils\TextFormat;
/**
 * @property ChatFX plugin
 */
class ChatFXCommand extends PluginCommand {
    public function __construct(Plugin $plugin) {
        parent::__construct("cfx", $plugin);
        $this->setPermission("chatfx.cfx");
        $this->setDescription("ChatFX command!");
        $this->setAliases(["chatfx"]);
    }
    public const DISPLAY_COLORS = [
        "§fWhite",
        "§0Black",
        "§1Dark Blue",
        "§2Dark Green",
        "§3Dark Aqua",
        "§4Dark Red",
        "§5Dark Purple",
        "§6Gold",
        "§7Gray",
        "§8Dark Gray",
        "§9Blue",
        "§aGreen",
        "§bAqua",
        "§cRed",
        "§dLight Purple",
        "§eYellow"
    ];
    public const FORMATTED_COLORS = [
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
    public function ListColorsDropdown(): array {
        return array_values(self::DISPLAY_COLORS);
    }
    public function MainForm(Player $player) {
        $form = new CustomForm(function (Player $player, $data) {
            if ($data === null) {
                return true;
            }
            $color = self::DISPLAY_COLORS[$data[1]];
            $this->getPlugin()->CFXUsers[$player->getName()] = self::FORMATTED_COLORS[$data[1]];
            $player->sendMessage(TextFormat::YELLOW . 'Your chat color has been set to ' . $color);
            return true;
        });
        $form->setTitle('§cChat§eFX settings');
        $form->addLabel('You may use "None" to reset your chat color.');
        $form->addDropdown('Colors', $this->ListColorsDropdown());
        $player->sendForm($form);
    }
    public function execute(CommandSender $sender, string $commandLabel, array $args): bool {
        if (!$sender->hasPermission($this->getPermission())) {
            $sender->sendMessage("§cYou do not have permissions to run this command.");
        }
        if (!$sender instanceof Player) {
            $sender->sendMessage("§cPlease run the command in-game.");
            return true;
        }
        switch ($args[0] ?? "cfx") {
            case "cfx":
                $this->MainForm($sender);
        }
        return true;
    }
}