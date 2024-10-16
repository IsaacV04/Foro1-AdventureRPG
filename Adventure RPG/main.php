<?php

require 'Game.php';

// Comienza el juego
echo "\n------- ¡Bienvenido a Adventure RPG! -------\n";
echo ">> Introduce tu nombre: ";
$name = trim(fgets(STDIN));
$game = new Game($name);
$game->start();
