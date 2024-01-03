<?php

declare(strict_types=1);

namespace App\Tests\Functional\User;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;

class UploadAvatarTest extends UserTestBase
{
    public function testUploadAvatar(): void
    {
        $peterId = $this->getPeterId();
        $avatar = new UploadedFile(
            __DIR__.'/../../../fixtures/avatar.png',
            'avatar.png'
        );

        self::$peter->request(
            'POST',
            \sprintf('%s/%s/avatar', $this->endpoint, $peterId[0]),
            [],
            ['avatar' => $avatar]
        );

        $response = self::$peter->getResponse();

        $this->assertEquals(JsonResponse::HTTP_CREATED, $response->getStatusCode());
    }

    public function testUploadAvatarWithWrongInputName(): void
    {
        $peterId = $this->getPeterId();
        
        $avatar = new UploadedFile(
            __DIR__.'/../../../fixtures/avatar.png',
            'avatar.png'
        );

        self::$peter->request(
            'POST',
            \sprintf('%s/%s/avatar', $this->endpoint, $peterId[0]),
            [],
            ['non-valid-input' => $avatar]
        );

        $response = self::$peter->getResponse();

        $this->assertEquals(JsonResponse::HTTP_BAD_REQUEST, $response->getStatusCode());
    }
}