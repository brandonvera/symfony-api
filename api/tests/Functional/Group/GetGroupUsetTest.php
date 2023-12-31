<?php

declare(strict_types=1);

namespace App\Tests\Functional\Group;

use Symfony\Component\HttpFoundation\JsonResponse;

class GetGroupUsersTest extends GroupTestBase
{
    public function testGetGroupUsers(): void
    {
        $getPeterGroupId = $this->getPeterGroupId();

        self::$peter->request('GET', \sprintf('%s/%s/users', $this->endpoint, $getPeterGroupId[0]));

        $response = self::$peter->getResponse();
        $responseData = $this->getResponseData($response);

        $this->assertEquals(JsonResponse::HTTP_OK, $response->getStatusCode());
        $this->assertCount(1, $responseData['hydra:member']);
    }

    public function testGetAnotherGroupUsers(): void
    {
        $getPeterGroupId = $this->getPeterGroupId();
        
        self::$brian->request('GET', \sprintf('%s/%s/users', $this->endpoint, $getPeterGroupId[0]));

        $response = self::$brian->getResponse();
        $responseData = $this->getResponseData($response);

        $this->assertEquals(JsonResponse::HTTP_FORBIDDEN, $response->getStatusCode());
        $this->assertEquals('You can\'t retrieve users of another group', $responseData['message']);
    }
}