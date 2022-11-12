<?php


namespace App\Interfaces;


interface UserRepositoryInterface
{
    public function getAllUsers();
    public function storeUser($userData);
    public function updateUser($user, $userData);
    public function deleteUser($user);
}
