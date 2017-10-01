<?php

return [
    "dsn"             => "sqlite:" . ANAX_INSTALL_PATH . "/test/db/anax_user_test.sqlite",
    "username"        => null,
    "password"        => null,
    "fetch_mode"      => \PDO::FETCH_OBJ,
    "session_key"     => "Anax\Database",
    // True to be very verbose during development
    "verbose"         => true,
    // True to be verbose on connection failed
    "debug_connect"   => true,
];
