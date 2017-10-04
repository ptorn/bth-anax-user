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
        "db" => [
            "shared" => false,
            "callback" => function () {
                $obj = new \Anax\Database\DatabaseQueryBuilder();
                $obj->configure("testDatabase.php");
                $obj->connect();

                $sql = '
                CREATE TABLE `ramverk1_User`
                (
                    `id` INTEGER PRIMARY KEY NOT NULL,
                    `username` VARCHAR(30) NOT NULL UNIQUE,
                    `password` VARCHAR(255) NOT NULL,
                    `email` VARCHAR(255) DEFAULT NULL UNIQUE,
                    `firstname` VARCHAR(40) DEFAULT NULL,
                    `lastname` VARCHAR(40) DEFAULT NULL,
                    `administrator` BOOLEAN DEFAULT False,
                    `enabled` BOOLEAN DEFAULT True,
                    `deleted` DATETIME DEFAULT NULL
                )';
                $obj->execute($sql);
                $sql = 'INSERT INTO `ramverk1_User` (id, username, password, email, firstname, lastname, administrator, enabled, deleted) VALUES
                    (1, "admin", "$2y$10$vaqfYKE2TfIzo7EQMxd8fOg3AvnPBZPTtV4l98aN4Ep6TkmjA2/Cm", "peder.tornberg@gmail.com", "Peder", "Tornberg", 1, 1, NULL),
                    (2, "doe", "$2y$10$dYBys9cIIKEsdtQoiIiELOVkuRbcyfMZt7L8Pinw7JHDpZEol7UN6", "doe@example.com", "John", "Doe", 0, 1, NULL),
                    (3, "bob", "$2y$10$bV/btm035m/Hv87RYB04JuTFN7opVra1zlBcvdKJHxTzBISmQeHSy", "bob@example.com", "Bob", "Builder", 0, 0, NULL),
                    (4, "disabled", "$2y$10$bV/btm035m/Hv87RYB04JuTFN7opVra1zlBcvdKJHxTzBISmQeHSy", "disabled@example.com", "Pink", "Panther", 0, 0, NULL)';
                $obj->execute($sql);
                return $obj;
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
    ],
];
