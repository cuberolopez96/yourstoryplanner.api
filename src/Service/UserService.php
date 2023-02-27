<?php

namespace App\Service;

use App\Repository\UserRepository;
use App\Entity\User;
// importa la clase UserPasswordHasherInterface
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService {
    public function __construct(
        private UserRepository $userRepository,
        private UserPasswordHasherInterface $passwordHasher
    ) {}

    public function createUser(string $email, string $password): User {
        $user = $this->userRepository->findOneBy(['email' => $email]);
        if ($user) {
            throw new \Exception('Usuario ya existe');
        }
        $user = new User();
        $user->setEmail($email);
        $user->setPassword($this->passwordHasher->hashPassword($user, $password));
        $this->userRepository->save($user, true);
        return $user;
    }

}