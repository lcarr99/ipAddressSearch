<?php

namespace App\Services;

use GuzzleHttp\Client;

class IPSearchService
{
    private const URL = 'http://ip2c.org/';

    public static function getDataByAddress(string $ip): string
    {
        $client = new Client();

        $response = $client->get(self::URL . $ip);

        return $response->getBody();
    }

    public static function parseResponse(string $response): array
    {
        return explode(';', $response);
    }
}
