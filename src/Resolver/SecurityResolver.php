<?php

namespace App\Resolver;

use Overblog\GraphQLBundle\Resolver\ResolverMap;
use App\Service\SecurityService;
use App\Service\UserService;

class SecurityResolver extends ResolverMap
{
    public function __construct(
        private SecurityService $securityService,
        private UserService $userService
    ) {}
    protected function map(): array
    {
        return [
            'SecurityQuery' => [
                'me' => function ($value, $args, $context, $info) {
                    return $this->securityService->getUser();
                },
                'isGranted' => function ($value, $args, $context, $info) {
                    return $this->securityService->isGranted($args['role']);
                }
            ],
            'SecurityMutation' => [
                'login' => function ($value, $args, $context, $info) {
                    return $this->securityService->login($args['email'], $args['password']);
                },
                'register' => function ($value, $args, $context, $info) {
                    return $this->userService->createUser($args['email'], $args['password']);
                }
            ]
        ];
    }
}