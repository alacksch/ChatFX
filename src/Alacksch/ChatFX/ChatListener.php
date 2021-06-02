<?php

namespace Alacksch\ChatFX;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;

class ChatListener implements Listener
{
	public ChatFX $plugin;

	public function getPlugin(): ChatFX
	{
		return $this->plugin;
	}

	public function __construct(ChatFX $plugin)
	{
		$this->plugin = $plugin;
	}

	public function onChat(PlayerChatEvent $event)
	{
		if (isset($this->getPlugin()->CFXUsers[$event->getPlayer()->getName()])) {
			$fx = $this->getPlugin()->CFXUsers[$event->getPlayer()->getName()] ?? null;
			if ($fx !== null) {
				$event->setMessage($fx->formatText($event->getPlayer(), $event->getMessage()));
			}
		}
	}
}
