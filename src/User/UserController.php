<?php

namespace Peto16\User;

use \Anax\DI\InjectionAwareInterface;
use \Anax\DI\InjectionAwareTrait;
use \Peto16\User\HTMLForm\UserLoginForm;
use \Peto16\User\HTMLForm\CreateUserForm;
use \Peto16\User\HTMLForm\UpdateUserForm;
use \Peto16\User\HTMLForm\DeleteUserForm;

/**
 * Controller for Login
 */
class UserController implements InjectionAwareInterface
{
    use InjectionAwareTrait;

    private $session;
    private $userService;



    /**
     * Initiate the controller.
     * @return void
     */
    public function init()
    {
        $this->userService = $this->di->get("userService");
        $this->session = $this->di->get("session");
    }



    /**
     * Login-page
     *
     * @throws Exception
     *
     * @return void
     */
    public function getPostLogin()
    {
        if ($this->userService->checkLoggedin()) {
            $this->di->get("response")->redirect("");
        }

        $title      = "Administration - Login";
        $view       = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");
        $form       = new UserLoginForm($this->di);

        $form->check();

        $data = [
            "form" => $form->getHTML(),
        ];

        $view->add("user/login", $data);

        $pageRender->renderPage(["title" => $title]);
    }



    /**
     * Create user page.
     *
     * @throws Exception
     *
     * @return void
     */
    public function getPostCreateUser()
    {
        $title      = "Skapa användare";
        $view       = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");
        $form       = new CreateUserForm($this->di);

        $form->check();

        $data = [
            "content" => $form->getHTML(),
        ];

        $view->add("default2/article", $data);

        $pageRender->renderPage(["title" => $title]);
    }



    /**
     * Uppdatera användare.
     *
     * @param integer           $id User id.
     *
     * @throws Exception
     *
     * @return void
     */
    public function getPostUpdateUser($id)
    {
        $loggedInUser = $this->userService->getCurrentLoggedInUser();

        if (!$loggedInUser) {
            $this->di->get("response")->redirect("login");
        }

        if ($loggedInUser->id != $id) {
            if (!$loggedInUser->administrator) {
                $this->di->get("response")->redirect("");
            }
        }

        $title      = "Uppdatera användaren";
        $view       = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");
        $form       = new UpdateUserForm($this->di, $id);

        $form->check();

        $data = [
            "content" => $form->getHTML(),
        ];

        $view->add("default2/article", $data);

        $pageRender->renderPage(["title" => $title]);
    }



    /**
     * Handler with form to delete an item.
     *
     * @return void
     */
    public function getPostDeleteUser($id)
    {
        $loggedInUser = $this->userService->getCurrentLoggedInUser();

        if (!$loggedInUser && !$loggedInUser->administrator) {
            $this->di->get("response")->redirect("login");
        }

        $title      = "Radera en användare";
        $view       = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");
        $form       = new DeleteUserForm($this->di, $id);

        $form->check();

        $data = [
            "content" => $form->getHTML(),
        ];

        $view->add("default2/article", $data);

        $pageRender->renderPage(["title" => $title]);
    }



    /**
     * Logout user.
     *
     * @return void
     */
    public function logout()
    {
        $this->session->delete("user");
        $this->di->get("response")->redirect("user/login");
    }
}
