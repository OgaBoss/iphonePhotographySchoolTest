<?php

namespace App\Modules\Badge\Events;

use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BadgeUnlocked
{
    use Dispatchable, SerializesModels;

    /** @var string  */
    public string $badgeName;

    /** @var User  */
    public User $user;

    /**
     * @param string $badgeName
     * @param User $user
     */
    public function __construct(string $badgeName, User $user)
    {
        $this->badgeName = $badgeName;
        $this->user = $user;
    }
}
