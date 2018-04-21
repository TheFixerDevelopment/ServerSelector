<?php
namespace ServerSelector;

use pocketmine\item\Item;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\PlayerJoinEvent;
use pocketmine\event\PlayerQuitEvent;
use pocketmine\event\PlayerInteractEvent;
use pocketmine\event\PlayerPreLoginEvent;
use pocketmine\utils\TextFormat;
use pocketmine\Player;

class Main extends PluginBase implements Listener {
    
public function onEnable(): void{
    $this->getLogger()->info("Plugin has been enabled.");
    $this->getServer()->getNetwork()->setName(TextFormat::BOLD . TextFormat::GREEN . "§6§lVoid§bMiner§cPE §dNetwork");
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
      public function getItems(Player $player){
		$name = $player->getName();
		$inv = $player->getInventory();
		$inv->clearAll();
		$item1 = Item::get(345, 0, 1);
		$item1->setCustomName(TextFormat::RESET . TextFormat::GOLD . "§b§lServer Selector (§cTap me!)");
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
            }
      }
