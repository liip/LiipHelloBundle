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
     * @var FOS\RestBundle\View\View
     */
    protected $view;

    public function __construct($view)
    {
        $this->view = $view;
    }

    /**
     * @extra:Template()
     */
    public function getSlugsAction()
    {
        $slugs = array('bim', 'bam', 'bingo');
        $this->view->setParameters(array('slugs' => $slugs));

        return $this->view;
    }

    /**
     * @extra:Template()
     */
    public function getSlugAction($slug)
    {
        $this->view->setParameters(array('slug' => $slug));

        return $this->view;
    }
}
