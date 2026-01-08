<?php
declare(strict_types=1);
namespace App\Policies;
use App\Models\User;
class UserPolicy
{
    /**
     * Admins can delete users, but not themselves.
     * Safety: don\'t allow deleting other admins.
     */
    public function delete(User $actor, User $target): bool
    {
        if (! ($actor->is_admin ?? false)) {
            return false;
        }
        if ($actor->id === $target->id) {
            return false;
        }
        if (($target->is_admin ?? false) === true) {
            return false;
        }
        return true;
    }
}