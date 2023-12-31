<?php

declare(strict_types=1);

namespace App\Tests\Functional\Group;

use Symfony\Component\HttpFoundation\JsonResponse;

class DeleteGroupTest extends GroupTestBase
{
    public function testDeleteGroup(): void
    {
        $getPeterGroupId = $this->getPeterGroupId();

        self::$peter->request(
            'DELETE',
            \sprintf('%s/%s', $this->endpoint, $getPeterGroupId[0]),
        );

        $response = self::$peter->getResponse();

        $this->assertEquals(JsonResponse::HTTP_NO_CONTENT, $response->getStatusCode());
    }

    public function testDeleteAnotherGroup(): void
    {
        $getPeterGroupId = $this->getPeterGroupId();

        self::$brian->request(
            'DELETE',
            \sprintf('%s/%s', $this->endpoint, $getPeterGroupId[0]),
        );

        $response = self::$brian->getResponse();

        $this->assertEquals(JsonResponse::HTTP_FORBIDDEN, $response->getStatusCode());
    }
}