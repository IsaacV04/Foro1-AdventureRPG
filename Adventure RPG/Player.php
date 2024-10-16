<?php

class Player {
    protected $name;
    protected $health;
    protected $maxHealth;
    protected $attack;
    protected $potions;
    protected $specialAbilities;
    protected $maxSpecialAbilities;
    protected $level;
    protected $experience;

    public function __construct($name = 'Player', $health = 100, $attack = 20, $maxSpecialAbilities = 3) {
        $this->name = $name;
        $this->health = $health;
        $this->maxHealth = $health;
        $this->attack = $attack;
        $this->potions = 3; // Empieza con 3 pociones por defecto
        $this->level = 1;
        $this->experience = 0;
        $this->maxSpecialAbilities = $maxSpecialAbilities;
        $this->specialAbilities = $maxSpecialAbilities;
    }

    // Métodos de acceso
    public function getName() {
        return $this->name;
    }

    public function getHealth() {
        return $this->health;
    }

    public function getMaxHealth() {
        return $this->maxHealth;
    }

    public function getPotions() {
        return $this->potions;
    }

    public function getLevel() {
        return $this->level;
    }

    public function getSpecialAbilities() {
        return $this->specialAbilities;
    }

    public function attack() {
        return $this->attack;
    }


    public function takeDamage($damage) {
        $damage = $damage > 0 ? $damage : 0; // Evitar daño negativo
        $this->health -= $damage;
        if ($this->health < 0) {
            $this->health = 0;
        }
    }

    public function heal() {
        if ($this->potions > 0) {
            $this->potions--;
            $healAmount = rand(15, 30);
            $this->health += $healAmount;
            if ($this->health > $this->maxHealth) {
                $this->health = $this->maxHealth;
            }
            return $healAmount;
        }
        return 0;
    }

    public function gainExperience($amount) {
        $this->experience += $amount;
        if ($this->experience >= 100) {
            $this->levelUp();
        }
    }

    private function levelUp() {
        $this->level++;
        $this->experience = 0;
        $this->maxHealth += 20;
        $this->health = $this->maxHealth;
        $this->attack += 5;
        $this->specialAbilities = $this->maxSpecialAbilities;
        echo ">> {$this->name} ha subido de nivel a {$this->level}.\n";
        echo ">> Salud máxima: {$this->maxHealth}, Ataque: {$this->attack}. \n>> Salud y ataques especiales restaurados.\n";
    }

    public function addPotion() {
        $this->potions++;
        echo ">> Has encontrado una poción.\n";
    }
}

class Guerrero extends Player {
    public function __construct($name = 'Guerrero', $health = 100, $attack = 20, $maxSpecialAbilities = 3) {
        parent::__construct($name, $health, $attack, $maxSpecialAbilities);
    }

    public function ataqueEspecial($enemy) {
        if ($this->specialAbilities > 0) {
            $this->specialAbilities--;
            $damage = $this->attack * 2;
            $enemy->takeDamage($damage);
            echo ">> Usas tu ataque especial causando {$damage} de daño.\n";
        } else {
            echo ">> No te quedan ataques especiales.\n";
        }
    }
}

class Mago extends Player {
    public function __construct($name = 'Mago', $health = 80, $attack = 15, $maxSpecialAbilities = 3) {
        parent::__construct($name, $health, $attack, $maxSpecialAbilities);
    }

    public function hechizo($enemy) {
        if ($this->specialAbilities > 0) {
            $this->specialAbilities--;
            $damage = $this->attack * 3;
            $enemy->takeDamage($damage);
            echo ">> Usas tu hechizo especial causando {$damage} de daño.\n";
        } else {
            echo ">> No te quedan ataques especiales.\n";
        }
    }
}

function mostrarMago() {
    echo "
                    .

                   .
         /^\     .
    /\   \ /
   /__\   I      O  o
  /(..)\  I     .
  \].`[/  I
  /l\/j\  (]    .  O
 /. ~~ ,\/I          .
 \ L__j^\/I       o
  \/--v}  I     o   .
  |    |  I   _________
  |    |  I c(`       ')o
  |    l  I   \.     ,/
_/j  L l\_!  _//^---^ \_ 

¡Has elegido ser un Mago!
    \n";
}

function mostrarGuerrero() {
    echo "
  / \
  | |
  |.|
  |.|
  |:|      __
,_|:|_,   /  )
  (Oo    / _I_
   +\ \  || __|
      \ \||___|
        \ /.:.\-\
         |.:. /-----\
         |___|::oOo::|
         /   |:<_T_>:|
        |_____\ ::: /
         | |  \ \:/
         | |   | |
         \ /   | \___
         / |   \_____\
         `-'
¡Has elegido ser un Guerrero!
    \n";
}