<?php

namespace App\Modules\Shared\Entities;

class ActionEntity
{
    /** @var int  */
    public int $value;

    /** @var string|null  */
    public ?string $title;

    /**
     * @param int $value
     * @param string|null $title
     */
    public function __construct(int $value, string $title = null)
    {
        $this->value = $value;

        $this->title = $title;
    }
}
