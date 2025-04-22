<?php

namespace App\Policies;

use App\Models\Ulasan;
use App\Models\User;

class UlasanPolicy
{
    public function update(User $user, Ulasan $ulasan): bool
    {
        return $user->id === $ulasan->user_id;
    }

    public function delete(User $user, Ulasan $ulasan): bool
    {
        return $user->id === $ulasan->user_id;
    }
}
