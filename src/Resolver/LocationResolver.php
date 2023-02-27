<?php

namespace App\Resolver;

use App\Service\LocationService;
use Overblog\GraphQLBundle\Resolver\ResolverMap;

class LocationResolver extends ResolverMap {
    public function __construct(
        private LocationService $locationService
    ) {}

    public function map() {
        return [
            'LocationQuery' => [
                'location' => function ($value, $args) {
                    return $this->locationService->getLocation($args['id']);
                },
                'locations' => function ($value, $args) {
                    return $this->locationService->getLocations();
                }
            ],
            'LocationMutation' => [
                'create' => function ($value, $args) {
                    return $this->locationService->createLocation(
                        $args['name'],
                        $args['description'],
                        $args['projectId']
                    );
                },
                'update' => function ($value, $args) {
                    return $this->locationService->updateLocation(
                        $args['id'],
                        $args['name'],
                        $args['description']
                    );
                }
            ]
        ];
    }
}