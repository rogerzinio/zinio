<?php

declare(strict_types=1);

final class GA
{
    static private $mutationRate = 0.015;
    static private $tournamentSize = 5;
    static private $elitism = true;

    public static function evolvePopulation(Population $pop): Population
    {
        $newPopulation = new Population($pop->populationSize(), false);

        $elitismOffset = 0;

        // Keep our best individual if elitism is enabled
        if (self::$elitism) {
            $newPopulation->savePath(0, $pop->getFittest());
            $elitismOffset = 1;
        }

        // Crossover population
        // Loop over the new population's size and create individuals from
        // Current population
        for ($i = $elitismOffset, $len = $newPopulation->populationSize(); $i < $len; $i++) {
            $parent1 = self::tournamentSelection($pop);
            $parent2 = self::tournamentSelection($pop);

            $child = self::crossover($parent1, $parent2);
            $newPopulation->savePath($i, $child);
        }

        // Mutate the new population a bit to add some new genetic material
        for ($i = $elitismOffset, $len = $newPopulation->populationSize(); $i < $len; $i++) {
            self::mutate($newPopulation->getPath($i));
        }

        return $newPopulation;
    }

    private static function tournamentSelection(Population $pop)
    {
        $tournament = new Population(self::$tournamentSize, false);

        // For each place in the tournament get a random candidate path and
        // add it
        for ($i = 0; $i < self::$tournamentSize; $i++) {
            $randomId = (int)(PathManager::random() * $pop->populationSize());
            $tournament->savePath($i, $pop->getPath($randomId));
        }

        return $tournament->getFittest();
    }

    // Mutate a path using swap mutation

    public static function crossover(Path $parent1, Path $parent2): Path
    {
        $child = new Path();

        $startPos = (int)(PathManager::random() * $parent1->pathSize());
        $endPos   = (int)(PathManager::random() * $parent1->pathSize());

        for ($i = 0, $len = $child->pathSize(); $i < $len; $i++) {
            if ($startPos < $endPos && $i > $startPos && $i < $endPos) {
                $child->setCity($i, $parent1->getCity($i));
            } else {
                if ($startPos > $endPos && !($i < $startPos && $i > $endPos)) {
                    $child->setCity($i, $parent1->getCity($i));
                }
            }
        }

        for ($i = 0, $len = $parent2->pathSize(); $i < $len; $i++) {
            if (!$child->containsCity($parent2->getCity($i))) {
                for ($ii = 0, $len2 = $child->pathSize(); $ii < $len2; $ii++) {
                    if ($child->getCity($ii) === null) {
                        $child->setCity($ii, $parent2->getCity($i));
                        break;
                    }
                }
            }
        }
        return $child;
    }

    private static function mutate(Path $path): void
    {
        for ($pathPos1 = 0; $pathPos1 < $path->pathSize(); $pathPos1++) {
            if (PathManager::random() < self::$mutationRate) {

                $pathPos2 = (int)($path->pathSize() * PathManager::random());

                $city1 = $path->getCity($pathPos1);
                $city2 = $path->getCity($pathPos2);

                if (!$city1->isBeijingCity() && !$city2->isBeijingCity()) {
                    $path->setCity($pathPos2, $city1);
                    $path->setCity($pathPos1, $city2);
                }
            }
        }
    }

}
