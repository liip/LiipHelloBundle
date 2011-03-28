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
        // fall back to standard FrameworkExtraBundle behavior
//        return array('name' => $name);

        $view = $this->container->get('fos_rest.view');

//        $view->setEngine('php');

        if (!$name) {
            $view->setRouteRedirect('homepage');
        }

        return $view;
    }
}
