<?php

namespace App\Policies;

use App\Enrollment;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class EnrollmentPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }

    /**
     * Determine whether the user can view any enrollments.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the enrollment.
     *
     * @param  \App\User  $user
     * @param  \App\Enrollment  $enrollment
     * @return mixed
     */
    public function view(User $user, Enrollment $enrollment)
    {
        return $user->cluster_id === $enrollment->program->cluster->id;
    }

    /**
     * Determine whether the user can create enrollments.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        // if the requested student_id_number is in the array of user's students
        return in_array(app('request')->get('student_id_number'), $user->cluster->students->pluck('id_number')->toArray())
            ? Response::allow()
            : Response::deny('The student does not belong to your cluster.');
    }

    /**
     * Determine whether the user can update the enrollment.
     *
     * @param  \App\User  $user
     * @param  \App\Enrollment  $enrollment
     * @return mixed
     */
    public function update(User $user, Enrollment $enrollment)
    {
        //
    }

    /**
     * Determine whether the user can delete the enrollment.
     *
     * @param  \App\User  $user
     * @param  \App\Enrollment  $enrollment
     * @return mixed
     */
    public function delete(User $user, Enrollment $enrollment)
    {
        //
    }

    /**
     * Determine whether the user can restore the enrollment.
     *
     * @param  \App\User  $user
     * @param  \App\Enrollment  $enrollment
     * @return mixed
     */
    public function restore(User $user, Enrollment $enrollment)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the enrollment.
     *
     * @param  \App\User  $user
     * @param  \App\Enrollment  $enrollment
     * @return mixed
     */
    public function forceDelete(User $user, Enrollment $enrollment)
    {
        //
    }
}
