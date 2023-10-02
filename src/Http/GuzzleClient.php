<?php

namespace GeoService\Http;

use GeoService\Contracts\HttpClient;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;

class GuzzleClient implements HttpClient
{
    private \GuzzleHttp\Client $http;

    public function __construct(array $config = [])
    {
        $this->http = new \GuzzleHttp\Client([
            'base_uri' => $config['url'] ?? HttpClient::URL,
            RequestOptions::HEADERS => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'Accept-Language' => $config['locale'] ?? 'ru-RU',
                RequestOptions::CONNECT_TIMEOUT => $config['connect_timeout'] ?? 80,
                RequestOptions::TIMEOUT => $config['timeout'] ?? 30,
                'http_errors' => false,
            ],
        ]);
    }

    public function getHttp(): \GuzzleHttp\Client
    {
        return $this->http;
    }

    public function get(string $uri, array $options = []): Response
    {
        return new Response($this->getHttp()->get($uri, [RequestOptions::QUERY => $options]));
    }

    /**
     * @return Response
     * @throws GuzzleException
     */
    public function post(string $uri, array $options = [])
    {
        return new Response($this->getHttp()->post($uri, [RequestOptions::JSON => $options]));
    }
}
