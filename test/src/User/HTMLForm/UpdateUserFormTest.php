<?php

namespace Peto16\User\HTMLForm;

use PHPUnit\Framework\TestCase;

/**
 * Example of FormModel implementation.
 */
class UpdateUserFormTest extends TestCase
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
        self::$newForm = new UpdateUserForm(self::$di, 1);
    }



    /**
     * Constructor injects with DI container.
     *
     * @param Anax\DI\DIInterface $di a service container
     * @param integer             $id to update
     */
    public function testConstruct()
    {
        $form = new UpdateUserForm(self::$di, 1);
        $this->assertInstanceOf("Peto16\User\HTMLForm\UpdateUserForm", $form);
        $user = new \Peto16\User\User();
        $user->username = "admin";
        $user->administrator = false;
        $user->enabled = true;

        self::$session->set("user", $user);
        $formUser = new UpdateUserForm(self::$di, 1);
        $this->assertInstanceOf("Peto16\User\HTMLForm\UpdateUserForm", $formUser);
    }



    public function testCallbackSubmit()
    {
        self::$newForm->callbackSubmit();
    }
}
