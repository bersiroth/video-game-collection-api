<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\User;
use App\Exception\InvalidEntityException;
use Ramsey\Uuid\Uuid;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserFactory
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher,
        private ValidatorInterface $validator
    ) {
    }

    /**
     * @throws InvalidEntityException
     */
    public function create(string $email, string $plainPassword, string $username): User
    {
        $user = new User();

        $user->setUuid(Uuid::uuid4());
        $user->setEmail($email);
        $user->setUsername($username);
        $hashedPassword = '' !== $plainPassword ? $this->passwordHasher->hashPassword($user, $plainPassword) : '';
        $user->setPassword($hashedPassword);

        $violations = $this->validator->validate($user);
        if (count($violations) > 0) {
            throw new InvalidEntityException('User not valid', $violations);
        }

        return $user;
    }
}
