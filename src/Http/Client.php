<?php

namespace GeoService\Http;

use GeoService\Contracts\HttpClient;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\Factory;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;

class Client implements HttpClient
{
    protected PendingRequest|Factory $http;

    private array $config;

    public function __construct(Factory $factory, array $config = [])
    {
        $this->processOptions($config);

        $this->http = $factory->asJson()
            ->acceptJson()
            ->withHeaders(['Accept-Language' => $this->config['locale'] ?? app()->getLocale()])
            ->baseUrl($this->config['url'] ?? HttpClient::URL)
            ->timeout(30);
    }

    public function getHttp(): Factory|PendingRequest
    {
        return $this->http;
    }

    public function processOptions($config): void
    {
        if (! isset($config['url'])) {
            throw new \InvalidArgumentException('Url is required');
        }
        $this->config = $config;
    }

    /**
     * @throws \Exception
     */
    public function request(string $method, string $uri, array $options = []): PromiseInterface|Response
    {
        return $this->getHttp()->send($method, $uri, $options);
    }

    public function get(string $uri, array $options = []): PromiseInterface|Response
    {
        return $this->getHttp()->get($uri, $options);
    }

    public function post(string $uri, array $options = []): PromiseInterface|Response
    {
        return $this->getHttp()->post($uri, $options);
    }
}
