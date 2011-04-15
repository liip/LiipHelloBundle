<?php

namespace Liip\HelloBundle\Controller;

use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer,
    Symfony\Bundle\FrameworkBundle\Templating\TemplateReference;

/**
 * imho injecting the container is a bad practice
 * however for the purpose of this demo it makes it easier since then not all Bundles are required
 * in order to play around with just a few of the actions.
 */
class HelloController
{
    /**
     * @var Liip\ViewBundle\View\DefaultView
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
        $view->setTemplate(array('bundle' => 'LiipHelloBundle', 'controller' => 'Hello', 'name' => 'facebook'));

        return $view->handle();
    }
}
