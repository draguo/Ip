<?php

namespace Draguo\Ip\Support;


use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

trait HttpRequest
{
    /**
     * @param string $endpoint
     * @param array  $query
     * @param array  $headers
     *
     * @return array
     */
    protected function getRequest($endpoint, $query = [], $headers = [])
    {
        return $this->request('get', $endpoint, [
            'headers' => $headers,
            'query'   => $query,
        ]);
    }

    /**
     * @param string $endpoint
     * @param array  $params
     * @param array  $headers
     *
     * @return array
     */
    protected function postRequest($endpoint, $params = [], $headers = [])
    {
        return $this->request('post', $endpoint, [
            'headers'     => $headers,
            'form_params' => $params
        ]);
    }

    /**
     * @param       $method
     * @param       $endpoint
     * @param array $options
     *
     * @return mixed
     */
    protected function request($method, $endpoint, $options = [])
    {
        return $this->unwrapResponse($this->getHttpClient($this->getBaseOptions())
                                          ->{$method}($endpoint, $options));
    }

    protected function getBaseOptions()
    {
        $options = [
            'base_uri' => method_exists($this, 'getBaseUri')
                ? $this->getBaseUri() : '',
            'timeout'  => property_exists($this, 'timeout') ? $this->timeout
                : 5.0,
        ];

        return $options;
    }

    protected function getHttpClient(array $options = [])
    {
        return new Client($options);
    }

    protected function unwrapResponse(ResponseInterface $response)
    {
        $contentType = $response->getHeaderLine('Content-Type');
        $contents = $response->getBody()->getContents();
        if (false !== stripos($contentType, 'json')) {
            return json_decode($contents, true);
        } elseif (false !== stripos($contentType, 'xml')) {
            return json_decode(json_encode(simplexml_load_string($contents)),
                true);
        }

        return $contents;
    }
}