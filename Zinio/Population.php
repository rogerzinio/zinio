<?php

declare(strict_types=1);

final class Population
{
    private $paths = [];

    public function __construct($populationSize, $initialize)
    {
        $this->paths = array_fill(0, $populationSize, null);

        if ($initialize) {
            for ($i = 0; $i < $this->populationSize(); $i++) {
                $newPath = new Path();
                $newPath->generateIndividual();
                $this->savePath($i, $newPath);
            }
        }
    }

    public function populationSize(): int
    {
        return \count($this->paths);
    }

    public function savePath($index, Path $path): void
    {
        $this->paths[$index] = $path;
    }

    public function getFittest()
    {
        $fittest = $this->paths[0];

        for ($i = 1; $i < $this->populationSize(); $i++) {
            if ($fittest->getFitness() <= $this->getPath($i)->getFitness()) {
                $fittest = $this->getPath($i);
            }
        }

        return $fittest;
    }

    public function getPath($index): Path
    {
        return $this->paths[$index];
    }
}
