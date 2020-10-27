<?php

declare(strict_types=1);

namespace App\UI\Presenter;

class Presenter
{
    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }
}
