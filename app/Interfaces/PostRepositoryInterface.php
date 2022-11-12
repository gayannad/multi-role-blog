<?php


namespace App\Interfaces;


interface PostRepositoryInterface
{
    public function createPost($postData);
    public function updatePost($user,$post,$postData);
    public function viewPost($post,$user);
    public function getAllPosts();
    public function deletePost($user,$post);
    public function getPostsByUser($userId);
}
