<?php $view->extend('::base.html.php') ?>

<?php $view['slots']->start('body') ?>
<h1>Hello Application</h1>

<?php $view['slots']->output('content') ?>

<?php $view['slots']->stop() ?>
