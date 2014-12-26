<?php

namespace Liip\HelloBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Templating\TemplateReference,
    Symfony\Component\Routing\Exception\ResourceNotFoundException,
    Symfony\Component\Validator\ValidatorInterface;

use FOS\RestBundle\View\View,
    FOS\RestBundle\View\ViewHandler,
    FOS\RestBundle\View\RouteRedirectView;

use JMS\Serializer\SerializationContext;

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

    public function __construct(ViewHandler $viewHandler, ValidatorInterface $validator)
    {
        $this->viewHandler = $viewHandler;
        $this->validator = $validator;
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
        $context = new SerializationContext();
        $context->setVersion('2.1');
        $context->setGroups(array('data'));
        $view->setSerializationContext($context);

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

    public function jsonpAction()
    {
        $data = array('foo' => 'bar');
        $view = new View($data);
        $view->setFormat('jsonp');

        return $this->viewHandler->handle($view);
    }
}
