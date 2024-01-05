<?php

declare(strict_types=1);

namespace App\Tests\Functional\User;

use Symfony\Component\HttpFoundation\JsonResponse;

class UpdateUserTest extends UserTestBase
{
    public function testUpdateUser(): void
    {
        $payload = ['name' => 'Peter New'];
        $peterId = $this->getPeterId();
        self::$peter->request(
            'PUT',
            \sprintf('%s/%s', $this->endpoint, $peterId[0]),
            [],
            [],
            [],
            \json_encode($payload)
        );

        $response = self::$peter->getResponse();
        $responseData = $this->getResponseData($response);

        $this->assertEquals(JsonResponse::HTTP_OK, $response->getStatusCode());
        $this->assertEquals($payload['name'], $responseData['name']);
    }

    public function testUpdateAnotherUser(): void
    {
        $payload = ['name' => 'Peter New'];
        $peterId = $this->getPeterId();

        self::$brian->request(
            'PUT',
            \sprintf('%s/%s', $this->endpoint, $peterId[0]),
            [],
            [],
            [],
            \json_encode($payload)
        );

        $response = self::$brian->getResponse();

        $this->assertEquals(JsonResponse::HTTP_FORBIDDEN, $response->getStatusCode());
    }
}