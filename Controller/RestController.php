<?php

namespace Liip\HelloBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;

/**
 * imho injecting the container is a bad practice, however this is the example for all magic enabled
 *
 * @rest:Prefix("liip/hello/rest")
 * @rest:NamePrefix("liip_hello_")
 */
class RestController extends ContainerAware
{
    /**
     * @extra:Template()
     */
    public function getSlugsAction()
    {
        $slugs = array('bim', 'bam', 'bingo');
        $view = $this->container->get('fos_rest.view');
        $view->setParameters(array('slugs' => $slugs));

        return $view;
    }

    /**
     * @extra:Template()
     */
    public function getSlugAction($slug)
    {
        $view = $this->container->get('fos_rest.view');
        $view->setParameters(array('slug' => $slug));

        return $view;
    }
}
