<?php

namespace App\Modules\Achievement\Events;

use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AchievementUnlocked
{

    use Dispatchable, SerializesModels;

    /** @var string  */
    public string $achievementName;

    /** @var User  */
    public User $user;

    /**
     * @param string $achievementName
     * @param User $user
     */
    public function __construct(string $achievementName, User $user)
    {
        $this->achievementName = $achievementName;
        $this->user = $user;
    }
}
