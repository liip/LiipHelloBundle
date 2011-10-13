<?php

namespace Liip\HelloBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Templating\TemplateReference;

use FOS\RestBundle\View\View,
    FOS\RestBundle\View\ViewHandler;

class TreeController
{
    /**
     * @var FOS\RestBundle\View\ViewHandler
     */
    protected $viewHandler;

    public function __construct(ViewHandler $viewHandler)
    {
        $this->viewHandler = $viewHandler;
    }

    public function indexAction()
    {
        $view = View::create()
            ->setTemplate(new TemplateReference('LiipHelloBundle', 'Tree', 'index'));
        ;

        return $this->viewHandler->handle($view);
    }
}
