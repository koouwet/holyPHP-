<?php

namespace App\Policies;

use App\Models\Thing;
use App\Models\User;

class ThingPolicy
{
    // смотреть список может любой авторизованный
    public function viewAny(User $user): bool
    {
        return true;
    }

    // смотреть одну вещь может любой авторизованный
    public function view(User $user, Thing $thing): bool
    {
        return true;
    }

    // создавать может любой авторизованный
    public function create(User $user): bool
    {
        return true;
    }

    // обновлять может:
    // - администратор (любую вещь)
    // - обычный пользователь (только свою)
    public function update(User $user, Thing $thing): bool
    {
        if ($user->role === 'admin') {
            return true;
        }

        return $thing->master_id === $user->id;
    }

    // удалять может:
    // - администратор (любую вещь)
    // - обычный пользователь (только свою)
    public function delete(User $user, Thing $thing): bool
    {
        if ($user->role === 'admin') {
            return true;
        }

        return $thing->master_id === $user->id;
    }
}
