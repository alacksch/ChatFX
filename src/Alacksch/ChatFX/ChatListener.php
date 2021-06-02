<?php

namespace Alacksch\ChatFX;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\utils\TextFormat;

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
                if ($fx->canUse($event->getPlayer())) $event->setMessage($fx->formatText($event->getPlayer(), $event->getMessage()));
                else {
                    unset($this->getPlugin()->CFXUsers[$event->getPlayer()->getName()]);
                    $event->getPlayer()->sendMessage(TextFormat::RED . 'Your chat effects have been reset because your permissions changed');
                }
            }
        }
    }
}