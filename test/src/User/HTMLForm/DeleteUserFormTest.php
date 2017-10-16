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
        self::$di = new \Anax\DI\DIFactoryConfig();
        self::$di->configure(ANAX_APP_PATH . "/test/config/testDi.php");
        self::$session = self::$di->get("session");
        $user = new \Peto16\User\User();
        $user->username = "admin";
        $user->administrator = true;
        $user->enabled = true;

        self::$session->set("user", $user);
        self::$newForm = new DeleteUserForm(self::$di, 1);
    }



    /**
     * Test constructor
     */
    public function testConstruct()
    {
        $form = new DeleteUserForm(self::$di, 4);
        $this->assertInstanceOf("Peto16\User\HTMLForm\DeleteUserForm", $form);
    }



    public function testCallbackSubmit()
    {
        self::$newForm->callbackSubmit();
    }
}
