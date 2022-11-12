<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ApiHelper;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Interfaces\PostRepositoryInterface;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * @var PostRepositoryInterface
     */
    private PostRepositoryInterface $postRepository;

    use ApiHelper;

    /**
     * PostController constructor.
     * @param PostRepositoryInterface $postRepository
     */
    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     * list of posts
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('manager')) {
                return $this->apiSuccess($this->postRepository->getAllPosts(), '');
            } else {
                return $this->apiSuccess($this->postRepository->getPostsByUser(Auth::user()->id), '');
            }
        } catch (\Exception $e) {
            return $this->apiError(422, $e->getMessage());
        }
    }

    /**
     * Store a new post
     *
     * @param \App\Http\Requests\StorePostRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request)
    {
        try {
            $postData = $request->all();

            $postData['user_id'] = Auth::user()->id;

            $post = $this->postRepository->createPost($postData);

            return $this->apiSuccess($post, 'Post created successfully!');
        } catch (\Exception $e) {
            return $this->apiError(422, $e->getMessage());
        }
    }

    /**
     * Display the specified post
     *
     * @param \App\Models\Post $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        try {
            $user = Auth::user();

            $data = $this->postRepository->viewPost($post, $user);

            if ($data){
                return $this->apiSuccess($data, '');
            }else{
                return $this->apiSuccess(null,'You have no permission to view this post !');
            }
        } catch (\Exception $e) {
            return $this->apiError(404, 'Post not found');
        }
    }

    /**
     * Update the specified post
     *
     * @param \App\Http\Requests\UpdatePostRequest $request
     * @param \App\Models\Post $post
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        try {
            $user = Auth::user();

            $postData = $request->all();

            $update = $this->postRepository->updatePost($user,$post, $postData);

            if ($update) {
                return $this->apiSuccess($post, 'Post updated successfully!');
            } else {
                return $this->apiError(401, 'You have no permission to update this post !');
            }
        } catch (\Exception $e) {
            return $this->apiError(422, 'Post update failed!');
        }
    }

    /**
     * Remove the specified post
     *
     * @param \App\Models\Post $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        try {
            $user = Auth::user();

            $post = $this->postRepository->deletePost($user,$post);

            if ($post) {
                return $this->apiSuccess(null, 'Post deleted successfully!');
            } else {
                return $this->apiError(401, 'You have no permission to delete this post !');
            }
        } catch (\Exception $e) {
            return $this->apiError(422, 'Post delete failed!');
        }
    }
}
