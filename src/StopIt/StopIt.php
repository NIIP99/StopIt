<?php

namespace StopIt;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\utils\TextFormat;

class StopIt extends PluginBase implements Listener{
    
    public $level;

    public function onEnable()
    {
        if (!file_exists($this->getDataFolder() . "config.yml"))
        $this->saveDefaultConfig();
        
        $this->level = $this->getServer()->getDefaultLevel();
        $this->getLogger()->info(TextFormat::GREEN."Time has been fixed to ".$this->getTime());
                
        $this->level->setTime($this->getTime());
        $this->level->stopTime();
    }
    
    public function getTime()
    {
        return $this->getConfig()->get("time");
    }
    
}