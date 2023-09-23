<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Modules\API\AchievementService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AchievementsController extends Controller
{
    public AchievementService $service;

    /**
     * @param AchievementService $service
     */
    public function __construct(AchievementService $service)
    {
        $this->service = $service;
    }

    public function index(User $user): JsonResponse
    {
        try {
            $this->service->user = $user;
            return response()->json($this->service->execute());
        } catch(\Throwable $exception) {
            return response()->json('error', 500);
        }
    }
}
