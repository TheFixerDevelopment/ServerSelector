<?php

namespace ServerSelector;

use pocketmine\plugin\PluginBase;
use pocketmine\Player;
use pocketmine\utils\TextFormat;
use pocketmine\Server;
use pocketmine\item\Item;
use pocketmine\event\Listener;
use pocketmine\utils\Config;
use pocketmine\event\inventory\InventoryPickupItemEvent;
use pocketmine\event\player\PlayerDropItemEvent;
use pocketmine\event\player\PlayerItemConsumeEvent;
use pocketmine\event\player\PlayerExhaustEvent;
use pocketmine\event\player\PlayerPreLoginEvent;
use pocketmine\event\inventory\InventoryTransactionEvent;
use pocketmine\inventory\BaseInventory;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\inventory\Inventory;
use pocketmine\event\player\PlayerInteractEvent;

class Main extends PluginBase implements Listener {
	
public function onEnable(): void {
    $this->getServer()->getPluginManager()->registerEvents($this, $this);
    @mkdir($this->getDataFolder());
    $this->saveDefaultConfig();
    $this->getLogger()->info("Plugin has been enabled.");
    $this->getServer()->getNetwork()->setName(TextFormat::BOLD . TextFormat::GREEN . "§6§lVoid§bMiner§cPE §dNetwork");
}
public function onPickup(InventoryPickupItemEvent $ev) {
		$ev->setCancelled(true);
}
public function ItemMove(PlayerDropItemEvent $ev) {
        $ev->setCancelled(true);
}
 public function onConsume(PlayerItemConsumeEvent $ev) {
        $ev->setCancelled(true);
}
public function onHunger(PlayerExhaustEvent $ev) {
	$ev->setCancelled(true);
}
public function onPreLogin(PlayerPreLoginEvent $ev) {
		$player = $ev->getPlayer();
	        $inventory = $player->getInventory();
		$name = $player->getName();
		$ip = $player->getAddress();
		$cid = $player->getClientId();
	
		if (!$player->isWhitelisted($name)) {
			$msg =
				TextFormat::BOLD . TextFormat::GRAY . "+++-----------+++-----------+++\n" .
				TextFormat::RESET . TextFormat::RED . "VoidMinerPE" . TextFormat::GRAY . "|" . TextFormat::RED . " Maintenance\n" .
				TextFormat::GOLD . "Try again soon";
			$player->close("", $msg);
		}
	        $player->getInventory()->clearAll();
	        $player->getInventory()->setSize(9);
		$player->getInventory()->setItem($this->getConfig()->get("selector_slot"), Item::get($this->getConfig()->get("selector_id"))->setCustomName($this->getConfig()->get("server_selector")->setLore($this->getConfig()->get("server_selectordesc"))));
        }
      public function noInvMove(InventoryTransactionEvent $ev) {
		$ev->setCancelled(true);
	}
	public function onDamage(EntityDamageEvent $ev){
      		if($ev->getCause() === EntityDamageEvent::CAUSE_FALL) {
          	$ev->setCancelled(true);
        	}
    	}
	public function onPlace(BlockPlaceEvent $ev) {
			$player = $ev->getPlayer();
			$ev->setCancelled(true);
	}
	public function onBreak(BlockBreakEvent $ev) {
			$player = $ev->getPlayer();
			$ev->setCancelled(true);
	}
	public function onJoin(PlayerJoinEvent $ev) {
		$player = $ev->getPlayer();
		$name = $player->getName();
		$player->getInventory()->clearAll();
		$player->setFood(20);
       	$player->setHealth(20);
       	$player->setGamemode(0);
        $player->getInventory()->setSize(9);
       	$player->getInventory()->setItem($this->getConfig()->get("selector_slot"),  Item::get($this->getConfig()->get("selector_id"))->setCustomName($this->getConfig()->get("server_selector")->setLore("server_selectordesc")));
		$ev->setJoinMessage("§a$name §6joined the hub.");
	}
        public function onQuit(PlayerQuitEvent $ev) {	
        	$player = $ev->getPlayer();
        	$name = $player->getName();
        	$ev->setQuitMessage("§a$name §6left the hub.");
	}
      public function onInteract(PlayerInteractEvent $ev) {
	   $player = $ev->getPlayer();
       $item = $ev->getItem();
          if($item->getCustomName() == $this->getConfig()->get("server_selector")){
              
            $player->getInventory()->clearAll();
            $player->getInventory()->setSize(9);
            $player->getInventory()->setItem($this->getConfig()->get("slotnumber", Item::get($this->getConfig()->get("itemid")->setCustomName($this->getConfig()->get("server_name")->setLore($this->getConfig()->get("description"))))));
            $player->getInventory()->setItem($this->getConfig()->get("slotnumber02", Item::get($this->getConfig()->get("itemid02")->setCustomName($this->getConfig()->get("server_name2")->setLore($this->getConfig()->get("description2"))))));
            $player->getInventory()->setItem($this->getConfig()->get("slotnumber03", Item::get($this->getConfig()->get("itemid03")->setCustomName($this->getConfig()->get("server_name3")->setLore($this->getConfig()->get("description3"))))));
            $player->getInventory()->setItem($this->getConfig()->get("slotnumber04", Item::get($this->getConfig()->get("itemid04")->setCustomName($this->getConfig()->get("server_name4")->setLore($this->getConfig()->get("description4"))))));
            
          }elseif($item->getCustomName() == $this->getConfig()->get("server_name")->getLore($this->getConfig()->get("description"))){
			$ev->getPlayer()->transfer($this->getConfig()->get("server_ip", $this->getConfig()->get("server_port")));
	  
      }elseif($item->getCustomName() == $this->getConfig()->get("server_name2")->getLore($this->getConfig()->get("description2"))){
			$ev->getPlayer()->transfer($this->getConfig()->get("server_ip2", $this->getConfig()->get("server_port2")));
		  
      }elseif($item->getCustomName() == $this->getConfig()->get("server_name3")->getLore($this->getConfig()->get("description3"))){
			$ev->getPlayer()->transfer($this->getConfig()->get("server_ip3", $this->getConfig()->get("server_port3")));
		  
      }elseif($item->getCustomName() == $this->getConfig()->get("server_name4")->getLore($this->getConfig()->get("description4"))){
		  	$ev->getPlayer()->transfer($this->getConfig()->get("server_ip4", $this->getConfig()->get("server_port4")));
		}
	    return true;
      }
}
