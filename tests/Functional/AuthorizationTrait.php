<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

trait AuthorizationTrait
{
    public function getAuthorizationToken($kernel): string
    {
        $request = Request::create(
            '/api/login',
            Request::METHOD_POST,
            server: [
                'CONTENT_TYPE' => 'application/json',
            ],
            content: <<<JSON
{
    "username": "user@email.fr",
    "password": "password"
}
JSON
        );
        $response = $kernel->handle($request);
        self::assertSame(Response::HTTP_OK, $response->getStatusCode(), $response->getContent());
        $data = json_decode($response->getContent(), true);

        return $data['token'];
    }
}
