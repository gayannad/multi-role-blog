<?php


namespace App\Repositories;

use App\Interfaces\PostRepositoryInterface;
use App\Models\Post;

class PostRepository implements PostRepositoryInterface
{
    /**
     * @var Post
     */
    private Post $postModel;

    /**
     * PostRepository constructor.
     * @param Post $postModel
     */
    public function __construct(Post $postModel)
    {
        $this->postModel = $postModel;
    }

    public function createPost($postData)
    {
        return $this->postModel->create($postData);
    }

    public function updatePost($user,$post, $postData)
    {
        if ($user->hasRole('admin') || $user->hasRole('manager')) {
            return $post->update($postData);
        } else {
            if ($post->user_id == $user->id) {
                return $post->update($postData);
            } else {
                return false;
            }
        }
    }

    public function getAllPosts()
    {
        return $this->postModel->paginate(10);
    }

    public function getPostsByUser($userId)
    {
        return $this->postModel->where('user_id', $userId)->get();
    }

    public function deletePost($user,$post)
    {
        if ($user->hasRole('admin') || $user->hasRole('manager')) {
            return $post->delete();
        } else {
            if ($post->user_id == $user->id) {
                return $post->delete();
            } else {
                return false;
            }
        }
    }

    public function viewPost($post, $user)
    {
        if ($user->hasRole('admin') || $user->hasRole('manager')) {
            return $post;
        } else {
            if ($post->user_id == $user->id) {
                return $post;
            } else {
                return false;
            }
        }
    }
}
