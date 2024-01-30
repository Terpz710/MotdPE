<?php

declare(strict_types=1);

namespace Terpz710\MotdPE;

use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\scheduler\Task;

use Terpz710\MotdPE\MotdTask;

class Main extends PluginBase implements Listener {

    public function onEnable(): void {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);

        $this->saveResource("motd.yml");
        $config = new Config($this->getDataFolder() . "motd.yml", Config::YAML);

        if ($config->get("rotate_interval", true)) {
            $interval = $config->get("update_interval", 300);
            $this->getScheduler()->scheduleRepeatingTask(new MotdTask($this, $config->get("motd_list", [])), $interval);
        } else {
            $this->updateMOTD($config->get("static_motd", ""));
        }
    }

    public function updateMOTD(string $newMOTD) {
        $this->getServer()->getNetwork()->setName($newMOTD);
    }
}
