<?php

declare(strict_types=1);

namespace App\Entity;

class Site
{
    public $id;
    public $url;

    public function __construct($id, $url)
    {
        $this->id = $id;
        $this->url = $url;
    }
}
