<?php

namespace Liip\HelloBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Templating\TemplateReference,
    Symfony\Component\Routing\Exception\ResourceNotFoundException,
    Symfony\Component\Validator\ValidatorInterface;

use Doctrine\Common\Cache\Cache;

use FOS\RestBundle\View\View,
    FOS\RestBundle\View\ViewHandler,
    FOS\RestBundle\View\RouteRedirectView;
use Liip\HelloBundle\Document\Article;

class HelloController
{
    /**
     * @var ViewHandler
     */
    protected $viewHandler;

    /**
     * @var ValidatorInterface
     */
    protected $validator;

    /**
     * @var Cache
     */
    protected $cache;

    public function __construct(ViewHandler $viewHandler, ValidatorInterface $validator, Cache $cache)
    {
        $this->viewHandler = $viewHandler;
        $this->validator = $validator;
        $this->cache = $cache;
    }

    public function indexAction($name = null)
    {
        if (!$name) {
            $view = RouteRedirectView::create('_welcome');
        } else {
            $view = View::create(array('name' => $name))
//                ->setEngine('php');
                ->setTemplate(new TemplateReference('LiipHelloBundle', 'Hello', 'index'));
            ;
        }

        return $this->viewHandler->handle($view);
    }

    public function serializerAction()
    {
        $article = new Article();
        $article->setPath('/foo');
        $article->setTitle('Example use of the default handlers');
        $article->setBody("Read up on JMSSerializerBundle to see how what other handlers exist ");

        $view = new View();
        $view->setData($article);
        $view->setSerializerVersion('2.1');
        $view->setSerializerGroups(array('data'));

        return $this->viewHandler->handle($view);
    }

    public function exceptionAction()
    {
        throw new ResourceNotFoundException("This should return a 404 response if FOSRestBundle is configured accordingly
fos_rest:
    exception:
        code:
            'Symfony\Component\Routing\Exception\ResourceNotFoundException': 404");
    }

    public function validationFailureAction()
    {
        $validator = $this->validator;

        $article = new Article();
        //$article->setPath('/foo');
        $article->setTitle('The path was set');
        $article->setBody('Disable the setPath() call to get a validation error example');

        $view = new View();

        $errors = $validator->validate($article);
        if (count($errors)) {
            $view->setStatusCode(400);
            $view->setData($errors);
        } else {
            $view->setData($article);
        }

        return $this->viewHandler->handle($view);
    }

    public function facebookAction()
    {
        // example of hardcoding the full template name
        $view = new View();
        $view->setTemplate('LiipHelloBundle:Hello:facebook.html.twig');

        return $this->viewHandler->handle($view);
    }

    public function hyphenatorAction()
    {
        $view = new View();
        $view->setTemplate('LiipHelloBundle:Hello:hyphenator.html.twig');

        return $this->viewHandler->handle($view);
    }

    public function customHandlerAction()
    {
        $view = new View();
        return $this->viewHandler->handle($view);
    }

    public function imagineAction()
    {
        $view = new View();
        $view->setTemplate('LiipHelloBundle:Hello:imagine.html.twig');

        return $this->viewHandler->handle($view);
    }

    public function apcAction()
    {
        if (!function_exists('apc_fetch')) {
            throw new \Exception('ext/apc needs to be enabled');
        }

        $int = (int)$this->cache->fetch('int');
        $this->cache->set('int', ++$int);

        $view = View::create(array('name' => 'Cached '.$int))
            ->setTemplate(new TemplateReference('LiipHelloBundle', 'Hello', 'index'));
        ;
        return $this->viewHandler->handle($view);
    }
}
