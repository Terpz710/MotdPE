<?php

declare(strict_types=1);

namespace Terpz710\MotdPE;

use pocketmine\scheduler\Task;

class MotdTask extends Task {

    private $plugin;
    private $motdList;

    public function __construct(Main $plugin, array $motdList) {
        $this->plugin = $plugin;
        $this->motdList = $motdList;
    }

    public function onRun(): void {
        $randomMOTD = $this->motdList[array_rand($this->motdList)];
        $this->plugin->updateMOTD($randomMOTD);
    }
}
