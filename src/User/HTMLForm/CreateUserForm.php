<?php

namespace Peto16\User\HTMLForm;

use \Anax\HTMLForm\FormModel;
use \Anax\DI\DIInterface;
use \Peto16\User\User;

/**
 * Example of FormModel implementation.
 */
class CreateUserForm extends FormModel
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
                "legend" => "Skapa användare",
            ],
            [
                "username" => [
                    "label"       => "Användarnamn",
                    "type"        => "text",
                ],

                "firstname" => [
                    "label"       => "Förnamn",
                    "type"        => "text",
                ],

                "lastname" => [
                    "label"       => "Efternamn",
                    "type"        => "text",
                ],

                "email" => [
                    "label"       => "Epost",
                    "type"        => "email",
                ],

                "password" => [
                    "label"       => "Lösenord",
                    "type"        => "password",
                ],

                "password-again" => [
                    "label"       => "Bekräfta lösenord",
                    "type"        => "password",
                    "validation" => [
                        "match" => "password"
                    ],
                ],
                "submit" => [
                    "type" => "submit",
                    "value" => "Skapa",
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
        // Get values from the submitted form
        $password      = $this->form->value("password");
        $passwordAgain = $this->form->value("password-again");


        // Check password matches
        if ($password !== $passwordAgain) {
            $this->form->rememberValues();
            $this->form->addOutput("Lösenorden är ej identiska.");
            return false;
        }

        // Create a new user.
        $user = new User();
        $user->username = $this->form->value("username");
        $user->firstname = $this->form->value("firstname");
        $user->lastname = $this->form->value("lastname");
        $user->email = $this->form->value("email");
        $user->password = $user->hashPassword($password);
        $user->enabled = 1;
        $user->administrator = 0;

        try {
            // Save user
            $this->di->get("userService")->createUser($user);
        } catch (\Peto16\User\Exception $e) {
            $this->form->addOutput($e->getMessage());
            return false;
        }

        $this->form->addOutput("Användare skapad.");
        return true;
    }
}
