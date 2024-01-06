<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Destination;
use Faker\Factory;

/**
 * @implements Repository<Destination>
 */
class DestinationRepository implements Repository
{
    public function getById(int $id): Destination
    {
        // DO NOT MODIFY THIS METHOD
        $generator    = Factory::create();
        $generator->seed($id);

        return new Destination(
            $id,
            $generator->country,
            'en',
            $generator->slug()
        );
    }
}
