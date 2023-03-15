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
            ->baseUrl($this->config['url'])
            ->async($this->config['async'] ?? false)
            ->timeout(30);
    }

    /**
     * @return Factory|PendingRequest
     */
    public function getHttp(): Factory|PendingRequest
    {
        return $this->http;
    }

    /**
     * @param $config
     * @return void
     */
    public function processOptions($config): void
    {
        if (!isset($config['url'])) {
            throw new \InvalidArgumentException('Url is required');
        }
        $this->config = $config;
    }

    /**
     * @param string $method
     * @param string $uri
     * @param array $options
     * @return PromiseInterface|Response
     * @throws \Exception
     */
    public function request(string $method, string $uri, array $options = []): PromiseInterface|Response
    {
        return $this->getHttp()->send($method, $uri, $options);
    }

    /**
     * @param string $uri
     * @param array $options
     * @return PromiseInterface|Response
     */
    public function get(string $uri, array $options = []): PromiseInterface|Response
    {
        return $this->getHttp()->get($uri, $options);
    }

    /**
     * @param string $uri
     * @param array $options
     * @return PromiseInterface|Response
     */
    public function post(string $uri, array $options = []): PromiseInterface|Response
    {
        return $this->getHttp()->post($uri, $options);
    }
}