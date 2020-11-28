<?php

namespace App\Policies;

use App\Cluster;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClusterPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }

    /**
     * Determine whether the user can view any clusters.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the cluster.
     *
     * @param  \App\User  $user
     * @param  \App\Cluster  $cluster
     * @return mixed
     */
    public function view(User $user, Cluster $cluster)
    {
        if (!$user->isAdmin()) {
            return $user->cluster_id === $cluster->id;
        }
    }

    /**
     * Determine whether the user can create clusters.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the cluster.
     *
     * @param  \App\User  $user
     * @param  \App\Cluster  $cluster
     * @return mixed
     */
    public function update(User $user, Cluster $cluster)
    {
        //
    }

    /**
     * Determine whether the user can delete the cluster.
     *
     * @param  \App\User  $user
     * @param  \App\Cluster  $cluster
     * @return mixed
     */
    public function delete(User $user, Cluster $cluster)
    {
        //
    }

    /**
     * Determine whether the user can restore the cluster.
     *
     * @param  \App\User  $user
     * @param  \App\Cluster  $cluster
     * @return mixed
     */
    public function restore(User $user, Cluster $cluster)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the cluster.
     *
     * @param  \App\User  $user
     * @param  \App\Cluster  $cluster
     * @return mixed
     */
    public function forceDelete(User $user, Cluster $cluster)
    {
        //
    }
}
