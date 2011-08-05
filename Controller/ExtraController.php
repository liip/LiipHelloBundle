<?php

namespace Liip\HelloBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use FOS\RestBundle\View\ViewInterface;

/**
 * @Route("/liip", service="liip_hello.extra.controller")
 */
class ExtraController
{
    /**
     * @var FOS\RestBundle\View\ViewInterface
     */
    protected $view;

    public function __construct(ViewInterface $view)
    {
        $this->view = $view;
    }

    /**
     * @Route("/extra.{_format}", name="_extra_noname", defaults={"_format"="html"}),
     * @Route("/extra/{name}.{_format}", name="_extra_name", defaults={"_format"="html"})
     * @Template()
     */
    public function indexAction($name = null)
    {
        // fall back to standard FrameworkExtraBundle behavior
//        return array('name' => $name);

//        $this->view->setEngine('php');

        if (!$name) {
            $this->view->setResourceRoute('_welcome');
        }

        return $this->view;
    }
}
