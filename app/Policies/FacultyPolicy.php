<?php

namespace App\Policies;

use App\Faculty;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FacultyPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }

    /**
     * Determine whether the user can view any faculties.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the faculty.
     *
     * @param  \App\User  $user
     * @param  \App\Faculty  $faculty
     * @return mixed
     */
    public function view(User $user, Faculty $faculty)
    {
        return in_array($user->cluster_id, $faculty->clusters->pluck('id')->toArray());
    }

    /**
     * Determine whether the user can create faculties.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the faculty.
     *
     * @param  \App\User  $user
     * @param  \App\Faculty  $faculty
     * @return mixed
     */
    public function update(User $user, Faculty $faculty)
    {
        return in_array($user->cluster_id, $faculty->clusters->pluck('id')->toArray());
    }

    /**
     * Determine whether the user can delete the faculty.
     *
     * @param  \App\User  $user
     * @param  \App\Faculty  $faculty
     * @return mixed
     */
    public function delete(User $user, Faculty $faculty)
    {
        //
    }

    /**
     * Determine whether the user can restore the faculty.
     *
     * @param  \App\User  $user
     * @param  \App\Faculty  $faculty
     * @return mixed
     */
    public function restore(User $user, Faculty $faculty)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the faculty.
     *
     * @param  \App\User  $user
     * @param  \App\Faculty  $faculty
     * @return mixed
     */
    public function forceDelete(User $user, Faculty $faculty)
    {
        //
    }
}
