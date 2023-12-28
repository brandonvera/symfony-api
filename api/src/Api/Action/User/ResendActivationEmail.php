<?php

declare(strict_types=1);

namespace App\Api\Action\User;

use App\Service\User\ResendActivationEmailService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class ResendActivationEmail
{
    private ResendActivationEmailService $activationEmailService;

    public function __construct(ResendActivationEmailService $activationEmailService)
    {
        $this->activationEmailService = $activationEmailService;
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function __invoke(Request $request): JsonResponse
    {
        $this->activationEmailService->resend(RequestService::getField($request, 'email'));

        return new JsonResponse(['message' => 'Activation email sent']);
    }
}