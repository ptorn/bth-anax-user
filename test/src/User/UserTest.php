<?php

namespace Peto16\User;

use PHPUnit\Framework\TestCase;

/**
 * Class to handle a user.
 */
class UserTest extends TestCase
{

    /**
     * Test the password.
     *
     */
    public function testHashPassword()
    {
        $user = new \Peto16\User\User();
        $password = $user->hashPassword("test");

        $this->assertTrue(substr($password, 0, 4) === "$2y$");
    }
}
