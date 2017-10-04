<?php

namespace Peto16\User\HTMLForm;

use PHPUnit\Framework\TestCase;

/**
 * Example of FormModel implementation.
 */
class CreateUserFormTest extends TestCase
{

    protected static $di;



    /**
     * Setup before testing class.
     */
    public static function setUpBeforeClass()
    {
        self::$di = new \Anax\DI\DIFactoryConfig("testDi.php");
    }



    public function testConstruct()
    {
        $form = new CreateUserForm(self::$di);
        $this->assertInstanceOf("Peto16\User\HTMLForm\CreateUserForm", $form);
    }



    // /**
    //  * Test callback submit.
    //  */
    // public function testCallbackSubmit()
    // {
    //
    //     // $form = new CreateUserForm(self::$di);
    //     $form->callbackSubmit();
    // }
}
