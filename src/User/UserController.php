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
    private $response;
    private $view;
    private $pageRender;



    /**
     * Initiate the controller.
     * @return void
     */
    public function init()
    {
        $this->userService = $this->di->get("userService");
        $this->session = $this->di->get("session");
        $this->response = $this->di->get("response");
        $this->view = $this->di->get("view");
        $this->pageRender = $this->di->get("pageRender");
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
            $this->response->redirect("");
        }

        $title      = "Administration - Login";
        $form       = new UserLoginForm($this->di);

        $form->check();

        $data = [
            "form" => $form->getHTML(),
        ];

        $this->view->add("user/login", $data);

        $this->pageRender->renderPage(["title" => $title]);
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
        $form       = new CreateUserForm($this->di);

        $form->check();

        $data = [
            "content" => $form->getHTML(),
        ];

        $this->view->add("default2/article", $data);

        $this->pageRender->renderPage(["title" => $title]);
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
            $this->response->redirect("login");
            return false;
        }

        if ($loggedInUser->id != $id) {
            if (!$loggedInUser->administrator) {
                $this->response->redirect("");
            }
        }

        $title      = "Uppdatera användaren";
        $form       = new UpdateUserForm($this->di, $id);

        $form->check();

        $data = [
            "content" => $form->getHTML(),
        ];

        $this->view->add("default2/article", $data);

        $this->pageRender->renderPage(["title" => $title]);
    }



    /**
     * Handler with form to delete an item.
     *
     * @return void
     */
    public function getPostDeleteUser($id)
    {
        $loggedInUser = $this->userService->getCurrentLoggedInUser();

        if ($loggedInUser === null) {
            $this->response->redirect("login");
        }
        if ($loggedInUser != null && !$loggedInUser->administrator) {
            $this->response->redirect("login");
        }

        $title      = "Radera en användare";
        $form       = new DeleteUserForm($this->di, $id);

        $form->check();

        $data = [
            "content" => $form->getHTML(),
        ];

        $this->view->add("default2/article", $data);

        $this->pageRender->renderPage(["title" => $title]);
    }



    /**
     * Logout user.
     *
     * @return void
     */
    public function logout()
    {
        $this->session->delete("user");
        $this->response->redirect("user/login");
    }
}
