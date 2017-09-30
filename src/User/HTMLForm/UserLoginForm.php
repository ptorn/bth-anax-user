<?php

namespace Peto16\User\HTMLForm;

use \Anax\HTMLForm\FormModel;
use \Anax\DI\DIInterface;

/**
 * Example of FormModel implementation.
 */
class UserLoginForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param Anax\DI\DIInterface $di a service container
     */
    public function __construct(DIInterface $di)
    {
        parent::__construct($di);

        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Logga In"
            ],
            [
                "username" => [
                    "type"        => "text",
                    // "description" => "Here you can place a description.",
                    // "placeholder" => "Here is a placeholder",
                ],

                "password" => [
                    "type"        => "password",
                    //"description" => "Here you can place a description.",
                    //"placeholder" => "Here is a placeholder",
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Login",
                    "callback" => [$this, "callbackSubmit"]
                ],
            ]
        );
    }



    /**
     * Callback for submit-button which should return true if it could
     * carry out its work and false if something failed.
     *
     * @return boolean true if okey, false if something went wrong.
     */
    public function callbackSubmit()
    {
        // Remember values during resubmit, useful when failing (retunr false)
        // and asking the user to resubmit the form.
        $this->form->rememberValues();
        $username = $this->form->value("username");
        $password = $this->form->value("password");
        try {
            $this->di->get("userService")->login($username, $password);
        } catch (\Peto16\User\Exception $e) {
            $this->form->addOutput($e->getMessage());
            return false;
        }
        return true;
    }
}
