<?php

declare(strict_types=1);

namespace App\Tests\Functional\Controller;

use App\Entity\User;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RegistrationControllerTest extends KernelTestCase
{
    use RefreshDatabaseTrait;

    public function testRegistration(): void
    {
        self::bootKernel();

        // Given : I have a registration request
        $request = Request::create(
            '/api/registration',
            Request::METHOD_POST,
            server: [
                'Content-Type' => 'application/json',
            ],
            content: <<<JSON
{
    "email": "VALb5LdWV8jZg7G@TrKJBw.it",
    "username": "username",
    "password": "password"
}
JSON
        );

        // When : I receive this request
        $response = self::$kernel->handle($request);

        // Then : I have a response with status code 201 and user is created in database
        self::assertSame(Response::HTTP_CREATED, $response->getStatusCode(), $response->getContent());
        $entityManager = static::$kernel->getContainer()->get('doctrine')->getManager();
        $userRepository = $entityManager->getRepository(User::class);
        $createdUser = $userRepository->findOneBy(['email' => 'VALb5LdWV8jZg7G@TrKJBw.it']);
        self::assertEquals('VALb5LdWV8jZg7G@TrKJBw.it', $createdUser->getEmail());
        self::assertEquals('username', $createdUser->getUsername());
        self::assertNotNull($createdUser->getPassword());
    }

    public function testRegistrationWithMissingData(): void
    {
        self::bootKernel();

        // Given : I have a registration request
        $request = Request::create(
            '/api/registration',
            Request::METHOD_POST,
            server: [
                'Content-Type' => 'application/json',
            ],
            content: <<<JSON
{
}
JSON
        );

        // When : I receive this request
        $response = self::$kernel->handle($request);

        // Then : I have a response with status code 400 with correct error message
        self::assertSame(Response::HTTP_BAD_REQUEST, $response->getStatusCode(), $response->getContent());
        self::assertJsonStringEqualsJsonString(
            <<<JSON
{
  "message": "User not valid",
  "errors": {
    "email": [
      "This value should not be blank.",
      "This value is too short. It should have 5 characters or more."
    ],
    "password": [
      "This value should not be blank.",
      "This value is too short. It should have 5 characters or more."
    ],
    "username": [
      "This value should not be blank.",
      "This value is too short. It should have 2 characters or more."
    ]
  }
}
JSON,
            $response->getContent()
        );
    }

    public function testRegistrationWithBadEmail(): void
    {
        self::bootKernel();

        // Given : I have a registration request
        $request = Request::create(
            '/api/registration',
            Request::METHOD_POST,
            server: [
                'Content-Type' => 'application/json',
            ],
            content: <<<JSON
{
    "email": "bad-email",
    "username": "username",
    "password": "password"
}
JSON
        );

        // When : I receive this request
        $response = self::$kernel->handle($request);

        // Then : I have a response with status code 400 with correct error message
        self::assertSame(Response::HTTP_BAD_REQUEST, $response->getStatusCode(), $response->getContent());
        self::assertJsonStringEqualsJsonString(
            <<<JSON
{
    "errors": {
        "email": [
            "This value is not a valid email address."
        ]
    },
    "message": "User not valid"
}
JSON,
            $response->getContent()
        );
    }
}
