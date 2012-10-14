<?php $view->extend('LiipHelloBundle::layout.html.php') ?>

<?php $view['slots']->start('content') ?>
<h1>Hello <?php echo $view->escape($name) ?>!</h1>
<?php $view['slots']->stop() ?>

