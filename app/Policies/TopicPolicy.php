<?php

namespace App\Policies;

use App\User;
use App\Topic;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Http\Request;

class TopicPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the topic.
     *
     * @param  \App\User  $user
     * @param  \App\Topic  $topic
     * @return mixed
     */
    public function view(User $user, Topic $topic)
    {
        //
    }

    /**
     * Determine whether the user can create topics.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the topic.
     *
     * @param  \App\User  $user
     * @param  \App\Topic  $topic
     * @return mixed
     */
    public function update(User $user, Topic $topic)
    {
        return $user->id === $topic->user_id || $user->isElevated();
    }

    /**
     * Determine whether the user can delete the topic.
     *
     * @param  \App\User  $user
     * @param  \App\Topic  $topic
     * @return mixed
     */
    public function delete(User $user, Topic $topic)
    {
        return $user->id === $topic->user_id || $user->isElevated();
    }

    /**
     * Determine whether the user can restore the topic.
     *
     * @param  \App\User  $user
     * @param  \App\Topic  $topic
     * @return mixed
     */
    public function restore(User $user, Topic $topic)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the topic.
     *
     * @param  \App\User  $user
     * @param  \App\Topic  $topic
     * @return mixed
     */
    public function forceDelete(User $user, Topic $topic)
    {
        //
    }
}
