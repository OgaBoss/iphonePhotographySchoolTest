<?php

namespace App\Modules\Shared\Entities;

class ActionEntity
{
    public int $value;
    public ?string $title;

    public function __construct(int $value, string $title = null)
    {
        $this->value = $value;

        $this->title = $title;
    }
}
