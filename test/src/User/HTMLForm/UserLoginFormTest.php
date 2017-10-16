<?php

namespace Peto16\User\HTMLForm;

use PHPUnit\Framework\TestCase;

/**
 * Example of FormModel implementation.
 */
class UserLoginFormTest extends TestCase
{

    protected static $di;



    /**
     * Setup before testing class.
     */
    public static function setUpBeforeClass()
    {
        self::$di = new \Anax\DI\DIFactoryConfig();
        self::$di->configure(ANAX_APP_PATH . "/test/config/testDi.php");
    }



    /**
     * Test constructor
     */
    public function testConstruct()
    {
        $form = new UserLoginForm(self::$di);
        $this->assertInstanceOf("Peto16\User\HTMLForm\UserLoginForm", $form);
    }



    /**
     * Test callback submit.
     */
    public function testCallbackSubmit()
    {
        $form = new UserLoginForm(self::$di);
        $form->callbackSubmit();
    }
}
