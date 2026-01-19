<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserPreferenceTheme\UserPreferenceThemeRequest;
use App\Services\UserPreferenceService;

class UserPrefereController extends Controller
{
    public function __construct(private UserPreferenceService $userPrefereService) {}

    public function update(UserPreferenceThemeRequest $request, int $id)
    {
        $input = $request->validated();
        $response = $this->userPrefereService->update($input['theme'], $id);

        return response()->json(
            $response
        );
    }
}
