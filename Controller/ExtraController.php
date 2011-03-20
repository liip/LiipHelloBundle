<?php

namespace Liip\HelloBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;

/**
 * imho injecting the container is a bad practice
 * however for the purpose of this demo it makes it easier since then not all Bundles are required
 * in order to play around with just a few of the actions.
 * 
 * @extra:Route("/liip")
 */
class ExtraController extends ContainerAware
{
    /**
     * @extra:Route("/extra/{name}", name="_extra")
     * @extra:Template()
     */
    public function indexAction($name = null)
    {
        $view = $this->container->get('liip_view');

//        $view->setEngine('php');

        if (!$name) {
            $view->setRouteRedirect('homepage');
        }

        return $view;
    }
}
