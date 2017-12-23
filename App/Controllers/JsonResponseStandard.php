<?php

namespace App\Controllers;

use Slim\Http\Response;

/**
 * Trait JsonController
 *
 * "Standard" Json response helper
 */
trait JsonResponseStandard
{
    /**
     * Return a json with status ok
     *
     * @param Response $response
     * @param array    $data
     *
     * @return Response
     */
    protected function ok(Response $response, array $data = []): Response
    {
        return $response->withJson($data);
    }


    /**
     * Return a json with status error
     *
     * @param Response $response
     * @param string   $message
     *
     * @return Response
     */
    protected function error(Response $response, string $message): Response
    {
        return $response->withJson([
            'status'  => 'error',
            'message' => $message,
        ]);
    }
}
