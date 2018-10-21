<?php

declare(strict_types=1);

final class Path
{
    private $path = [];
    private $fitness = 0;
    private $distance = 0;

    public function __construct()
    {
        $this->path = array_fill(0, PathManager::numberOfCities(), null);
    }

    public function generateIndividual()
    {
        for ($cityIndex = 0, $len = PathManager::numberOfCities(); $cityIndex < $len; $cityIndex++) {
            $this->setCity($cityIndex, PathManager::getCity($cityIndex));
        }

        shuffle($this->path);
        $beijingCity = new City('Beijing', 39.93, 116.40);
        array_unshift($this->path, $beijingCity);
    }

    public function setCity($pathPosition, City $city): void
    {
        $this->path[$pathPosition] = $city;

        $this->fitness  = 0;
        $this->distance = 0;
    }

    public function getFitness()
    {
        if ($this->fitness === 0) {
            $this->fitness = 1 / (double)$this->getDistance();
        }

        return $this->fitness;
    }

    public function getDistance()
    {
        if ($this->distance === 0) {
            $pathDistance = 0;

            for ($cityIndex = 0, $len = $this->pathSize(); $cityIndex < $len; $cityIndex++) {
                $fromCity        = $this->getCity($cityIndex);
                $destinationCity = null;

                // Check we're not on our path last city, if we are set our
                // path final destination city to our starting city
                if ($cityIndex + 1 < $this->pathSize()) {
                    $destinationCity = $this->getCity($cityIndex + 1);
                } else {
                    $destinationCity = $this->getCity(0);
                }

                $pathDistance += $fromCity->distanceTo($destinationCity);
            }

            $this->distance = $pathDistance;
        }

        return $this->distance;
    }

    public function pathSize(): int
    {
        return count($this->path);
    }

    public function getCity($pathPosition): ?City
    {
        return $this->path[$pathPosition];
    }

    public function containsCity(City $city): bool
    {
        return in_array($city, $this->path, false);
    }

    public function __toString(): string
    {
        $stringPath = '';
        foreach ($this->path as $path) {
            $stringPath .= $path->name . '\n ';
        }

        return $stringPath;
    }

}
