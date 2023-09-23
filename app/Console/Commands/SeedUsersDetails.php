<?php

namespace App\Console\Commands;

use App\Models\Comment;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class SeedUsersDetails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:seed-users-details {lessons=25} {comments=20}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        Artisan::call('migrate:fresh ');

        User::factory()
            ->has(Comment::factory()->count($this->argument('comments')))
            ->hasAttached(Lesson::factory()->count($this->argument('lessons')),
            ['watched' => true])
            ->create();
    }
}
