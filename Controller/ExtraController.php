<?php

namespace Liip\HelloBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;

/**
 * imho injecting the container is a bad practice, however this is the example for all magic enabled
 * 
 * @extra:Route("/liip")
 */
class ExtraController extends ContainerAware
{
    /**
     * @extra:Route("/extra/{name}", name="_extra_name")
     * @extra:Template()
     */
    public function indexAction($name = null)
    {
        $view = $this->container->get('liip_view');

//        $view->setEngine('php');

        if (!preg_match('/[a-z0-9 ]/', $name)) {
            $view->setRouteRedirect('homepage');
        }

        return $view;
    }
}
