<?php

declare(strict_types=1);

namespace Terpz710\MotdPE;

use pocketmine\scheduler\Task;

class MotdTask extends Task {

    private $plugin;
    private $motdList;
    private $subMotdList;
    private $subRotateInterval;
    private $subUpdateInterval;
    private $subUpdateCounter = 0;

    public function __construct(Main $plugin, array $motdList, array $subMotdList = [], bool $subRotateInterval = false, int $subUpdateInterval = 300) {
        $this->plugin = $plugin;
        $this->motdList = $motdList;
        $this->subMotdList = $subMotdList;
        $this->subRotateInterval = $subRotateInterval;
        $this->subUpdateInterval = $subUpdateInterval;
    }

    public function onRun(): void {
        $randomMOTD = $this->motdList[array_rand($this->motdList)];
        if ($this->subRotateInterval && !empty($this->subMotdList)) {
            $this->subUpdateCounter++;
            if ($this->subUpdateCounter >= $this->subUpdateInterval) {
                $randomSubMOTD = $this->subMotdList[array_rand($this->subMotdList)];
                $this->plugin->updateMOTD($randomMOTD, $randomSubMOTD);
                $this->subUpdateCounter = 0;
                return;
            }
        }
        $this->plugin->updateMOTD($randomMOTD);
    }
}
