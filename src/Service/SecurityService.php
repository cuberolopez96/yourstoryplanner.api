<?php

namespace App\Service;

use App\Repository\UserRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use App\Entity\User;

class SecurityService {

    public function __construct(
        private Security $security,
        private UserRepository $userRepository,
        private UserPasswordHasherInterface $passwordHasher,
        private JWTTokenManagerInterface $jwtManager
    ) {}

    public function login(string $email, string $password): array {
        $user = $this->userRepository->findOneBy(['email' => $email]);
        if (!$user) {
            throw new \Exception('Usuario no encontrado');
        }
        if (!$this->passwordHasher->isPasswordValid($user, $password)) {
            throw new \Exception('Contraseña incorrecta');
        }
        $token = $this->jwtManager->create($user);
        return [
            'token' => $token
        ];
    }

    public function getUser(): ?User {
        return $this->security->getUser();
    }    

    public function isGranted(string $role): bool {
        return $this->security->isGranted($role);
    }

}