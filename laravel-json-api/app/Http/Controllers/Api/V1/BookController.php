<?php

namespace App\Http\Controllers\Api\V1;

use CloudCreativity\LaravelJsonApi\Document\Error;
use CloudCreativity\LaravelJsonApi\Http\Controllers\JsonApiController;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BookController extends JsonApiController
{
    /**
     * Update the specified resource.
     * Not named update because it conflicts with JsonApiController update method signature
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function createBook(Request $request): JsonResponse
    {
        $http = new Client(['verify' => false]);

        $headers = $this->parseHeaders($request->header());

        $input = $request->json()->all();

        $data = [
            'headers' => $headers,
            'json' => $input,
            'query' => $request->query()
        ];

        try {
            $response = $http->post(route('api:v1:books.create'), $data);
        } catch (ClientException $e) {

            $errors = json_decode($e->getResponse()->getBody()->getContents(), true)['errors'];

            $errors = collect($errors)->map(function ($error) {
                return Error::create($error);
            })->toArray();

            return $this->reply()->errors($errors);
        }

        $responseBody = json_decode((string)$response->getBody(), true);
        $responseStatus = $response->getStatusCode();
        $responseHeaders = $this->parseHeaders($response->getHeaders());

        unset($responseHeaders['Transfer-Encoding']);

        return response()->json($responseBody, $responseStatus)->withHeaders($responseHeaders);
    }

    /**
     * Parse headers to collapse internal arrays
     * TODO: move to helpers
     *
     * @param array $headers
     * @return array
     */
    protected function parseHeaders(array $headers): array
    {
        return collect($headers)->map(function ($item) {
            return $item[0];
        })->toArray();
    }
}
