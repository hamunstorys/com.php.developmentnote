<?php

namespace App\Policies;

use App\Models\Article\Comment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function before(User $user, $ability)
    {
        if ($user->isAdministrator()) {
            return true;
        }
    }

    public function create(User $user)
    {
        return $user->authorities()->first()->comments_creatable === true;
    }

    public function update(User $user, Comment $comment)
    {
        return $user->authorities()->first()->comments_updatable === true && $comment->user()->first()->id === $user->id;
    }

    public function delete(User $user, Comment $comment)
    {
        return $user->authorities()->first()->comments_deletable === true && $comment->user()->first()->id === $user->id;
    }
}
