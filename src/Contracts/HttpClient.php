<?php

namespace GeoService\Contracts;

interface HttpClient
{
    public function get(string $uri, array $options = []);

    public function post(string $uri, array $options = []);
}