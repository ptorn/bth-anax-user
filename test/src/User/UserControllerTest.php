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
     * Setup before testing class.
     */
    public static function setUpBeforeClass()
    {
        self::$di = new \Anax\DI\DIFactoryConfig("testDi.php");
        self::$userController = new UserController();
        self::$userController->setDi(self::$di);
        self::$session = self::$di->get("session");
    }



    /**
     * Initiate the controller test.
     */
    public function testInit()
    {
        self::$userController->init();
    }
}
