<?php

namespace Peto16\User\HTMLForm;

use \Anax\HTMLForm\FormModel;
use \Anax\DI\DIInterface;
use \Peto16\User\User;

/**
 * Example of FormModel implementation.
 */
class UpdateUserForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param Anax\DI\DIInterface $di a service container
     * @param integer             $id to update
     */
    public function __construct(DIInterface $di, $id)
    {
        parent::__construct($di);
        $user = $di->get("userService")->getUserByField("id", $id);
        $userLoggedIn = $di->get("userService")->getCurrentLoggedInUser();
        $formItems = [
            "id" => [
                "type" => "text",
                "validation" => ["not_empty"],
                "readonly" => true,
                "value" => $user->id
            ],

            "username" => [
                "label"       => "Användarnamn",
                "type"        => "text",
                "value"       => htmlentities($user->username)
            ],

            "firstname" => [
                "label"       => "Förnamn",
                "type"        => "text",
                "value"       => htmlentities($user->firstname)
            ],

            "lastname" => [
                "label"       => "Efternamn",
                "type"        => "text",
                "value"       => htmlentities($user->lastname)
            ],

            "email" => [
                "label"       => "Epost",
                "type"        => "email",
                "value"       => htmlentities($user->email)
            ],

            "enabled" => [
                "label"       => "Aktiverad",
                "type"        => "checkbox",
                "checked"       => $user->enabled === 1 ? 1 : 0
            ],
            "administrator" => [
                "label"       => "Administrator",
                "type"        => "checkbox",
                "checked"       => $user->administrator === 1 ? 1: 0
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
                "value" => "Uppdatera",
                "callback" => [$this, "callbackSubmit"]
            ],
        ];

        if (!$userLoggedIn->administrator) {
            unset($formItems["enabled"]);
            unset($formItems["administrator"]);
        }

        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Uppdatera användare",
            ],
            $formItems
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

        $userService = $this->di->get("userService");

        // Get values from the submitted form
        $password      = $this->form->value("password");
        $passwordAgain = $this->form->value("password-again");


        // Check password matches
        if ($password !== $passwordAgain) {
            $this->form->rememberValues();
            $this->form->addOutput("Password did not match.");
            return false;
        }


        $userStored = $userService->getUserByField("id", $this->form->value("id"));
        $userLoggedIn = $userService->getCurrentLoggedInUser();


        // Create user.
        $user = new User();

        $user->id = $this->form->value("id");
        $user->username = $this->form->value("username");
        $user->firstname = $this->form->value("firstname");
        $user->lastname = $this->form->value("lastname");
        $user->email = $this->form->value("email");
        $user->enabled = $userStored->enabled;
        $user->administrator = $userStored->administrator;

        if ($userLoggedIn->administrator) {
            $user->enabled = $this->form->value("enabled");
            $user->administrator = $this->form->value("administrator");
        }

        $user->password = $userStored->password;
        if ($password !== null) {
            $user->password = $user->hashPassword($password);
        }

        // Save user to database
        $userService->updateUser($user);

        $this->form->addOutput("Din profil är uppdaterad.");
        return true;
    }
}
