<?php

namespace Liip\HelloBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;

/**
 * imho injecting the container is a bad practice
 * however for the purpose of this demo it makes it easier since then not all Bundles are required
 * in order to play around with just a few of the actions.
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
