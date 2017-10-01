<?php

namespace Peto16\User;

class UserService
{
    private $userStorage;
    private $session;



    /**
     * Constructor for UserService
     * @param object            $di dependency injection.
     */
    public function __construct($di)
    {
        $this->userStorage = new UserStorage();
        $this->userStorage->setDb($di->get("db"));
        $this->session = $di->get("session");
    }



    /**
     * Create user.
     *
     * @param  object           $user User object to store.
     * @return void
     */
    public function createUser($user)
    {
        if ($this->userStorage->getUserByField("email", $user->email)) {
            throw new Exception("E-postadress används redan.");
        }
        if ($this->userStorage->getUserByField("username", $user->username)) {
            throw new Exception("Användarnamn redan taget.");
        }
        $this->userStorage->createUser($user);
    }



    /**
     * Update user.
     *
     * @param  object           $user User object to update.
     * @return void
     */
    public function updateUser($user)
    {
        $this->userStorage->updateUser($user);
    }



    /**
     * Delete user. Validates if user is admin to be able to delete
     *
     * @param  integer          $id user id.
     *
     * @return boolean
     */
    public function deleteUser($id)
    {
        if ($this->validLoggedInAdmin()) {
            return $this->userStorage->deleteUser($id);
        }
        return false;
    }



    /**
     * Dynamicly get user by propertie.
     *
     * @param string            $field field to search by.
     *
     * @param array             $data to search for.
     *
     * @return User
     *
     */
    public function getUserByField($field, $data)
    {
        $user = new User();
        $userVarArray = get_object_vars($user);
        $arrayKeys = array_keys($userVarArray);
        $userData = $this->userStorage->getUserByField($field, $data);
        if (!$userData) {
            return false;
        }
        foreach ($arrayKeys as $key) {
            $user->{$key} = $userData->$key;
        }
        return $user;
    }



    /**
     * Find all users stored.
     *
     * @return array                Of users
     */
    public function findAllUsers()
    {
        return $this->userStorage->findAllUsers();
    }



    /**
     * Check if user is logged in.
     *
     * @return boolean
     */
    public function checkLoggedin()
    {
        return $this->session->has("user");
    }



    /**
     * Login user and redirect to admin.
     *
     * @return boolean
     */
    public function login($username, $password)
    {
        $user = $this->getUserByField("username", $username);

        if ($password === null) {
            throw new Exception("Empty password field.");
        }

        if (empty($user)) {
            throw new Exception("Error, not valid credentials.");
        }

        if ((int)$user->enabled === 0) {
            throw new Exception("Error, disabled account.");
        }

        if ($this->validatePassword($password, $user->password)) {
            $this->session->set("user", $user);
            return true;
        }
        throw new Exception("Error, not valid credentials.");
        return false;
    }



    /**
     * Check if a user is logged in and returns that user
     *
     * @return obj          user or null
     */
    public function getCurrentLoggedInUser()
    {
        return $this->session->get("user");
    }



    /**
     * Validate pasword
     *
     * @method              password_verify Method to verify password
     *
     * @param  string       $password Password to be validated.
     *
     * @return boolean      Return true if valid else false.
     */
    private function validatePassword($password, $dbpassword)
    {
        return password_verify($password, $dbpassword);
    }



    /**
     * Check if logged in user is valid and admin.
     *
     * @return boolean              Returns true or false if user is valid administrator.
     */
    public function validLoggedInAdmin()
    {
        $loggedInUser = $this->getCurrentLoggedInUser();
        if ($loggedInUser
            && $loggedInUser->administrator
            && $loggedInUser->deleted === null
            && $loggedInUser->enabled) {
                return true;
        }
        return false;
    }



    /**
     * Generate gravatar from email or return default avatar.
     *
     * @param  string           $email email adress
     * @return string           Gravatar url.
     */
    public function generateGravatarUrl($email = null)
    {
        if ($email) {
            return "https://s.gravatar.com/avatar/" . md5(strtolower(trim($email)));
        }
        return "http://www.gravatar.com/avatar/?d=identicon";
    }
}
