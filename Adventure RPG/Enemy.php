<?php

class Enemy {
    private $type;
    private $health;
    private $maxHealth;

    public function __construct($type) {
        $this->type = $type;
        $this->maxHealth = rand(50, 100);
        $this->health = $this->maxHealth;
    }

    public function getType() {
        return $this->type;
    }

    public function getHealth() {
        return $this->health;
    }

    public function getMaxHealth() {
        return $this->maxHealth;
    }

    public function isAlive() {
        return $this->health > 0;
    }

    public function takeDamage($damage) {
        $effectiveDamage = $damage; 
        $effectiveDamage = $effectiveDamage > 0 ? $effectiveDamage : 0; 
        $this->health -= $effectiveDamage;
    
        if ($this->health < 0) {
            $this->health = 0;
        }
    }

    public function attack() {
        return rand(5, 15);
    }
}
