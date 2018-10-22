<?php

declare(strict_types=1);

require_once '../Zinio/City.php';
require_once '../Zinio/PathManager.php';
require_once '../Zinio/Population.php';
require_once '../Zinio/GA.php';
require_once '../Zinio/Path.php';


use PHPUnit\Framework\TestCase;

final class PopulationTest extends TestCase
{
    public function testCreateAPopulation(): void
    {
        $pop = new Population(50, true);
        $this->assertSame(50, $pop->populationSize());
    }

    public function testFirstCityIsBeijing(): void
    {
        $pop     = new Population(50, true);
        $beijing = new City('Beijing', 39.93, 116.40);

        $this->assertSame($beijing->name, $pop->getPath(0)->getCity(0)->name);
        $this->assertSame($beijing->latitude, $pop->getPath(0)->getCity(0)->latitude);
        $this->assertSame($beijing->longitude, $pop->getPath(0)->getCity(0)->longitude);
    }
}