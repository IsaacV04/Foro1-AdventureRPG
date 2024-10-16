<?php

require 'Player.php';
require 'Enemy.php';
require 'Potion.php';

class Game {
    private $player;
    private $enemies = ["Duende", "Orco", "Esqueleto", "Dragón"];
    private $isRunning;
    private $enemiesDefeated;

    public function __construct($playerName) {
        $this->selectCharacter($playerName);
        $this->isRunning = true;
        $this->enemiesDefeated = 0;
    }

    private function selectCharacter($playerName) {
        echo "Personajes: (1) Guerrero (2) Mago\n>> Elige tu personaje: ";
        $choice = trim(fgets(STDIN));

        if ($choice == "1") {
            $this->player = new Guerrero($playerName); 
            mostrarGuerrero();
        } elseif ($choice == "2") {
            $this->player = new Mago($playerName); 
            mostrarMago();
        } else {
            echo "Selección no válida. Serás asignado como Guerrero por defecto.\n";
            $this->player = new Guerrero($playerName, 100, 20, 10);
            mostrarGuerrero();
        }
    }

    public function start() {
        while ($this->isRunning) {
            $enemy = $this->spawnEnemy();
            $this->battle($enemy);
        }
        $this->summary();
    }

    private function spawnEnemy() {
        $enemyType = $this->enemies[array_rand($this->enemies)];
        return new Enemy($enemyType);
    }

    private function battle($enemy) {
        echo "¡¡Un {$enemy->getType()} apareció!!\n";
    
        while ($this->player->getHealth() > 0 && $enemy->isAlive()) {
            // Informacion del enemigo
            echo "\n>> Enemigo: {$enemy->getType()}\n";
            echo "> Salud: {$enemy->getHealth()}/{$enemy->getMaxHealth()}\n\n";

            // Informacion del jugador
            echo ">> Jugador: {$this->player->getName()}\n";
            echo "> Nivel: {$this->player->getLevel()}\n";
            echo "> Salud: {$this->player->getHealth()}/{$this->player->getMaxHealth()}\n";
            echo "> Ataques Especiales: {$this->player->getSpecialAbilities()}\n";
            echo "> Pociones: {$this->player->getPotions()}\n";
            echo "\n--------------------------------------------\n";
            echo "\n1. Ataque Normal\n2. Ataque Especial\n3. Curarte\n4. Escapar\n5. Terminar juego\n>> ¿Qué deseas hacer?: ";
            
            $action = trim(fgets(STDIN));
            
            echo "\n--------------------------------------------\n";
            switch ($action) {
                case 1: // Atacar
                    $damage = $this->player->attack();
                    $enemy->takeDamage($damage);
                    echo ">> Atacas al {$enemy->getType()} y le haces {$damage} de daño.\n";
                    
                    if (!$enemy->isAlive()) {
                        echo ">> ¡Has derrotado al {$enemy->getType()}!\n";
                        $this->enemiesDefeated++;
                        $this->player->gainExperience(50); // Ganar experiencia
                        $this->checkForPotion(); // Verificar si el enemigo suelta poción
                    }
                    break;

                case 2: // Habilidad especial
                    if ($this->player instanceof Guerrero) {
                        $this->player->ataqueEspecial($enemy);
                        //mostrarGuerrero();
                    } elseif ($this->player instanceof Mago) {
                        $this->player->hechizo($enemy);
                        //mostrarMago();
                    }
                    break;

                case 3: // Curarse
                    $healedAmount = $this->player->heal();
                    if ($healedAmount > 0) {
                        echo ">> Te curas {$healedAmount} puntos de salud.\n";
                    } else {
                        echo ">> No tienes pociones para curarte.\n";
                    }
                    break;

                case 4: // Escapar
                    echo ">> Intentas escapar...\n";
                    if (rand(0, 1)) { // 50% de probabilidad de escapar
                        echo ">> ¡Has escapado del combate!\n";
                        echo "--------------------------------------------\n";
                        return; // Sale de la batalla
                    } else {
                        echo ">> ¡No logras escapar, el enemigo te ataca!\n";
                        $this->player->takeDamage($enemy->attack());
                    }
                    break;

                case 5: // Terminar juego
                    $this->isRunning = false;
                    return;

                default:
                    echo ">> Acción no válida. Elige otra vez.\n";
                    break; 
            }

            if ($enemy->isAlive()) {
                $damage = $enemy->attack();
                $this->player->takeDamage($damage);
                echo ">> El {$enemy->getType()} te ataca y te hace {$damage} de daño.\n";

                if ($this->player->getHealth() <= 0) {
                    echo ">> Has sido derrotado por el {$enemy->getType()}.\n";
                    echo ">> ¡Fin del juego!\n";
                    echo "--------------------------------------------\n";
                    $this->isRunning = false;
                    return;
                }
            }
            echo "--------------------------------------------\n";
        }
    }

    private function checkForPotion() {
        if (rand(0, 1)) {
            $this->player->addPotion();
        }
    }

    private function summary() {
        echo "---------- Resumen de la partida -----------";
        if ($this->player instanceof Guerrero) {
            mostrarGuerrero();
        } elseif ($this->player instanceof Mago) {
            mostrarMago();
        }
        echo ">> Jugador: {$this->player->getName()}\n";
        echo ">> Nivel: {$this->player->getLevel()}\n";
        //echo ">> Salud final: {$this->player->getHealth()}\n";
        echo ">> Enemigos derrotados: {$this->enemiesDefeated}\n\n";
    }
}
