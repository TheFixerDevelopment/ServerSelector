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
use pocketmine\event\entity\EntityDamageByEntityEvent;
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
    $this->getServer()->getNetwork()->setName(TextFormat::BOLD . TextFormat::GREEN . "§l§4Auri§cous§6PE §dNetwork");
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
public function getTeleporter(Player $player){
		$inv = $player->getInventory();
		$inv->clearAll();
		$exit = Item::get(351, 1, 1);
		$exit->setCustomName(TextFormat::RESET . TextFormat::RED . "§aExit");
		$Factions = Item::get(46, 1, 1);
		$Factions->setCustomName(TextFormat::RESET . TextFormat::BLUE . "§bFactions\n§cTap me!");
	        $Factions->setLore("§5Go against the other clans\n§5make your own\n§5invite your loyal members to your clan\n§5Raid people, and more!\n§tYour goal is Beating the other factions!\n");
		$Prisons = Item::get(276, 1, 1);
		$Prisons->setCustomName(TextFormat::RESET . TextFormat::GOLD . "§4Kit§cPvP\n§bComing soon!");
	        $Prisons->setLore("§5PvP with kits\n§51v1 against other players\n§5make your way to the top of the leaderboards, and more!\n");
		$KitPvP = Item::get(101, 1, 1);
		$KitPvP->setCustomName(TextFormat::RESET . TextFormat::GREEN . "§7Prisons\n§bComing soon!");
	        $KitPvP->setLore("§5You're in a prison, you have to mine to rankup.\n§5Your goal is to rank all the way up to Z!\n§5There's also PvP mines as well!\n(§dTap me!)");
		$HCF = Item::get(322, 1, 1);
		$HCF->setCustomName(TextFormat::RESET . TextFormat::YELLOW . "§bHCF - §cComing soon");
	        $HCF->setLore("§5HCF = HardCoreFactions. It's factions, but hardcore, which means it's harder.\n§5When you die, you get death banned.\n§5Everything is hardcore mode = More challenging\n§dComing Soon");
		$inv->setItem(8, $exit);
		$inv->setItem(0, $Factions);
		$inv->setItem(1, $Prisons);
		$inv->setItem(2, $KitPvP);
		$inv->setItem(3, $HCF);
	}
public function getGames(Player $player){
$inv = $player->getInventory();
$inv->clearAll();
$exit = Item::get(351, 1, 1);
$exit->setCustomName(TextFormat::RESET . TextFormat::RED . "§aExit");
$MurderMystery = Item::get(276, 1, 1);
		$MurderMystery->setCustomName(TextFormat::RESET . TextFormat::BLUE . "§4Murder§6Mystery");
	        $MurderMystery->setLore("§bThere's one murder, one bystanderd, and everyone else is innocent.\n§aObjectives:\n§bMurder - §3Has to kill everyone to win.\n§cBystanderd - §4Has a gun, they're suppose to kill the murderer to win.\n§dInnocent - §5Make sure you don't get killed.\n§dComing Soon!");
		$Skywars = Item::get(260, 1, 1);
		$Skywars->setCustomName(TextFormat::RESET . TextFormat::GOLD . "§6Sky§bWars");
	        $Skywars->setLore("§bYou're in the sky, you have to:\n§cLoot chests, Get good loot\n§dand kill players!\n§eLast man standing wins!\n§1Coming Soon.");
		$SG = Item::get(322, 1, 1);
		$SG->setCustomName(TextFormat::RESET . TextFormat::GREEN . "§6Survival§bGames");
	        $SG->setLore("§bYou're in a survival area, filled with chests\n§cFilled with Loot\n§dYour objective is to\n§eKill the players.\n§1Last man standing wins.\n§2Coming soon.");
		$UHC = Item::get(261, 1, 1);
		$UHC->setCustomName(TextFormat::RESET . TextFormat::YELLOW . "§6U§bH§cC");
	        $UHC->setLore("§bUHC = UltraHardCore.\n§cYou're in a survival map\n§dbut things get extremly hard.\n§eThere's no: Regeneration\n§1When you die, you get banned\n§2until the game is over.\n§3Coming Soon");
		$inv->setItem(8, $exit);
		$inv->setItem(0, $MurderMystery);
		$inv->setItem(1, $Skywars);
		$inv->setItem(2, $SG);
		$inv->setItem(3, $UHC);
}
public function getInfo(Player $player){
$inv = $player->getInventory();
$inv->clearAll();
$exit = Item::get(351, 1, 1);
$exit->setCustomName(TextFormat::RESET . TextFormat::RED . "§aExit");
$info = Item::get(340, 1, 1);
		$info->setCustomName(TextFormat::RESET . TextFormat::BLUE . "§aServer §bInfo\n§5Tap me!");
		$inv->setItem(8, $exit);
		$inv->setItem(0, $info);
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
        }
      public function getItems(Player $player){
		$name = $player->getName();
		$inv = $player->getInventory();
		$inv->clearAll();
		$item1 = Item::get(345, 0, 1);
		$item1->setCustomName(TextFormat::RESET . TextFormat::GOLD . "§a§lServer Selector (§bTap me!)");
		$item2 = Item::get(347, 0, 1);
		$item2->setCustomName(TextFormat::RESET . TextFormat::BLUE . "§a§lGames Selector");
	        $item2->setLore("5§lSelect a Game to play!\n(§bTap me!)");
		$item3 = Item::get(340, 0, 1);
		$item3->setCustomName("§aServer §bInfo\n§5Tap me!");
		$inv->setItem(0, $item2);
		$inv->setItem(2, $item1);
		$inv->setItem(3, $item3);
      }
      public function noInvMove(InventoryTransactionEvent $ev) {
		$ev->setCancelled(true);
	}
	public function onHit(EntityDamageEvent $ev){
		$entity = $ev->getEntity();
		if ($entity instanceof Player) {
			if ($ev instanceof EntityDamageByEntityEvent) {
				$damager = $event->getDamager();
				if ($damager instanceof Player) {
					if ($entity->getLevel()->getFolderName() == $this->getServer()->getDefaultLevel()->getFolderName()) {
						$event->setCancelled(true);
					}
				}
			}
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
		$this->getItems($player);
 	$player->setHealth(20);
       	$player->setGamemode(2);
		$ev->setJoinMessage("§a$name §6joined the hub.");
	}
        public function onQuit(PlayerQuitEvent $ev) {	
        	$player = $ev->getPlayer();
        	$name = $player->getName();
        	$ev->setQuitMessage("§a$name §6left the hub.");
	}
      public function onInteract(PlayerInteractEvent $ev) {
	   $player = $ev->getPlayer();
       	   $in = $ev->getPlayer()->getInventory()->getItemInHand()->getCustomName();
	   $lore = $ev->getPlayer()->getInventory()->getItemInHand()->getLore();
		$inv = $player->getInventory();
      if ($in == TextFormat::RESET . TextFormat::GOLD . "§bFactions\n§cTap me!"){
      if ($lore == TextFormat::RESET . TextFormat::GOLD . "§5Go against the other clans\n§5make your own\n§5invite your loyal members to your clan\n§5Raid people, and more!\n§tYour goal is Beating the other factions!\n(§dTap me!)"){
			$ev->getPlayer()->transfer("voidfactionspe.ml", "19132");
      } 
      if ($in == TextFormat::RESET . TextFormat::GOLD . "§4Kit§cPvP\n§bComing soon!"){
      if ($lore == TextFormat::RESET . TextFormat::GOLD . "§5PvP with kits\n§51v1 against other players\n§5make your way to the top of the leaderboards, and more!\n(§dTap me!)"){
			$ev->getPlayer()->transfer("voidkitpvppe.ml", "25625");
      }	  
      if ($in == TextFormat::RESET . TextFormat::GOLD . "§7Prisons\n§bComing soon!"){
      if ($lore == "§5You're in a prison, you have to mine to rankup.\n§5Your goal is to rank all the way up to Z!\n§5There's also PvP mines as well!\n(§dTap me!)"){
			$ev->getPlayer()->transfer("voidprisonspe.ml", "25647");
      }
      if ($in == TextFormat::RESET . TextFormat::GOLD . "§bHCF - §cComing soon"){
      if ($lore == TextFormat::RESE . "§5HCF = HardCoreFactions. It's factions, but hardcore, which means it's harder.\n§5When you die, you get death banned.\n§5Everything is hardcore mode = More challenging\n§dComing Soon."){
		  	$ev->getPlayer()->transfer("voidhcfpe.ml", "25630");
      }
      if($in == TextFormat::RESET . TextFormat::GOLD . "§a§lServer Selector (§bTap me!)") {
			
			$this->getTeleporter($player);
      }
      if ($in == TextFormat::RESET . TextFormat::GOLD . "§4Murder§6Mystery"){
      if ($lore == "§bThere's one murder, one bystanderd, and everyone else is innocent.\n§aObjectives:\n§bMurder - §3Has to kill everyone to win.\n§cBystanderd - §4Has a gun, they're suppose to kill the murderer to win.\n§dInnocent - §5Make sure you don't get killed.\n§dComing Soon!"){
			$player->sendMessage("§c§lNew Game Coming Soon!");
      }
      if ($in == TextFormat::RESET . TextFormat::GOLD . "§6Sky§bWars"){
      if ($lore == "§bYou're in the sky, you have to:\n§cLoot chests, Get good loot\n§dand kill players!\n§eLast man standing wins!\n§1Coming Soon."){
			$player->sendMessage("§c§lNew Game Coming Soon!");
      }
      if ($in == TextFormat::RESET . TextFormat::GOLD . "§6Survival§bGames"){
      if ($lore == "§bYou're in a survival area, filled with chests\n§cFilled with Loot\n§dYour objective is to\n§eKill the players.\n§1Last man standing wins.\n§2Coming soon."){
			$player->sendMessage("§c§lNew Game Coming Soon!");
      }
      if ($in == TextFormat::RESET . TextFormat::GOLD . "§6U§bH§cC"){
      if ($lore == "§bUHC = UltraHardCore.\n§cYou're in a survival map\n§dbut things get extremly hard.\n§eThere's no: Regeneration\n§1When you die, you get banned\n§2until the game is over.\n§3Coming Soon"){
		  	$player->sendMessage("§c§lNew Game Coming Soon!");
      }
       if($in == TextFormat::RESET . TextFormat::GOLD . "§a§lGames Selector"){
       if($lore == "§5§lSelect a Game to play!\n(§bTap me!)") {
           
           $this->getGames($player);
		}
		if($in == TextFormat::RESET . TextFormat::GOLD . "§aServer §bInfo\n§5Tap me!");
		 $player->sendMessage("§aHere are the server information:\n\n§bServer IP: §3play.auriouspe.ml\n§bServer Port: §325621\n\n§cYou§fTube §dRank info:\n§a1. §2You must have 100+ §asubscribers!\n§a2. §2You must make a server review for the void network. (Review all servers!)\n§a3. §2You must add the ip & port in the description: IP: play.voidminerpe.ml Port: 25621\n§bDiscord: §3http://tinyurl.com/zeaodc");
		 
		 $this->getInfo($player);
	    return true;
      }
}
