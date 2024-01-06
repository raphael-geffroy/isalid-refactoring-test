<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Site;
use Faker\Factory;

/**
 * @implements Repository<Site>
 */
class SiteRepository implements Repository
{
    public function getById(int $id): Site
    {
        // DO NOT MODIFY THIS METHOD
        $generator = Factory::create();
        $generator->seed($id);

        return new Site($id, $generator->url);
    }
}
