<?php

/** @var \Framework\Http\HttpException $exception */
/** @var bool $showDetail */
/** @var \Framework\Support\View $view */

// Error view adapted from thevajko/cv-05.
$view->setLayout(null);
?>
<h1><?= $exception->getCode() . " - " . $exception->getMessage() ?></h1>
<?php if ($showDetail): ?>
    <pre><?= htmlspecialchars($exception->getTraceAsString(), ENT_QUOTES, 'UTF-8') ?></pre>
<?php endif; ?>
