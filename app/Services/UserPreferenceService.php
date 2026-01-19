<?php

namespace App\Services;

use App\Models\UserPreference;

class UserPreferenceService
{
    public function update(string $theme, int $id)
    {

        if (! $id) {
            throw new \Exception('User preference not found');
        }

        $userPreference = UserPreference::find($id);
        if (! $userPreference) {
            throw new \Exception('User preference not found');
        }
        $response = $userPreference->update([
            'value' => $theme,
        ]);

        if ($userPreference) {
            return true;
        }

        return false;

    }
}
