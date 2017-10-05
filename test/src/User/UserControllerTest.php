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


    // /**
    //  * Setup before testing class.
    //  */
    // public static function setUpBeforeClass()
    // {
    //     self::$di = new \Anax\DI\DIFactoryConfig("testDi.php");
    //     self::$userController = new UserController();
    //     self::$userController->setDi(self::$di);
    //     self::$userController->init();
    //     self::$session = self::$di->get("session");
    //     $user = new User();
    //     $user->id = 2;
    //     $user->username = "admin";
    //     $user->administrator = true;
    //     $user->enabled = true;
    //
    //     self::$session->set("user", $user);
    // }

    public function setUp()
    {
        self::$di = new \Anax\DI\DIFactoryConfig("testDi.php");
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


    public function testGetPostLogin()
    {
        self::$userController->getPostLogin();
    }



    public function testGetPostCreateUser()
    {
        self::$userController->getPostCreateUser();
    }



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



    public function testLogout()
    {
        self::$userController->logout();
    }
}
