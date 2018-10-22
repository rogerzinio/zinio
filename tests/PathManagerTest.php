<?php

declare(strict_types=1);

require_once '../Zinio/City.php';
require_once '../Zinio/PathManager.php';
require_once '../Zinio/Population.php';
require_once '../Zinio/GA.php';
require_once '../Zinio/Path.php';


use PHPUnit\Framework\TestCase;

final class PathManagerTest extends TestCase
{
    public function testAddCity(): void
    {
        $city = new City('DummyName', 11.22, 22.33);

        $this->assertSame(0, PathManager::numberOfCities());
        PathManager::addCity($city);
        $this->assertSame(1, PathManager::numberOfCities());
    }

    public function testGetCity(): void
    {
        $city = new City('DummyName', 11.22, 22.33);
        PathManager::addCity($city);
        $this->assertSame('DummyName', PathManager::getCity(0)->name);
        $this->assertSame(11.22, PathManager::getCity(0)->latitude);
        $this->assertSame(22.33, PathManager::getCity(0)->longitude);
    }

}