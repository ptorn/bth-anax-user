<?php
/**
 * Configuration file for DI container.
 */

return [

    // Services to add to the container.
    "services" => [
        "request" => [
            "shared" => true,
            "callback" => function () {
                $request = new \Anax\Request\Request();
                $request->init();
                return $request;
            }
        ],
        "response" => [
            "shared" => true,
            "callback" => function () {
                $obj = new \testing\User\Helper();
                return $obj;
            }
        ],
        "url" => [
            "shared" => true,
            "callback" => function () {
                $url = new \Anax\Url\Url();
                $request = $this->get("request");
                $url->setSiteUrl($request->getSiteUrl());
                $url->setBaseUrl($request->getBaseUrl());
                $url->setStaticSiteUrl($request->getSiteUrl());
                $url->setStaticBaseUrl($request->getBaseUrl());
                $url->setScriptName($request->getScriptName());
                $url->configure("url.php");
                $url->setDefaultsFromConfiguration();
                return $url;
            }
        ],
        "router" => [
            "shared" => true,
            "callback" => function () {
                $router = new \Anax\Route\Router();
                $router->setDI($this);
                $router->configure("route2.php");
                return $router;
            }
        ],
        "view" => [
            "shared" => true,
            "callback" => function () {
                $view = new \testing\User\Helper();
                return $view;
            }
        ],
        "viewRenderFile" => [
            "shared" => true,
            "callback" => function () {
                $viewRender = new \Anax\View\ViewRenderFile2();
                $viewRender->setDI($this);
                return $viewRender;
            }
        ],
        "session" => [
            "shared" => true,
            "active" => true,
            "callback" => function () {
                $session = new \Anax\Session\SessionConfigurable();
                $session->configure("testSession.php");
                $session->start();
                return $session;
            }
        ],
        "textfilter" => [
            "shared" => true,
            "callback" => "\Anax\TextFilter\TextFilter",
        ],
        "errorController" => [
            "shared" => true,
            "callback" => function () {
                $obj = new \Anax\Page\ErrorController();
                $obj->setDI($this);
                return $obj;
            }
        ],
        "debugController" => [
            "shared" => true,
            "callback" => function () {
                $obj = new \Anax\Page\DebugController();
                $obj->setDI($this);
                return $obj;
            }
        ],
        "flatFileContentController" => [
            "shared" => true,
            "callback" => function () {
                $obj = new \Anax\Page\FlatFileContentController();
                $obj->setDI($this);
                return $obj;
            }
        ],
        "pageRender" => [
            "shared" => true,
            "callback" => function () {
                $obj = new \testing\User\Helper();
                return $obj;
            }
        ],
        "navbar" => [
            "shared" => true,
            "callback" => function () {
                $navbar = new \Peto16\Navbar\Navbar();
                $navbar->configure("navbar.php");
                $navbar->setDI($this);
                return $navbar;
            }
        ],
        "adminController" => [
            "shared" => true,
            "callback" => function () {
                $adminController = new \Peto16\Admin\AdminController();
                $adminController->setDI($this);
                return $adminController;
            }
        ],
        "db" => [
            "shared" => true,
            "callback" => function () {
                $obj = new \Anax\Database\DatabaseQueryBuilder();
                $obj->configure("testDatabase.php");
                return $obj;
            }
        ],
        "rem" => [
            "shared" => true,
            "callback" => function () {
                $rem = new \Anax\RemServer\RemServer();
                $rem->configure("remserver.php");
                $rem->injectSession($this->get("session"));
                return $rem;
            }
        ],
        "remController" => [
            "shared" => true,
            "callback" => function () {
                $remController = new \Anax\RemServer\RemServerController();
                $remController->setDI($this);
                return $remController;
            }
        ],
        "comController" => [
            "shared" => true,
            "callback" => function () {
                $comController = new \Peto16\Comment\CommentController();
                $comController->setDI($this);
                $comController->init();
                return $comController;
            }
        ],
        "commentService" => [
            "shared" => true,
            "callback" => function () {
                $comment = new \Peto16\Comment\CommentService($this);
                return $comment;
            }
        ],
        "utils" => [
            "shared" => true,
            "callback" => function () {
                $utils = new \testing\User\Helper();
                // $utils->setDI($this);
                return $utils;
            }
        ],
        "userService" => [
            "shared" => true,
            "callback" => function () {
                $user = new Peto16\User\UserService($this);
                return $user;
            }
        ],
        "userController" => [
            "shared" => true,
            "callback" => function () {
                $userController = new \Peto16\User\UserController();
                $userController->setDI($this);
                $userController->init();
                return $userController;
            }
        ],
        "bookController" => [
            "shared" => true,
            "callback" => function () {
                $obj = new \Anax\Book\BookController();
                $obj->setDI($this);
                return $obj;
            }
        ],
    ],
];
