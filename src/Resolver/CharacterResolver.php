<?php 

// namespace
namespace App\Resolver;
// importar ResolverMap
use Overblog\GraphQLBundle\Resolver\ResolverMap;
// importar CharacterService
use App\Service\CharacterService;
// importar Character
use App\Entity\Character;

class CharacterResolver extends ResolverMap
{
    public function __construct(
        private CharacterService $characterService
    ) {
    }

    public function map() {
        return [
            'CharacterQuery' => [
                'character' => function ($value, $args) {
                    return $this->characterService->getCharacter($args['id']);
                },
                'characters' => function ($value, $args) {
                    return $this->characterService->getCharacters();
                }
            ],
            'CharacterMutation' => [
                'create' => function ($value, $args) {
                    return $this->characterService->createCharacter(
                        $args['name'],
                        $args['age'],
                        $args['gender'],
                        $args['physicalDescription'],
                        $args['biography'],
                        $args['projectId']
                    );
                },
                'update' => function ($value, $args) {
                    return $this->characterService->updateCharacter(
                        $args['id'],
                        $args['name'],
                        $args['age'],
                        $args['gender'],
                        $args['physicalDescription'],
                        $args['biography']
                    );
                }
            ]
        ];
    }
}
