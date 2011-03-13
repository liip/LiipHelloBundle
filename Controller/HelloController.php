<?php

namespace Liip\HelloBundle\Controller;

class HelloController
{
    /**
     * @var Liip\ViewBundle\View\DefaultView
     */
    protected $view;

    public function __construct($view)
    {
        $this->view = $view;
    }

    public function indexAction($name = null)
    {
        $view = $this->view;

//        $view->setEngine('php');

        if (!$name) {
            $view->setRouteRedirect('homepage');
        } else {
            $view->setParameters(array('name' => $name));
            $view->setTemplate(array('bundle' => 'LiipHelloBundle', 'controller' => 'Hello', 'name' => 'index'));
        }

        return $view->handle();
    }

    public function facebookAction($name = null)
    {
        $view = $this->view;
        $view->setTemplate(array('bundle' => 'LiipHelloBundle', 'controller' => 'Hello', 'name' => 'facebook'));

        return $view->handle();
    }
}
