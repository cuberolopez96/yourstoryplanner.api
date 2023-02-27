<?php

namespace App\Service;

use App\Entity\Character;
use Symfony\Bundle\SecurityBundle\Security;
use App\Repository\CharacterRepository;
use App\Repository\ProjectRepository;

class CharacterService
{
    public function __construct(
        private CharacterRepository $characterRepository,
        private Security $security,
        private ProjectRepository $projectRepository
    ) {
    }

    public function createCharacter(
        string $name,
        int $age,
        string $gender,
        string $physicalDescription,
        string $biography,
        int $projectId
    ): Character {
        $character = new Character();
        $character->setName($name);
        $character->setAge($age);
        $character->setGender($gender);
        $character->setPhysicalDescription($physicalDescription);
        $character->setBiography($biography);

        $project = $this->projectRepository->findOneBy([
            'id' => $projectId,
            'user' => $this->security->getUser()
        ]);
        if (!$project) {
            throw new \Exception('Project not found');
        }
        $character->setProject($project);
        $this->characterRepository->save($character, true);

        return $character;
    }

    public function updateCharacter(
        int $id,
        string $name,
        int $age,
        string $gender,
        string $physicalDescription,
        string $biography,
    ): Character {
        $character = $this->characterRepository->findOneByUser($id, $this->security->getUser());
        if (!$character) {
            throw new \Exception('Character not found');
        }
        $character->setName($name);
        $character->setAge($age);
        $character->setGender($gender);
        $character->setPhysicalDescription($physicalDescription);
        $character->setBiography($biography);

        $this->characterRepository->save($character, true);

        return $character;
    }

    // obten todos los personajes
    public function getCharacters(): array
    {
        return $this->characterRepository->findByUser($this->security->getUser());
    }

    // obten un personaje
    public function getCharacter(int $id): Character
    {
        return $this->characterRepository->findOneByUser($id, $this->security->getUser());
    }
}
