<?php

namespace StopIt;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\utils\TextFormat;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;

class StopIt extends PluginBase implements Listener{
    
    public $level;   
    private $time;
    
    public function onEnable(){
        $this->loadConfig();
        
        $this->getLogger()->info($this->getPrefix().TextFormat::GREEN."Time has been fixed to ".$this->getTime());
        
        $this->level = $this->getServer()->getDefaultLevel();
        $this->level->setTime($this->getTime());
        $this->level->stopTime();
    }
    
    public function loadConfig(){
        @mkdir($this->getDataFolder());
        $this->saveDefaultConfig();
        $this->time = $this->getConfig()->get("time", "0");
    }
    
    public function saveConfig(){
        $this->getConfig()->set("time", $this->gettime());
        parent::saveConfig();
    }
    
    public function onCommand(CommandSender $sender, Command $command, $commandAlias, array $args){
        if(!$sender->hasPermission("stopit.deftime")){
            return false;
        }
        if(!is_array($args) or count($args) < 1){
            $sender->sendMessage($this->getPrefix()."Current default time is: ".$this->getTime());
            $sender->sendMessage($this->getPrefix()."Usage: /deftime <value>");
            return true;
        }
        
        $this->time = $args[0];
        $sender->sendMessage($this->getPrefix()."Default time has been fixed to ".$this->getTime());
        $this->level = $this->getServer()->getDefaultLevel();
        $this->level->setTime($this->getTime());
        $this->level->stopTime();
        $this->saveConfig();
        return true;
    }
    
    public function getTime(){
        return $this->time;
    }
    
    public static function getPrefix(){
        return TextFormat::GREEN."[Stop".TextFormat::DARK_GREEN."It] ".TextFormat::RESET.TextFormat::WHITE;
    }
    
    public function onDisable(){
        $this->saveConfig();
    }
    
}