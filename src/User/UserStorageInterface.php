<?php

namespace Peto16\User;

/**
 * Interface for UserStorage
 */
interface UserStorageInterface
{
    public function createUser(User $user);
    public function deleteUser($commentId);
    public function updateUser(User $user);
    public function getUserByField($field, $data);
}
