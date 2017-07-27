<?php

namespace App\Policies;

use App\Models\Article\Article;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArticlePolicy
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
        return $user->authorities()->first()->articles_creatable === true;
    }

    public function update(User $user, Article $article)
    {
        return $user->authorities()->first()->articles_updatable === true && $article->user()->first()->id === $user->id;
    }

    public function delete(User $user, Article $article)
    {
        return $user->authorities()->first()->articles_deletable === true && $article->user()->first()->id === $user->id;
    }
}
