<?php

return [
    "dsn"             => "sqlite::memory:", //. ANAX_INSTALL_PATH . "/test/db/anax_user_test.sqlite",
    "username"        => null,
    "password"        => null,
    "driver_options"  => null,
    "fetch_mode"      => \PDO::FETCH_OBJ,
    "table_prefix"    => null,
    "session_key"     => "Anax\Database",
    // True to be very verbose during development
    "verbose"         => true,
    // True to be verbose on connection failed
    "debug_connect"   => true,
];
