<?php

declare(strict_types=1);

namespace App\Exception\User;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserNotFoundException extends NotFoundHttpException
{
    //mensaje de excepcion
    private const MESSAGE = 'User with email %s not found';

    //funcion estatica
    public static function fromEmail(string $email): self
    {
        //lanzando exceocion de si misma (self)
        throw new self(\sprintf(self::MESSAGE, $email));
    }

    public static function fromUserIdAndToken(string $id, string $token): self
    {
        throw new self(\sprintf('User with id %s and token %s not found', $id, $token));
    }
}