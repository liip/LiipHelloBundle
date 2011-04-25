<?php

namespace Liip\HelloBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Templating\TemplateReference,
    Symfony\Component\Routing\Matcher\Exception\NotFoundException;

use Liip\HelloBundle\Document\Article;

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
            $view->setRouteRedirect('_welcome');
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
        $article->setTitle('Example use of the GetSetMethodNormalizer normalizer');
        $article->setBody("fos_rest:
    normalizers:
        'Liip\\HelloBundle\\Document\\Article': 'liip_hello.get_set_method_normalizer'");

        $view->setParameters($article);

        return $view->handle();
    }

    public function exceptionAction()
    {
        throw new NotFoundException("This should return a 404 response if FOSRestBundle is configured accordingly
fos_rest:
    exception:
        code:
            'Symfony\Component\Routing\Matcher\Exception\NotFoundException': 404");
    }

    public function facebookAction()
    {
        $view = $this->view;

        // example of hardcoding the full template name
        $view->setTemplate('LiipHelloBundle:Hello:facebook.html.twig');

        return $view->handle();
    }
}
