<?php
namespace ServerSelector;

use pocketmine\item\Item;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerExhaustEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerPreLoginEvent;
use pocketmine\event\inventory\InventoryTransactionEvent;
use pocketmine\utils\TextFormat;
use pocketmine\event\player\PlayerDropItemEvent;
use pocketmine\event\inventory\InventoryPickupItemEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\Player;

class Main extends PluginBase implements Listener {
    
public function onEnable(): void{
    $this->getLogger()->info("Plugin has been enabled.");
    $this->getServer()->getNetwork()->setName(TextFormat::BOLD . TextFormat::GREEN . "§6§lVoid§bMiner§cPE §dNetwork");
}
public function onPickup(InventoryPickupItemEvent $event){
		$player = $event->getInventory()->getHolder();
		$defaultlevel = $this->getServer()->getDefaultLevel();
		$event->setCancelled();
}
public function onDrop(PlayerDropItemEvent $event){
		$player = $event->getPlayer();
		$defaultlevel = $this->getServer()->getDefaultLevel();
		$event->setCancelled();
}
public function onHunger(PlayerExhaustEvent $event){
	$event->setCancelled(true);
}
public function getSelector(Player $player){
    $inv = $player->getInventory();
    $inv->clearAll();
		$exit = Item::get(351, 1, 1);
		$exit->setCustomName(TextFormat::RESET . TextFormat::RED . "Exit");
		$Factions = Item::get(46, 1, 1);
		$Factions->setCustomName(TextFormat::RESET . TextFormat::BLUE . "§aFactions §5(Tap Me!)");
		$Prisons = Item::get(101, 1, 1);
		$Prisons->setCustomName(TextFormat::RESET . TextFormat::GREEN . "§bPrisons §5(Tap Me!)");
		$KitPvP = Item::get(276, 1, 1);
		$KitPvP->setCustomName(TextFormat::RESET . TextFormat::GOLD . "§cKitPvP - §7Coming Soon.");
		$HCF = Item::get(322, 1, 1);
		$HCF->setCustomName(TextFormat::RESET . TextFormat::RED . "§d§lHCF §5(Tap Me!)");
		$inv->setItem(8, $exit);
		$inv->setItem(0, $Factions);
		$inv->setItem(2, $Prisons);
		$inv->setItem(4, $KitPvP);
		$inv->setItem(6, $HCF);
}
public function onPreLogin(PlayerPreLoginEvent $event){
		$player = $event->getPlayer();
		$name = $player->getName();
		$ip = $player->getAddress();
		$cid = $player->getClientId();
	        $in = $event->getPlayer()->getInventory()->getItemInHand()->getCustomName();
		if (!$player->isWhitelisted($name)) {
			$msg =
				TextFormat::BOLD . TextFormat::GRAY . "+++-----------+++-----------+++\n" .
				TextFormat::RESET . TextFormat::RED . "VoidMinerPE" . TextFormat::GRAY . "|" . TextFormat::RED . " Maintenance\n" .
				TextFormat::GOLD . "Try again soon";
			$player->close("", $msg);
		}
                if($in == TextFormat::RESET . TextFormat::GOLD . "§b§lServer Selector (§cTap me!)") {
			
			$this->getSelector($player);
                }
	}
public function onHit(EntityDamageEvent $event){
		$entity = $event->getEntity();
		if ($entity instanceof Player) {
			if ($event instanceof EntityDamageByEntityEvent) {
				$damager = $event->getDamager();
				if ($damager instanceof Player) {
					if ($entity->getLevel()->getFolderName() == $this->getServer()->getDefaultLevel()->getFolderName()) {
						$event->setCancelled();
					}
				}
			}
		}
	}
      public function getItems(Player $player){
		$name = $player->getName();
		$inv = $player->getInventory();
		$inv->clearAll();
		$item1 = Item::get(345, 0, 1);
		$item1->setCustomName(TextFormat::RESET . TextFormat::GOLD . "§b§lServer Selector (§cTap me!)");
      }
      public function noInvMove(InventoryTransactionEvent $event){
		$event->setCancelled(true);
	}
	public function onDamage(EntityDamageEvent $event){
		$player = $event->getEntity();
		if ($player->getLevel()->getFolderName() == $this->getServer()->getDefaultLevel()->getFolderName()) {
			if ($player instanceof Player) {
				$event->setCancelled();
			}
		}
	}

	public function onJoin(PlayerJoinEvent $event){
		$player = $event->getPlayer();
		$name = $player->getName();
		$this->getItems($player);
		
		$event->setJoinMessage("");
		$event->getPlayer()->setFood("20");
		$player->setGamemode(0);
		
		//$this->getItems($player);
	}
        public function onQuit(PlayerQuitEvent $event){
		$event->setQuitMessage("");
	}

      public function onInteract(PlayerInteractEvent $event){
          $player = $event->getPlayer();
          $in = $event->getPlayer()->getInventory()->getItemInHand()->getCustomName();
          $inv = $player->getInventory();
          if ($in == TextFormat::RESET . TextFormat::BLUE . "Factions") {
			$event->getPlayer()->transfer("voidfactionspe.ml", "19132");
		}
		if ($in == TextFormat::RESET . TextFormat::GREEN . "Prisons") {
			$event->getPlayer()->transfer("voidprisonspe.ml", "25641");
		}
		if ($in == TextFormat::RESET . TextFormat::GOLD . "KitPvP") {
			$event->getPlayer()->transfer("voidkitpvppe.ml", "25630");
		}
	    return true;
      }
}
