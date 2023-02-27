<?php 

namespace App\Service;

use App\Entity\Project;
use App\Repository\ProjectRepository;
use Symfony\Bundle\SecurityBundle\Security;

class ProjectService {
    public function __construct(
        private ProjectRepository $projectRepository,
        private Security $security
    ) {}

    public function createProject(string $title, string $description): Project {
        $project = new Project();
        $project->setTitle($title);
        $project->setDescription($description);
        $project->setUser($this->security->getUser());

        $this->projectRepository->save($project, true);

        return $project;
    }

    public function updateProject(int $id, string $title, string $description): Project {
        $project = $this->projectRepository->find([
            'id' => $id,
            'user' => $this->security->getUser()
        ]);
        $project->setTitle($title);
        $project->setDescription($description);

        $this->projectRepository->save($project, true);

        return $project;
    }

    public function getProjects(): array {
        return $this->projectRepository->findBy([
            'user' => $this->security->getUser()
        ]);
    }

    public function getProject(int $id): Project {
        return $this->projectRepository->find($id);
    }
}