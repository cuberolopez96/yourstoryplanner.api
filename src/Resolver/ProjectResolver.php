<?php

// namespace
namespace App\Resolver;
// importar ResolverMap
use Overblog\GraphQLBundle\Resolver\ResolverMap;
// importar ProjectService
use App\Service\ProjectService;
// importar Project
use App\Entity\Project;

class ProjectResolver extends ResolverMap
{
    public function __construct(
        private ProjectService $projectService
    ) {
    }
    public function map()
    {
        return [
            'ProjectQuery' => [
                'project' => function ($value, $args) {
                    return $this->projectService->getProject($args['id']);
                },
                'projects' => function ($value, $args) {
                    return $this->projectService->getProjects();
                }
            ],
            'ProjectMutation' => [
                'create' => function ($value, $args) {
                    return $this->projectService->createProject($args['title'], $args['description']);
                },
                'update' => function ($value, $args) {
                    return $this->projectService->updateProject($args['id'], $args['title'], $args['description']);
                },
            ]
        ];
    }
}
