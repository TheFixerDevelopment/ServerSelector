<?php

namespace ServerSelector;

use pocketmine\item\Item;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerExhaustEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\inventory\InventoryOpenEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerPreLoginEvent;
use pocketmine\level\Level;
use pocketmine\utils\Terminal;
use pocketmine\level\Position;
use pocketmine\event\inventory\InventoryTransactionEvent;
use pocketmine\utils\TextFormat;
use pocketmine\Server;
use pocketmine\event\player\PlayerDropItemEvent;
use pocketmine\event\inventory\InventoryPickupItemEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\player\PlayerItemConsumeEvent;
use pocketmine\Player;

class Main extends PluginBase implements Listener {
	
public function onEnable(): void {
    $this->getLogger()->info("Plugin has been enabled.");
    $this->getServer()->getNetwork()->setName(TextFormat::BOLD . TextFormat::GREEN . "§6§lVoid§bMiner§cPE §dNetwork");
}
public function onDisable(): void {
    $this->getLogger()->info("Plugin has been disabled.");
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
		$player->getInventory()->setSize(9);
		$player->getInventory()->setItem(0, Item::get(345)->setCustomName("§a§lServer Selector (§bTap me!)"));
        }
      public function noInvMove(InventoryTransactionEvent $ev) {
		$ev->setCancelled(true);
	}
	public function onDamage(EntityDamageEvent $ev) {
      		if($ev->getCause() === EntityDamageEvent::CAUSE_FALL){
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
		$player->getInventory()->clearAll();
		$player->setFood(20);
       		$player->setHealth(20);
       		$player->setGamemode(0);
		$player->getInventory()->setSize(9);
       		$player->getInventory()->setItem(2, Item::get(345)->setCustomName("§a§lServer Selector! (§bTap me!)"));
		$ev->setJoinMessage("");
	}
        public function onQuit(PlayerQuitEvent $ev) {	
        	$player = $ev->getPlayer();
        	$name = $player->getName();
        	$ev->setQuitMessage("");
	}

      public function onInteract(PlayerInteractEvent $ev) {
	   $player = $ev->getPlayer();
      	`  $item = $ev->getItem();
          if($item->getCustomName() == "§a§lServer Selector! (§bTap me!)"){
              
            $player->getInventory()->clearAll();
            $player->getInventory()->setSize(9);
            $player->getInventory()->setItem(0, Item::get(46)->setCustomName("§6Void§bFactions§cPE (§dTap me!)"));
            $player->getInventory()->setItem(1, Item::get(276)->setCustomName("§6Void§bKitPvP§cPE (§dTap me!)"));
            $player->getInventory()->setItem(2, Item::get(101)->setCustomName("§6Void§bPrisons§cPE (§dTap me!)"));
            $player->getInventory()->setItem(3, Item::get(322)->setCustomName("§6Void§bHCF§cPE - §dComing Soon"));
            
          }elseif($item->getCustomName() == "§6Void§bFactions§cPE (§dTap me!)") {
			$ev->getPlayer()->transfer("voidfactionspe.ml", "19132");
	  
      }elseif($item->getCustomName() == "§6Void§bPrisons§cPE (§dTao me!)") {
			$ev->getPlayer()->transfer("voidprisonspe.ml", "25641");

      }elseif($item->getCustomName() ==  "§6Void§bKitPvP§cPE (§dTap me!)") {
			$ev->getPlayer()->transfer("voidkitpvppe.ml", "25625");
		  
      }elseif($item->getCustomName() == "§6Void§bHCF§cPE (§dComing Soon!)") {
		  	$ev->getPlayer()->transfer("voidhcfpe.ml", "25630");
		}
	    return true;
      }
}
