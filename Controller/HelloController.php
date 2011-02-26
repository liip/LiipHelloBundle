<?php

namespace Liip\HelloBundle\Controller;

class HelloController
{
    public function __construct($view)
    {
        $this->view = $view;
    }

    public function indexAction($name = null)
    {
        $view = $this->view;

        $view->setEngine('php');

        if (!$name) {
            $this->view->setRouteRedirect('homepage');
        } else {
            $view->setParameters(array('name' => $name));
            $view->setTemplate(array('bundle' => 'LiipHelloBundle', 'controller' => 'Hello', 'name' => 'index'));
        }

        return $view->handle();
    }
}
