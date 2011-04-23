<?php

namespace Liip\HelloBundle\Controller;

use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer,
    Symfony\Bundle\FrameworkBundle\Templating\TemplateReference;

class HelloController
{
    /**
     * @var FOS\RestBundle\View\View
     */
    protected $view;

    public function __construct($view)
    {
        $this->view = $view;
    }

    public function indexAction($name = null)
    {
        $view = $this->view;

//        $view->setEngine('php');

        if (!$name) {
            $view->setRouteRedirect('homepage');
        } else {
            $view->setParameters(array('name' => $name));
            $view->setTemplate(new TemplateReference('LiipHelloBundle', 'Hello', 'index'));
        }

        return $view->handle();
    }

    public function serializerAction()
    {
        $view = $this->view;

        $article = new Article();
        $article->setPath('/foo');
        $article->setTitle('Foo');
        $article->setBody('1');

        $serializer = $view->getSerializer();
        $serializer->addNormalizer(new GetSetMethodNormalizer());

        $view->setParameters($article);

        return $view->handle();
    }

    public function facebookAction()
    {
        $view = $this->view;

        // example of hardcoding the full template name
        $view->setTemplate('LiipHelloBundle:Hello:facebook.html.twig');

        return $view->handle();
    }
}
