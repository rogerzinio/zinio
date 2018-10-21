<?php

declare(strict_types=1);

final class City
{

    public $name;
    public $latitude;
    public $longitude;

    public function __construct($name, $latitude, $longitude)
    {
        $this->name      = $name;
        $this->latitude  = $latitude;
        $this->longitude = $longitude;
    }

    public function distanceTo(City $city): float
    {
        $xDistance = abs($this->latitude() - $city->latitude());
        $yDistance = abs($this->longitude() - $city->longitude());

        return round(sqrt(($xDistance * $xDistance) + ($yDistance * $yDistance)), 2);

    }

    public function latitude(): float
    {
        return (float)$this->latitude;
    }

    public function longitude(): float
    {
        return (float)$this->longitude;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function __toString(): string
    {
        return $this->latitude() . ', ' . $this->longitude();
    }

    public function isBeijingCity(): bool
    {
        return $this->name === 'Beijing';
    }
}