<?php

declare(strict_types=1);

namespace App\Tests\Functional\Controller;

use App\Tests\Functional\AuthorizationTrait;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProfileControllerTest extends KernelTestCase
{
    use RefreshDatabaseTrait;
    use AuthorizationTrait;

    public function testGetProfile(): void
    {
        self::bootKernel();

        // Given : I have a profile request
        $request = Request::create(
            '/api/profile',
            Request::METHOD_GET,
            server: [
                'CONTENT_TYPE' => 'application/json',
                'HTTP_Authorization' => 'Bearer '.$this->getAuthorizationToken(self::$kernel),
            ]
        );

        // When : I receive this request
        $response = self::$kernel->handle($request);

        // Then : I have a response with status code 200 with good content
        self::assertSame(Response::HTTP_OK, $response->getStatusCode(), $response->getContent());
        $content = json_decode($response->getContent(), true);
        self::assertEquals('1dc51b42-cc9a-4a19-a195-953a42893c4a', $content['id']);
        self::assertEquals('user@email.fr', $content['email']);
        self::assertIsString($content['username']);
    }

    public function testGetProfileWithoutToken(): void
    {
        self::bootKernel();

        // Given : I have a profile request
        $request = Request::create(
            '/api/profile',
            Request::METHOD_GET,
            server: [
                'CONTENT_TYPE' => 'application/json',
            ]
        );

        // When : I receive this request
        $response = self::$kernel->handle($request);

        // Then : I have a response with status code 401 with good content
        self::assertSame(Response::HTTP_UNAUTHORIZED, $response->getStatusCode(), $response->getContent());
        $content = json_decode($response->getContent(), true);
        self::assertEquals('JWT Token not found', $content['message']);
    }

    public function testGetProfileWithBadToken(): void
    {
        self::bootKernel();

        // Given : I have a profile request
        $request = Request::create(
            '/api/profile',
            Request::METHOD_GET,
            server: [
                'CONTENT_TYPE' => 'application/json',
                'HTTP_Authorization' => 'Bearer badtoken',
            ]
        );

        // When : I receive this request
        $response = self::$kernel->handle($request);

        // Then : I have a response with status code 401 with good content
        self::assertSame(Response::HTTP_UNAUTHORIZED, $response->getStatusCode(), $response->getContent());
        $content = json_decode($response->getContent(), true);
        self::assertEquals('Invalid JWT Token', $content['message']);
    }
}
