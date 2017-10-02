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
        copy(ANAX_APP_PATH . "/test/db/anax_user_test_2.sqlite", ANAX_APP_PATH . "/test/db/anax_user_test.sqlite");
        self::$di = new \Anax\DI\DIFactoryConfig("testDi.php");
    }



    /**
     * Teardown after every method test.
     */
    public function tearDown()
    {
        copy(ANAX_APP_PATH . "/test/db/anax_user_test_2.sqlite", ANAX_APP_PATH . "/test/db/anax_user_test.sqlite");
    }



    public function testConstruct()
    {
        $form = new CreateUserForm(self::$di);
    }
}
