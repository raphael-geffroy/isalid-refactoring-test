<?php

declare(strict_types=1);

namespace App\Repository;

/**
 * @template T
 */
interface Repository
{
    /**
     * @return T
     */
    public function getById(int $id): mixed;
}
