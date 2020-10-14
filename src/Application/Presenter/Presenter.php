<?php

declare(strict_types=1);

namespace App\Application\Presenter;

class Presenter
{
    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }
}
