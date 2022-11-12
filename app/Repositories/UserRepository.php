<?php


namespace App\Repositories;


use App\Interfaces\UserRepositoryInterface;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface
{
    /**
     * @var User
     */
    private User $userModel;

    /**
     * UserRepository constructor.
     * @param User $userModel
     */
    public function __construct(User $userModel)
    {
        $this->userModel = $userModel;
    }


    public function getAllUsers()
    {
        return $this->userModel->paginate(10);
    }

    public function storeUser($userData)
    {
        $user = $this->userModel->create([
            'name' => $userData['name'],
            'email' => $userData['email'],
            'password' => Hash::make($userData['password']),
        ]);

        $user->roles()->attach(Role::where('id', $userData['role_id'])->first());

        return $user;
    }

    public function updateUser($user, $userData)
    {
        $data = [
            'name' => $userData['name'],
            'role_id' => $userData['role_id'],
            'password' => Hash::make($userData['password']),
        ];

        return $user->update($data);
    }

    public function deleteUser($user)
    {
        return $user->delete();
    }
}
