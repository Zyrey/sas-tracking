<?php

namespace App\Policies;

use App\EnrolledCourse;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EnrolledCoursePolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }

    /**
     * Determine whether the user can view any enrolled courses.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the enrolled course.
     *
     * @param  \App\User  $user
     * @param  \App\EnrolledCourse  $enrolledCourse
     * @return mixed
     */
    public function view(User $user, EnrolledCourse $enrolledCourse)
    {
        return $user->cluster_id === $enrolledCourse->enrollment->program->cluster->id;
    }

    /**
     * Determine whether the user can create enrolled courses.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the enrolled course.
     *
     * @param  \App\User  $user
     * @param  \App\EnrolledCourse  $enrolledCourse
     * @return mixed
     */
    public function update(User $user, EnrolledCourse $enrolledCourse)
    {
        return $user->cluster_id === $enrolledCourse->enrollment->program->cluster->id;
    }

    /**
     * Determine whether the user can delete the enrolled course.
     *
     * @param  \App\User  $user
     * @param  \App\EnrolledCourse  $enrolledCourse
     * @return mixed
     */
    public function delete(User $user, EnrolledCourse $enrolledCourse)
    {
        //
    }

    /**
     * Determine whether the user can restore the enrolled course.
     *
     * @param  \App\User  $user
     * @param  \App\EnrolledCourse  $enrolledCourse
     * @return mixed
     */
    public function restore(User $user, EnrolledCourse $enrolledCourse)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the enrolled course.
     *
     * @param  \App\User  $user
     * @param  \App\EnrolledCourse  $enrolledCourse
     * @return mixed
     */
    public function forceDelete(User $user, EnrolledCourse $enrolledCourse)
    {
        //
    }
}
