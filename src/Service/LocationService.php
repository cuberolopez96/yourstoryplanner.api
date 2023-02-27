<?php

namespace App\Service;

use App\Repository\LocationRepository;
use App\Repository\ProjectRepository;
use App\Entity\Location;
use Symfony\Bundle\SecurityBundle\Security;

class LocationService {
    public function __construct(
        private LocationRepository $locationRepository,
        private ProjectRepository $projectRepository,
        private Security $security
    ) {}

    public function createLocation(string $name, string $description, int $projectId): Location {
        $location = new Location();
        $location->setName($name);
        $location->setDescription($description);

        $project = $this->projectRepository->findOneBy([
            'id' => $projectId,
            'user' => $this->security->getUser()
        ]);
        if (!$project) {
            throw new \Exception('Project not found');
        }
        $location->setProject($project);
        $this->locationRepository->save($location, true);

        return $location;
    }

    public function updateLocation(int $id, string $name, string $description): Location {
        $location = $this->locationRepository->findOneByUser($id, $this->security->getUser());
        if (!$location) {
            throw new \Exception('Location not found');
        }
        $location->setName($name);
        $location->setDescription($description);

        $this->locationRepository->save($location, true);

        return $location;
    }

    public function getLocations(): array {
        return $this->locationRepository->findBy($this->security->getUser());
    }

    public function getLocation(int $id): Location {
        return $this->locationRepository->findOneByUser($id, $this->security->getUser());
    }
}
