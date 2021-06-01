<?php
namespace Alacksch\ChatFX;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;

class ChatListener implements Listener {
    public function getPlugin(): ChatFX {
        return $this->plugin;
    }
    public ChatFX $plugin;
    public function __construct(ChatFX $plugin) {
        $this->plugin = $plugin;
    }
    public function onChat(PlayerChatEvent $event) {
        if (isset($this->getPlugin()->CFXUsers[$event->getPlayer()->getName()])) {
                $color = $this->getPlugin()->CFXUsers[$event->getPlayer()->getName()];
                $event->setMessage($color . $event->getMessage());
        }
    }
}
