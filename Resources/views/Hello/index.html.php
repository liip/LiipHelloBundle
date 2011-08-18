<?php $view->extend('LiipHelloBundle::layout.html.php') ?>

<?php $view['slots']->start('content') ?>
Hello <?php echo $view->escape($name) ?>!
<?php $view['slots']->stop() ?>

