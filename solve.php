<?php

declare(strict_types=1);

CONST EARTH_RADIUS = 6371;
CONST RAD          = M_PI * 180;

echo 'Searching the best trip option...' . PHP_EOL;

$cities              = readFromFile();
$citiesWithDistances = calculateDistances($cities);
print_r($citiesWithDistances);
echo 'Thanks to use ZINIO' . PHP_EOL;


function readFromFile(): array
{
    $tab    = "\t";
    $fp     = fopen('citiesSMALL.txt', 'r');
    $cities = [];

    while (!feof($fp)) {
        $line = fgets($fp, 2048);

        $data_txt = str_getcsv($line, $tab);

        $cities[$data_txt[0]] = [
            'latitude'  => $data_txt[1],
            'longitude' => $data_txt[2]
        ];

    }

    fclose($fp);

    return $cities;
}

function calculateDistances(array $cities): array
{
    $tmpCities = $cities;
    $distances = [];
    foreach ($cities as $cityName => $city) {
        foreach ($tmpCities as $tmpCityName => $tmpCity) {

            echo $cityName . ' ' . $tmpCityName . PHP_EOL;

            if ($cityName !== $tmpCityName) {
                $distance = circleDistance(
                    $city['latitude'],
                    $city['longitude'],
                    $tmpCity['latitude'],
                    $tmpCity['longitude']
                );

                $distances[$cityName][$tmpCityName] = $distance;

            }

        }

    }


    return $distances;
}

function circleDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo)
{

    $rad = M_PI / 180;
    //Calculate distance from latitude and longitude
    $theta = $longitudeFrom - $longitudeTo;
    $dist  = sin($longitudeFrom * $rad)
        * sin($latitudeTo * $rad) + cos($latitudeFrom * $rad)
        * cos($latitudeTo * $rad) * cos($theta * $rad);

    return round(acos($dist) / $rad * 60 * 1.853, 0);
}