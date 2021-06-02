<?php
declare(strict_types=1);

namespace Alacksch\ChatFX\Commands;

use Alacksch\ChatFX\ChatFX;
use jojoe77777\FormAPI\CustomForm;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\plugin\Plugin;
use pocketmine\utils\TextFormat;

class ChatFXCommand extends Command
{
	public Plugin $plugin;

	public function __construct(Plugin $plugin)
	{
		$this->plugin = $plugin;
		parent::__construct("cfx", "ChatFX command!", null, ["chatfx"]);
		$this->setPermission("chatfx.cfx");
	}

	/**
	 * @return ChatFX
	 */
	public function getPlugin(): Plugin
	{
		return $this->plugin;
	}

	public function MainForm(Player $player)
	{
		$form = new CustomForm(function (Player $player, $data) {
			if ($data === null) {
				return true;
			}
			$effect = $this->getPlugin()->getEffectByDisplay($data[1]);
			$this->getPlugin()->CFXUsers[$player->getName()] = $effect;
			$player->sendMessage(TextFormat::YELLOW . 'Your chat effect has been set to ' . $effect->getDisplay());
			return true;
		});
		$form->setTitle('§cChat§eFX settings');
		$form->addLabel('You may use "White" to reset your chat color to default.');
		$effects = [];
		foreach ($this->getPlugin()->effects as $id => $fx) $effects[$id] = $fx->getDisplay();
		$form->addDropdown('Effects', $effects);
		$player->sendForm($form);
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args): bool
	{
		if (!$sender->hasPermission($this->getPermission())) {
			$sender->sendMessage("§cYou do not have permissions to run this command.");
			return true;
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
