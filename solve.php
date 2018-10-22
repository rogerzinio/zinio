<?php
declare(strict_types=1);


$cities         = loadCitiesFromFile();
$cities         = calculateDistanceTo($cities);
$originalCities = $cities;

[$distance, $path, $cities] = travelmanSellingProblemCustomSolution($cities);
print("Original distance: $distance" . PHP_EOL);
for ($i = 0; $i < 100000; $i++) {
    [$otherDistance, $otherPath, $originalCities] = travelmanSellingProblemCustomSolution($originalCities);

    if ($otherDistance < $distance) {
        print("Find better solution: $distance Vs $otherDistance" . PHP_EOL);
        $distance = $otherDistance;
        $path     = $otherPath;

    }
}

print('BEST distance: ' . $distance . PHP_EOL);
print($path);


function loadCitiesFromFile(): array
{
    $tab    = "\t";
    $fp     = fopen('cities.txt', 'r');
    $cities = [];
    while (!feof($fp)) {
        $line = fgets($fp, 2048);

        $dataFromFile = str_getcsv($line, $tab);
        $cities[]     = [
            'name'      => $dataFromFile[0],
            'latitude'  => $dataFromFile[1],
            'longitude' => $dataFromFile[2]
        ];

    }

    $beijingCity = [
        'name'      => 'Beijing',
        'latitude'  => '39.93',
        'longitude' => '116.40'
    ];

    fclose($fp);

    array_unshift($cities, $beijingCity);

    return $cities;
}

function calculateDistanceTo(array $cities): array
{
    $tmpAllCities  = $cities;
    $withDistances = [];
    foreach ($cities as $city) {
        foreach ($tmpAllCities as $tmpCity) {
            if ($tmpCity['name'] !== 'Beijing' && $city['name'] !== $tmpCity['name']) {

                $distance                                       = circleDistance(
                    (float)$city['latitude'],
                    (float)$city['longitude'],
                    (float)$tmpCity['latitude'],
                    (float)$tmpCity['longitude']
                );
                $withDistances[$city['name']][$tmpCity['name']] = $distance;
            }

        }

    }

    return $withDistances;
}

function circleDistance(float $latitudeFrom, float $longitudeFrom, float $latitudeTo, float $longitudeTo): float
{
    $theta = $longitudeFrom - $longitudeTo;
    $dist  = sin(deg2rad($latitudeFrom)) * sin(deg2rad($latitudeTo)) + cos(deg2rad($latitudeFrom)) * cos(deg2rad($latitudeTo)) * cos(deg2rad($theta));
    $dist  = acos($dist);
    $dist  = rad2deg($dist);
    $miles = $dist * 60 * 1.1515;

    //return in KM...
    return round($miles * 1.609344, 2);
}

function travelmanSellingProblemCustomSolution($allCities)
{
    $originalCities = $allCities;
    $distance       = 0.0;
    $actualCity     = $allCities['Beijing'];
    unset($allCities['Beijing']);
    $path = 'Beijing' . PHP_EOL;

    $i = 0;
    do {
        if ($i % 2 === 0) {
            [$distance, $path, $actualCity, $allCities, $end] = addDistanceToClosest($distance, $path,
                $actualCity, $allCities);
        } else {
            [$distance, $path, $actualCity, $allCities, $end] = addDistanceToRandom($distance, $path,
                $actualCity, $allCities);
        }

        if ($end) {
            break;
        }
        $i++;
    } while ($end = true);


    return [$distance, $path, $originalCities];

}

function addDistanceToClosest(float $distance, string $stringPath, array $actualCity, array $allCities): array
{
    $end             = false;
    $closestCityName = array_search(min($actualCity), $actualCity, true);
    $closestDistance = $actualCity[$closestCityName];
    $actualCity      = $allCities[$closestCityName];
    [$actualCity, $allCities] = removeVisited($closestCityName, $actualCity, $allCities);

    if (count($actualCity) === 0) {
        $end = true;
    }
    $stringPath .= $closestCityName . PHP_EOL;
    $distance   += $closestDistance;
    return [$distance, $stringPath, $actualCity, $allCities, $end];

}


function addDistanceToRandom(float $distance, string $stringPath, array $actualCity, array $allCities): array
{
    $end            = false;
    $randomCityName = array_rand($actualCity);
    $randomDistance = $actualCity[$randomCityName];
    $actualCity     = $allCities[$randomCityName];
    [$actualCity, $allCities] = removeVisited($randomCityName, $actualCity, $allCities);

    if (count($actualCity) === 0) {
        $end = true;
    }
    $stringPath .= $randomCityName . PHP_EOL;
    $distance   += $randomDistance;
    return [$distance, $stringPath, $actualCity, $allCities, $end];

}


function removeVisited($closestCityName, $actualCity, $allCities)
{
    foreach ($actualCity as $destination => $distance) {
        unset($actualCity[$closestCityName]);
    }

    foreach ($allCities as &$destinations) {
        unset($allCities[$closestCityName]);
        foreach ($destinations as $key => $destination) {
            if ($key === $closestCityName) {
                unset($destinations[$key]);
            }
        }
    }

    return [$actualCity, $allCities];
}

