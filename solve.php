<?php
declare(strict_types=1);

require_once 'City.php';
require_once 'PathManager.php';
require_once 'Population.php';
require_once 'Path.php';
require_once 'GA.php';

loadCitiesFromFile();

$pop = new Population(100, true);
$pop = GA::evolvePopulation($pop);
for ($i = 0; $i < 500; $i++) {
    $pop = GA::evolvePopulation($pop);
}
print_r($pop->getFittest() . PHP_EOL);

function loadCitiesFromFile(): void
{
    $tab = "\t";
    $fp  = fopen('cities.txt', 'r');

    while (!feof($fp)) {
        $line = fgets($fp, 2048);

        $dataFromFile = str_getcsv($line, $tab);
        $city         = new City($dataFromFile[0], $dataFromFile[1], $dataFromFile[2]);
        PathManager::addCity($city);
    }

    fclose($fp);
}
