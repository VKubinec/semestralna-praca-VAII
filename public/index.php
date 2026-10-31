<?php

// Entry point from the original thevajko/cv-05 starter.
require "../Framework/ClassLoader.php";

use Framework\Core\App;

try {
    $app = new App();
    $app->run();
} catch (Exception $e) {
    die('An error occurred: ' . $e->getMessage());
}
