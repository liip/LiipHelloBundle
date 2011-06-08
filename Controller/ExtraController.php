<?php

namespace Liip\HelloBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * imho injecting the container is a bad practice, however this is the example for all magic enabled
 * 
 * @Route("/liip")
 */
class ExtraController extends ContainerAware
{
    /**
     * @Route("/extra.{_format}", name="_extra_noname", defaults={"_format"="html"}),
     * @Route("/extra/{name}.{_format}", name="_extra_name", defaults={"_format"="html"})
     * @Template()
     */
    public function indexAction($name = null)
    {
        // fall back to standard FrameworkExtraBundle behavior
//        return array('name' => $name);

        $view = $this->container->get('fos_rest.view');

//        $view->setEngine('php');

        if (!$name) {
            $view->setResourceRoute('_welcome');
        }

        return $view;
    }
}
