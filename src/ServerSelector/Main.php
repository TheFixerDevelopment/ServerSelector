<?php

namespace ServerSelector;

use pocketmine\plugin\PluginBase;
use pocketmine\Player;
use pocketmine\utils\TextFormat;

class Main extends PluginBase {
	
	private $listener = null;
	
public function onEnable(): void {
    $this->getServer()->getPluginManager()->registerEvents($this, $this);
    $this->getLogger()->info("Plugin has been enabled.");
    $this->getServer()->getNetwork()->setName(TextFormat::BOLD . TextFormat::GREEN . "§6§lVoid§bMiner§cPE §dNetwork");
}

public function getListener() : EventListener {
		return $this->listener;
	}
/**
	 * Set the event listener
	 */
private function setListener() {
$this->listener = new EventListener($this);
}
}
