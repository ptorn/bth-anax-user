<?php

namespace Peto16\User\HTMLForm;

use \Anax\HTMLForm\FormModel;
use \Anax\DI\DIInterface;

/**
 * Form to update an item.
 */
class DeleteUserForm extends FormModel
{
    /**
     * Constructor injects with DI container and the id to update.
     *
     * @param Anax\DI\DIInterface $di a service container
     * @param integer             $id to update
     */
    public function __construct(DIInterface $di, $id)
    {
        parent::__construct($di);
        $user = $di->get("userService")->getUserByField("id", $id);
        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Radera användare.",
            ],
            [
                "id" => [
                    "type" => "text",
                    "validation" => ["not_empty"],
                    "readonly" => true,
                    "value" => $user->id,
                ],

                "username" => [
                    "label" => "Användarnamn",
                    "readonly" => true,
                    "type" => "text",
                    "value" => htmlentities($user->username),
                ],
                "confirm" => [
                    "required"    => true,
                    "label"       => "Bekräfta",
                    "type"        => "checkbox",
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Radera",
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
        $id = $this->form->value("id");
        $this->di->get("userService")->deleteUser($id);
        $this->di->get("utils")->redirect("admin");
    }
}
