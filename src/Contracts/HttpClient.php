<?php

namespace GeoService\Contracts;

use GeoService\Http\Response;

interface HttpClient
{
    /**
     * @param string $uri
     * @param array $options
     * @return Response
     */
    public function get(string $uri, array $options = []);

    /**
     * @param string $uri
     * @param array $options
     * @return Response
     */
    public function post(string $uri, array $options = []);
}