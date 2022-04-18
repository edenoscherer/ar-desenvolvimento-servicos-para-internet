<?php

declare(strict_types=1);

namespace App\Libs;


use Slim\Psr7\Stream;
use Psr\Http\Message\ResponseInterface as Response;


abstract class BaseController
{


    protected function renderJson(Response $response, $data, ?int $status = HttpStatusCode::HTTP_OK, ?int $encodingOptions = JSON_PRETTY_PRINT): Response
    {
        $response = $response->withBody(new Stream(fopen('php://temp', 'r+')));
        $response->getBody()->write($json = json_encode($data, $encodingOptions));
        if ($json === false) {
            throw new \RuntimeException(json_last_error_msg(), json_last_error());
        }

        $responseWithJson = $response->withHeader('Content-Type', 'application/json');
        if (isset($status)) {
            return $responseWithJson->withStatus($status);
        }
        return $responseWithJson;
    }
}
