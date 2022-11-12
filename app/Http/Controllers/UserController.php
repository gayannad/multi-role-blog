<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ApiHelper;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    use ApiHelper;

    /**
     * @var UserRepositoryInterface
     */
    private UserRepositoryInterface $userRepository;

    /**
     * UserController constructor.
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * list of users
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return $this->apiSuccess($this->userRepository->getAllUsers(), '');
        } catch (\Exception $e) {
            return $this->apiError(422, $e->getMessage());
        }
    }

    /**
     * Store a new user
     *
     * @param StoreUserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreUserRequest $request)
    {
        try {
            $userData = $request->all();

            $user = $this->userRepository->storeUser($userData);

            return $this->apiSuccess($user, 'User created successfully!');
        } catch (\Exception $e) {
            return $this->apiError(422, $e->getMessage());
        }
    }

    /**
     * Display the specified user
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        try {
            return $this->apiSuccess($user, '');
        } catch (\Exception $e) {
            return $this->apiError(404, 'User not found');
        }
    }

    /**
     * Update the specified user
     *
     * @param UpdateUserRequest $request
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        try {
            $userData = $request->all();

            $update = $this->userRepository->updateUser($user, $userData);

            if ($update) {
                return $this->apiSuccess($user, 'User updated successfully!');
            }
        } catch (\Exception $e) {
            return $this->apiError(422, 'User update failed!');
        }
    }

    /**
     * Remove the specified user
     *
     * @param \App\Models\Post $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        try {
            $user = $this->userRepository->deleteUser($user);

            if ($user) {
                return $this->apiSuccess(null, 'User deleted successfully!');
            }
        } catch (\Exception $e) {
            return $this->apiError(422, 'Post delete failed!');
        }
    }
}
