<?php
require_once 'src' . DIRECTORY_SEPARATOR . 'randomizer.php';

$participants = file('participants.txt');
$randomizer = new Randomizer($participants);
$randomizer->run();