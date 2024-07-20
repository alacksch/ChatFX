<?php

namespace Alacksch\ChatFX;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\plugin\Plugin;
use pocketmine\utils\TextFormat;

class ChatListener implements Listener {
    public function getOwningPlugin(): Plugin {
        return ChatFX::getInstance();
    }
    public function onChat(PlayerChatEvent $event): void{
        if (isset($this->getOwningPlugin()->CFXUsers[$event->getPlayer()->getName()])) {
            $fx = $this->getOwningPlugin()->CFXUsers[$event->getPlayer()->getName()] ?? null;
            if ($fx !== null) {
                if ($fx->canUse($event->getPlayer())) $event->setMessage($fx->formatText($event->getPlayer(), $event->getMessage()));
            } else {
                unset($this->getOwningPlugin()->CFXUsers[$event->getPlayer()->getName()]);
                $event->getPlayer()->sendMessage(TextFormat::RED . 'Your chat effects have been reset because your permissions changed');
            }
        }
    }
}
