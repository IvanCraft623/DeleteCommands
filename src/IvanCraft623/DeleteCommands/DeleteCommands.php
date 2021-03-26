<?php

declare(strict_types=1);

#Plugin By:

/*
    8888888                            .d8888b.                   .d888 888     .d8888b.   .d8888b.   .d8888b.  
      888                             d88P  Y88b                 d88P"  888    d88P  Y88b d88P  Y88b d88P  Y88b 
      888                             888    888                 888    888    888               888      .d88P 
      888  888  888  8888b.  88888b.  888        888d888 8888b.  888888 888888 888d888b.       .d88P     8888"  
      888  888  888     "88b 888 "88b 888        888P"      "88b 888    888    888P "Y88b  .od888P"       "Y8b. 
      888  Y88  88P .d888888 888  888 888    888 888    .d888888 888    888    888    888 d88P"      888    888 
      888   Y8bd8P  888  888 888  888 Y88b  d88P 888    888  888 888    Y88b.  Y88b  d88P 888"       Y88b  d88P 
    8888888  Y88P   "Y888888 888  888  "Y8888P"  888    "Y888888 888     "Y888  "Y8888P"  888888888   "Y8888P"  
*/

namespace IvanCraft623\DeleteCommands;

use pocketmine\{Server, plugin\PluginBase, scheduler\ClosureTask, utils\Config};

class DeleteCommands extends PluginBase {

	public static $instance;

	public function onLoad() : void {
		self::$instance = $this;
	}

	public function onEnable() : void {
		$this->saveResources();
		$task = new ClosureTask(function(int $currentTick) : void {
			$this->deleteCommands();
		});
		$this->getScheduler()->scheduleDelayedTask($task, 0);
	}

	public static function getInstance() : self {
		return self::$instance;
	}

	public static function getConfigs(string $value) : Config {
		return new Config(self::getInstance()->getDataFolder() . "{$value}.yml", Config::YAML);
	}

	public function saveResources() : void {
		$this->saveResource("config.yml");
	}

	public function deleteCommands() : void {
		$commands = self::getConfigs("config")->get("Commands");
		if ($commands === false) return;
		foreach ($commands as $cmd) {
			self::unregister($cmd);
		}
	}

	public static function unregister(string $cmd) : bool {
		$map = Server::getInstance()->getCommandMap();
		$command = $map->getCommand($cmd);
		if ($command !== null) {
			$command->setLabel("old_".$cmd);
			$map->unregister($command);
			return true;
		}
		self::getInstance()->getLogger()->error('Could not delete "' . $cmd . '" command.');
		return false;
	}
}
