<?php

namespace Peto16\User;

use PHPUnit\Framework\TestCase;

/**
 * Controller for Login
 */
class UserControllerTest extends TestCase
{

    protected static $session;
    protected static $di;
    protected static $userController;



    /**
     * Setup testing environment
     */
    public function setUp()
    {
        self::$di = new \Anax\DI\DIFactoryConfig();
        self::$di->configure(ANAX_APP_PATH . "/test/config/testDi.php");
        self::$userController = new UserController();
        self::$userController->setDi(self::$di);
        self::$userController->init();
        self::$session = self::$di->get("session");

        $admin = new User();
        $admin->administrator = true;
        $admin->enabled = true;
        $admin->deleted = null;

        self::$session->set("user", $admin);
    }



    /**
     * Initiate the controller test.
     */
    public function testInit()
    {
        self::$userController->init();
    }



    /**
     * Create an object.
     */
    public function testCreate()
    {
        $userController = new UserController();
        $this->assertInstanceOf("Peto16\User\UserController", $userController);
    }




    /**
     * Inject $di.
     */
    public function testInjectDi()
    {
        $userController = new UserController();
        $userController->setDI(self::$di);
        $userController->init();
        $this->assertEquals(self::$userController, $userController);
    }



    /**
     * Test the login process
     * @return void
     */
    public function testGetPostLogin()
    {
        self::$userController->getPostLogin();
    }



    /**
     * Test create user.
     * @return void
     */
    public function testGetPostCreateUser()
    {
        self::$userController->getPostCreateUser();
    }



    /**
     * Test update user.
     * @return void
     */
    public function testGetPostUpdateUser()
    {
        self::$userController->getPostUpdateUser(1);

        self::$session->delete("user");
        self::$userController->getPostUpdateUser(1);

        $user = new User();
        $user->id = 2;
        $user->username = "admin";
        $user->administrator = false;
        $user->enabled = true;

        self::$session->set("user", $user);
        self::$userController->getPostUpdateUser(1);
    }



    /**
     * Test delete user.
     * @return void
     */
    public function testGetPostDeleteUser()
    {
        self::$userController->getPostDeleteUser(1);

        self::$session->delete("user");
        self::$userController->getPostDeleteUser(2);

        $user = new User();
        $user->id = 2;
        $user->username = "admin";
        $user->administrator = false;
        $user->enabled = true;

        self::$session->set("user", $user);
        self::$userController->getPostDeleteUser(2);
    }



    /**
     * Test logout.
     * @return void
     */
    public function testLogout()
    {
        $this->assertTrue(self::$session->has("user"));
        self::$userController->logout();
        $this->assertFalse(self::$session->has("user"));
    }
}
