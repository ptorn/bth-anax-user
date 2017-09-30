<?php

namespace Peto16\User;

/**
 * Class to handle a user.
 */
class User
{

    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */

    public $id;
    public $username;
    public $password;
    public $email;
    public $firstname;
    public $lastname;
    public $administrator;
    public $enabled;
    public $deleted;



    /**
     * Set the password.
     *
     * @param string $password the password to use.
     *
     * @return void
     */
    public function hashPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }
}
