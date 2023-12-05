<?php

declare(strict_types=1);

namespace Terpz710\MotdPE;

use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\scheduler\Task;

use Terpz710\MotdPE\MotdTask;

class Main extends PluginBase implements Listener {

    private $subRotateInterval;

    public function onEnable(): void {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);

        $this->saveResource("motd.yml");
        $config = new Config($this->getDataFolder() . "motd.yml", Config::YAML);

        if ($config->get("rotate_interval", true)) {
            $interval = $config->get("update_interval", 300);
            $this->subRotateInterval = $config->get("sub_rotate_interval", true);
            $this->getScheduler()->scheduleRepeatingTask(
                new MotdTask(
                    $this,
                    $config->get("motd_list", []),
                    $config->get("sub_motd_list", []),
                    $this->subRotateInterval,
                    $config->get("sub_update_interval", 120)
                ),
                $interval
            );
        } else {
            $this->updateMOTD(
                $config->get("static_motd", ""),
                $config->get("static_sub_motd", "")
            );
        }
    }

    public function updateMOTD(string $newMOTD, string $newSubMOTD = "") {
        $network = $this->getServer()->getNetwork();
        $network->setName($newMOTD);
        if (!empty($newSubMOTD)) {
            $network->setSubName($newSubMOTD);
        }
    }
}
