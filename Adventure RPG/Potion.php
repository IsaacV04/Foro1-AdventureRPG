<?php

class Potion {
    private $healingAmount;

    public function __construct() {
        $this->healingAmount = rand(10, 30); // Cantidad de curación aleatoria
    }

    public function getHealingAmount() {
        return $this->healingAmount;
    }
}
