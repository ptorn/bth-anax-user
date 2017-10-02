<?php

namespace Peto16\User\HTMLForm;

use PHPUnit\Framework\TestCase;

/**
 * Form to update an item.
 */
class DeleteUserFormTest extends TestCase
{

    protected static $di;
    protected static $session;
    protected static $newForm;

    /**
     * Setup before testing class.
     */
    public static function setUpBeforeClass()
    {
        self::$di = new \Anax\DI\DIFactoryConfig("testDi.php");
        self::$session = self::$di->get("session");
        $user = new \Peto16\User\User();
        $user->username = "admin";
        $user->administrator = true;
        $user->enabled = true;

        self::$session->set("user", $user);
        self::$newForm = new DeleteUserForm(self::$di, 1);
    }



    public function testCallbackSubmit()
    {
        self::$newForm->callbackSubmit();
    }
}
