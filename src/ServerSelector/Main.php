<?php

namespace ServerSelector;

use pocketmine\plugin\PluginBase;
use pocketmine\Player;
use pocketmine\utils\TextFormat;
use pocketmine\Server;
use pocketmine\item\Item;
use pocketmine\event\Listener;
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
		$player->getInventory()->setItem(4, Item::get(345)->setCustomName("§a§lServer Selector (§bTap me!)"));
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
		$player->getInventory()->clearAll();
		$player->setFood(20);
       	$player->setHealth(20);
       	$player->setGamemode(0);
        $player->getInventory()->setSize(9);
       	$player->getInventory()->setItem(4, Item::get(345)->setCustomName("§a§lServer Selector!\n§5Select a server!\n(§bTap me!)"));
		$ev->setJoinMessage("");
	}
        public function onQuit(PlayerQuitEvent $ev) {	
        	$player = $ev->getPlayer();
        	$name = $player->getName();
        	$ev->setQuitMessage("");
	}
      public function onInteract(PlayerInteractEvent $ev) {
	   $player = $ev->getPlayer();
       $item = $ev->getItem();
          if($item->getCustomName() == "§a§lServer Selector!\n§5Select a server!\n(§bTap me!)"){
              
            $player->getInventory()->clearAll();
            $player->getInventory()->setSize(9);
            $player->getInventory()->setItem(0, Item::get(46)->setCustomName("§6Void§bFactions§cPE\n§5Go against the other clans\n§5make your own\n§5invite your loyal members to your clan\n§5Raid people, and more!\n§tYour goal is Beating the other factions!\n(§dTap me!)"));
            $player->getInventory()->setItem(2, Item::get(276)->setCustomName("§6Void§bKitPvP§cPE\n§5PvP with kits\n§51v1 against other players\n§5make your way to the top of the leaderboards, and more!\n(§dTap me!)"));
            $player->getInventory()->setItem(4, Item::get(101)->setCustomName("§6Void§bPrisons§cPE\n§5You're in a prison, you have to mine to rankup.\n§5Your goal is to rank all the way up to Z!\n§5There's also PvP mines as well!\n(§dTap me!)"));
            $player->getInventory()->setItem(6, Item::get(322)->setCustomName("§6Void§bHCF§cPE\n§5HCF = HardCoreFactions. It's factions, but hardcore, which means it's harder.\n§5When you die, you get death banned.\n§5Everything is hardcore mode = More challenging\n§dComing Soon"));
            
          }elseif($item->getCustomName() == "§6Void§bFactions§cPE (§dTap me!)"){
			$ev->getPlayer()->transfer("voidfactionspe.ml", "19132");
	  
      }elseif($item->getCustomName() == "§6Void§bPrisons§cPE (§dTap me!)"){
			$ev->getPlayer()->transfer("voidprisonspe.ml", "25641");
		  
      }elseif($item->getCustomName() ==  "§6Void§bKitPvP§cPE (§dTap me!)"){
			$ev->getPlayer()->transfer("voidkitpvppe.ml", "25625");
		  
      }elseif($item->getCustomName() == "§6Void§bHCF§cPE (§dComing Soon!)"){
		  	$ev->getPlayer()->transfer("voidhcfpe.ml", "25630");
		}
	    return true;
      }
}
