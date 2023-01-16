<?php

namespace Jordanbaindev\Wipay\App\Http\Controllers\API;

use App\Exceptions\InvalidParameterException;
use GuzzleHttp\Client;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class AbstractAPI
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Send GET request
     *
     * @param string $path
     * @param array $params
     * @param array $rules
     * @param array $headers
    //  * @return Collection
     */
    public function get(string $path, array $params, array $rules = [], array $headers = null)
    {
        $validated = $this->validation($params, $rules);

        return $this->client->request('GET', $path, $validated);
    }

    /**
     * Send post request
     *
     * @param string $path
     * @param array $params
     * @param array $rules
     * @param array $headers
    //  * @return Collection
     */
    public function post(string $path, array $params, array $rules = [], array $headers = null)
    {
        $validated = $this->validation($params, $rules);

        return $this->client->request('POST', $path, $validated);
    }

    /**
     * Decode response or return response object on error
     *
     * @param Response $response
     * @return Collection
     * @throws ResponseException
     */
    private function decodeResponse(Response $response)
    {
        if ($response->failed()) $response->throw();
        return $response->collect();
    }

    /**
     * Validate parameters
     *
     * @param string $path
     * @param array $params
     * @param array $rules
     * @return array
     * @throws InvalidParameterException
     */
    private function validation(array $params, array $rules)
    {
        $validator = Validator::make($params, $rules);

        if ($validator->fails()) throw new InvalidParameterException(implode("; ", $validator->errors()->all()), 1);

        return $validator->validated();
    }
}