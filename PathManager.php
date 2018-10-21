<?php

declare(strict_types=1);

class PathManager
{
    public static $destinationCities = [];


    public static function addCity(City $city): void
    {
        self::$destinationCities[] = $city;
    }

    public static function getCity($index): City
    {
        return self::$destinationCities[$index];
    }

    public static function numberOfCities(): int
    {
        return count(self::$destinationCities);
    }

    // As PHP doesn't have a native 0.0 to 1.0 random float, this method is added
    public static function random(): float
    {
        return random_int(0, mt_getrandmax() - 1) / mt_getrandmax();
    }

}