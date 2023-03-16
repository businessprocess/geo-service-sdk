<?php

namespace GeoService\Http;

use GeoService\Contracts\HttpClient;
use GuzzleHttp\RequestOptions;
use Illuminate\Http\Client\Factory;
use Illuminate\Http\Client\PendingRequest;

class GuzzleClient implements HttpClient
{
    public const URL = 'https://geo-service.ooo.ua/api/v1/';

    private \GuzzleHttp\Client $http;

    public function __construct(array $config = [])
    {
        $this->http = new \GuzzleHttp\Client([
            'base_uri' => $config['url'] ?? self::URL,
            RequestOptions::HEADERS => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                RequestOptions::CONNECT_TIMEOUT => $config['connect_timeout'] ?? 80,
                RequestOptions::TIMEOUT => $config['timeout'] ?? 30,
                'http_errors' => false,
            ],
        ]);
    }

    /**
     * @return \GuzzleHttp\Client
     */
    public function getHttp(): \GuzzleHttp\Client
    {
        return $this->http;
    }

    /**
     * @param string $uri
     * @param array $options
     * @return Response
     */
    public function get(string $uri, array $options = []): Response
    {
        return new Response($this->getHttp()->get($uri, $options));
    }

    /**
     * @param string $uri
     * @param array $options
     * @return Response
     */
    public function post(string $uri, array $options = [])
    {
        return new Response($this->getHttp()->post($uri, $options));
    }
}