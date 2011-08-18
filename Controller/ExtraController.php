<?php

namespace Liip\HelloBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use FOS\RestBundle\View\RedirectView,
    FOS\RestBundle\Controller\Annotations\View;

/**
 * @Route("/liip", service="liip_hello.extra.controller")
 */
class ExtraController
{
    /**
     * @Route("/extra.{_format}", name="_extra_noname", defaults={"_format"="html"}),
     * @Route("/extra/{name}.{_format}", name="_extra_name", defaults={"_format"="html"})
     * @View()
     */
    public function indexAction($name = null)
    {
        if (!$name) {
            return RedirectView::create('http://liip.ch');
        }

        return array('name' => $name);
    }
}
