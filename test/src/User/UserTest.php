<?php

namespace Peto16\User;

use PHPUnit\Framework\TestCase;

/**
 * Class to handle a user.
 */
class UserTest extends TestCase
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
     * Test the password.
     *
     */
    public function testhashPassword()
    {
        $password = "test";
        $this->assertTrue(password_hash($password, PASSWORD_DEFAULT));
    }
}
