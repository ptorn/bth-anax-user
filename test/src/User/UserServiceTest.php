<?php

namespace Peto16\User;

use PHPUnit\Framework\TestCase;

class UserServiceTest extends TestCase
{
    protected static $session;
    protected static $di;
    protected static $userService;



    /**
     * Setup before testing class.
     */
    public static function setUpBeforeClass()
    {
        copy(ANAX_APP_PATH . "/test/db/anax_user_test_2.sqlite", ANAX_APP_PATH . "/test/db/anax_user_test.sqlite");
        self::$di = new \Anax\DI\DIFactoryConfig("testDi.php");
        self::$session = self::$di->get("session");
        self::$userService = new UserService(self::$di);
        $admin = new User();
        $admin->administrator = true;
        $admin->enabled = true;
        $admin->deleted = null;

        self::$session->set("user", $admin);
    }



    /**
     * Teardown after every method test.
     */
    public function tearDown()
    {
        copy(ANAX_APP_PATH . "/test/db/anax_user_test_2.sqlite", ANAX_APP_PATH . "/test/db/anax_user_test.sqlite");
    }



    /**
     * Test the construct
     * @return [type] [description]
     */
    public function testConstruct()
    {
        $userService = new UserService(self::$di);
        $this->assertInstanceOf("Peto16\User\UserService", $userService);
    }



    /**
     * Create user test.
     *
     */
    public function testCreateUser()
    {
        $user = new User();
        $user->email = "test2@test.com";
        $user->username = "test2";
        $user->firstname = "test2";
        $user->lastname = "exemple";
        $user->administrator = true;
        $user->enabled = true;
        $user->password = $user->hashPassword($user->email);
        self::$userService->createUser($user);
        $this->assertEquals(self::$userService->getUserByField("username", "test2")->username, "test2");

        try {
            self::$userService->createUser($user);
        } catch (Exception $e) {
            $this->assertEquals("E-postadress används redan.", $e->getMessage());
        }

        $user->email = "new@new.com";
        try {
            self::$userService->createUser($user);
        } catch (Exception $e) {
            $this->assertEquals("Användarnamn redan taget.", $e->getMessage());
        }
    }



    /**
     * Update user test.
     *
     */
    public function testUpdateUser()
    {
        $updUser = new User();
        $updUser->id = 1;
        $updUser->username = "adminTest";
        $updUser->firstname = "adminTest";

        self::$userService->updateUser($updUser);
        $user = self::$userService->getUserByField("id", $updUser->id);

        $this->assertEquals($user->username, $updUser->username);
        $this->assertEquals($user->firstname, $updUser->firstname);
    }



    /**
     * Delete user test.
     *
     */
    public function testDeleteUser()
    {
        $testUser = new User();
        $testUser->administrator = 0;
        self::$userService->deleteUser(1);
        $user = self::$userService->getUserByField("id", 1);
        $this->assertNotNull($user->deleted);

        $testUser = new User();
        $testUser->administrator = false;
        self::$session->set("user", $testUser);
        $this->assertFalse(self::$userService->deleteUser(1));

        $admin = new User();
        $admin->administrator = true;
        $admin->enabled = true;
        $admin->deleted = null;

        self::$session->set("user", $admin);
    }



    /**
     * Find all users stored.
     *
     */
    public function testFindAllUsers()
    {
        $users = self::$userService->findAllUsers();
        $this->assertTrue(sizeof($users) === 2);
        $this->assertEquals($users[0]->username, "test");
    }



    /**
     * Check if user is logged in.
     *
     */
    public function testCheckLoggedin()
    {
        $this->assertTrue(self::$userService->checkLoggedIn() === true);
    }



    /**
     * Check if user is logged in.
     *
     */
    public function testLogin()
    {
        try {
            self::$userService->login("test", "test");
        } catch (Exception $e) {
            $this->assertEquals("Error, not valid credentials.", $e->getMessage());
        }

        try {
            self::$userService->login("test", null);
        } catch (Exception $e) {
            $this->assertEquals("Empty password field.", $e->getMessage());
        }

        try {
            self::$userService->login("noUser", "test");
        } catch (Exception $e) {
            $this->assertEquals("Error, not valid credentials.", $e->getMessage());
        }

        try {
            self::$userService->login("disabled", "adminn");
        } catch (Exception $e) {
            $this->assertEquals("Error, disabled account.", $e->getMessage());
        }

        $this->assertTrue(self::$userService->login("test", "admin"));
    }



    /**
     * Test to generate gravatar url
     */
    public function testGenerateGravatarUrl()
    {
        $url = self::$userService->generateGravatarUrl();
        $this->assertEquals($url, "http://www.gravatar.com/avatar/?d=identicon");
        $url = self::$userService->generateGravatarUrl("test@test.com");
        $this->assertEquals($url, "https://s.gravatar.com/avatar/" . md5(strtolower(trim("test@test.com"))));
    }
}
