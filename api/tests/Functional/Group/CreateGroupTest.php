<?php

declare(strict_types=1);

namespace App\Tests\Functional\Group;

use Symfony\Component\HttpFoundation\JsonResponse;

class CreateGroupTest extends GroupTestBase
{
    public function testCreateGroup(): void
    {
        $peterId = $this->getPeterId();

        $payload = [
            'name' => 'My new group',
            'owner' => \sprintf('/api/v1/users/%s', $peterId[0]),
        ];

        self::$peter->request('POST', $this->endpoint, [], [], [], \json_encode($payload));

        $response = self::$peter->getResponse();
        $responseData = $this->getResponseData($response);

        $this->assertEquals(JsonResponse::HTTP_CREATED, $response->getStatusCode());
        $this->assertEquals($payload['name'], $responseData['name']);
    }

    public function testCreateGroupForAnotherUser(): void
    {
        $peterId = $this->getPeterId();

        $payload = [
            'name' => 'My new group',
            'owner' => \sprintf('/api/v1/users/%s', $peterId[0]),
        ];

        self::$brian->request('POST', $this->endpoint, [], [], [], \json_encode($payload));

        $response = self::$brian->getResponse();
        $responseData = $this->getResponseData($response);

        $this->assertEquals(JsonResponse::HTTP_FORBIDDEN, $response->getStatusCode());
        $this->assertEquals('You can not create groups for another user', $responseData['message']);
    }
}