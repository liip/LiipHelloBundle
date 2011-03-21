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
     * @extra:Routes({
     *   @extra:Route("/extra.{_format}", name="_extra_noname", defaults={"_format"="html"}),
     *   @extra:Route("/extra/{name}.{_format}", name="_extra_name", defaults={"_format"="html"})
     * })
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
