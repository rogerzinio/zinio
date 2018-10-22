<?php

declare(strict_types=1);

require_once '../Zinio/City.php';
require_once '../Zinio/PathManager.php';
require_once '../Zinio/Population.php';
require_once '../Zinio/GA.php';
require_once '../Zinio/Path.php';


use PHPUnit\Framework\TestCase;

final class CityTest extends TestCase
{
    public function testCreateCity(): void
    {
        $city = new City('CityTestName', 11.12, 22.34);

        $this->assertSame('CityTestName', $city->name());
        $this->assertSame(11.12, $city->latitude());
        $this->assertSame(22.34, $city->longitude());

    }

    public function testDistanceToSameCity(): void
    {
        $city1 = new City('CityTestName1', 11.12, 22.34);
        $city2 = new City('CityTestName2', 11.12, 22.34);

        $distance = $city1->distanceTo($city2);
        $this->assertSame(0.0, $distance);
    }

    public function testIsBeijingCity(): void
    {
        $beijing = new City('Beijing', 39.93, 116.40);

        $this->assertSame('Beijing', $beijing->name);
        $this->assertSame(39.93, $beijing->latitude);
        $this->assertSame(116.40, $beijing->longitude);

    }
}