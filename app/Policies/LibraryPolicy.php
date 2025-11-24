<?php

namespace App\Policies;

use App\Models\Library;
use App\Models\User;

class LibraryPolicy
{
    public function manage(User $user, Library $library): bool
    {
        return $user->library_uid === $library->uid && $user->isAdmin();
    }

    public function viewLibrary(User $user, Library $library): bool
    {
        return $user->library_uid === $library->uid && $user->is_active;
    }

    public function createStaff(User $user, Library $library): bool
    {
        return $user->library_uid === $library->uid && $user->isAdmin();
    }

    public function deactivateUser(User $user, User $staffUser, Library $library): bool
    {
        return $user->library_uid === $library->uid &&
               $user->isAdmin() &&
               $staffUser->library_uid === $library->uid;
    }
}
