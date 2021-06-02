<?php
declare(strict_types=1);

namespace Alacksch\ChatFX\Commands;

use Alacksch\ChatFX\ChatFX;
use jojoe77777\FormAPI\CustomForm;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\plugin\Plugin;
use pocketmine\utils\TextFormat;
use pocketmine\Player;

class ChatFXCommand extends Command
{
	/** @var ChatFX */
	public ChatFX $plugin;

	public function __construct(ChatFX $plugin)
	{
		$this->plugin = $plugin;
		parent::__construct("cfx", "ChatFX command!", null, ["chatfx"]);
		$this->setPermission("chatfx.cfx");
	}

	/**
	 * @return ChatFX
	 */
	public function getPlugin(): ChatFX
	{
		return $this->plugin;
	}

	public function MainForm(Player $player)
	{
		$effects = [];
		foreach ($this->getPlugin()->effects as $fx) $effects[] = $fx->getDisplay();
		$form = new CustomForm(function (Player $player, $data) use ($effects) {
			if ($data === null) {
				return true;
			}
			$effect = $this->getPlugin()->getEffectByDisplay($effects[$data[1]]);
			$this->getPlugin()->CFXUsers[$player->getName()] = $effect;
			$player->sendMessage(TextFormat::YELLOW . 'Your chat effect has been set to ' . $effect->getDisplay());
			return true;
		});
		$form->setTitle('§cChat§eFX settings');
		$form->addLabel('You may use "White" to reset your chat color to default.');
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
