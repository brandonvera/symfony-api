<?php

declare(strict_types=1);

namespace App\Tests\Functional\Group;

use Symfony\Component\HttpFoundation\JsonResponse;

class UpdateGroupTest extends GroupTestBase
{
    public function testUpdateGroup(): void
    {
        $payload = ['name' => 'New group name'];
        $peterGroupId = $this->getPeterGroupId();
        
        self::$peter->request(
            'PUT',
            \sprintf('%s/%s', $this->endpoint, $peterGroupId[0]),
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

    public function testUpdateAnotherGroup(): void
    {
        $payload = ['name' => 'New group name'];
        $peterGroupId = $this->getPeterGroupId();

        self::$brian->request(
            'PUT',
            \sprintf('%s/%s', $this->endpoint, $peterGroupId[0]),
            [],
            [],
            [],
            \json_encode($payload)
        );

        $response = self::$brian->getResponse();

        $this->assertEquals(JsonResponse::HTTP_FORBIDDEN, $response->getStatusCode());
    }
}