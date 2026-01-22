<?php

namespace App\Policies;

use App\Models\Place;
use App\Models\User;

class PlacePolicy
{
    // смотреть список может любой авторизованный
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Place $place): bool
    {
        return true;
    }

    // создавать/менять/удалять — только админ
    public function create(User $user): bool
    {
        return $user->role === 'admin';
    }

    public function update(User $user, Place $place): bool
    {
        return $user->role === 'admin';
    }

    public function delete(User $user, Place $place): bool
    {
        return $user->role === 'admin';
    }
}

