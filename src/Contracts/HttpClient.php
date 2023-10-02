<?php

namespace GeoService\Contracts;

use GeoService\Http\Response;

interface HttpClient
{
    public const URL = 'https://geo-service.ooo.ua/api/v1/';

    /**
     * @return Response
     */
    public function get(string $uri, array $options = []);

    /**
     * @return Response
     */
    public function post(string $uri, array $options = []);
}
