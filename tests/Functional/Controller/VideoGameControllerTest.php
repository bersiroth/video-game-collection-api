<?php

declare(strict_types=1);

namespace App\Tests\Functional\Controller;

use App\Tests\Functional\AuthorizationTrait;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class VideoGameControllerTest extends KernelTestCase
{
    use RefreshDatabaseTrait;
    use AuthorizationTrait;

    public function testGetVideoGamePaginatedList(): void
    {
        self::bootKernel();

        // Given : I have a video games request
        $request = Request::create(
            '/api/video-games?page=2&limit=3',
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
        self::assertEquals(2, $content['page']);
        self::assertEquals(3, $content['limit']);
        self::assertCount(3, $content['videoGames']);
        $firstGame = $content['videoGames'][0];
        self::assertEquals('God of War', $firstGame['name']);
        self::assertEquals('Action', $firstGame['genre'][0]);
        self::assertEquals('Adventure', $firstGame['genre'][1]);
    }

    public function testGetVideoGamePaginatedListWithDefaultPaginationValue(): void
    {
        self::bootKernel();

        // Given : I have a video games request without pagination parameters
        $request = Request::create(
            '/api/video-games',
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
        self::assertEquals(1, $content['page']);
        self::assertEquals(5, $content['limit']);
        self::assertCount(5, $content['videoGames']);
        $firstGame = $content['videoGames'][0];
        self::assertEquals('The last of us', $firstGame['name']);
        self::assertEquals('Action', $firstGame['genre'][0]);
        self::assertEquals('Survival-Horror', $firstGame['genre'][1]);
    }
}
