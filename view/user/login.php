<?php

namespace Anax\View;

/**
 * View to create a new comment.
 */

// Gather incoming variables and use default values if not set
$items = isset($items) ? $items : null;
$urlToCreate = url("user/create");

?><h1>Administration</h1>

<?= $form ?>
<a href="<?= $urlToCreate ?>">Skapa användare</a>
