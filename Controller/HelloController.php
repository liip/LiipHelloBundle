<?php

namespace Liip\HelloBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Templating\TemplateReference,
    Symfony\Component\Routing\Exception\ResourceNotFoundException,
    Symfony\Component\Validator\ValidatorInterface;

use FOS\RestBundle\View\View;
use Liip\HelloBundle\Document\Article;

class HelloController
{
    /**
     * @var FOS\RestBundle\View\View
     */
    protected $view;

    /**
     * @var Symfony\Component\Validator\ValidatorInterface
     */
    protected $validator;

    public function __construct(View $view, ValidatorInterface$validator)
    {
        $this->view = $view;
        $this->validator = $validator;
    }

    public function indexAction($name = null)
    {
//        $this->view->setEngine('php');

        if (!$name) {
            $this->view->setResourceRoute('_welcome');
        } else {
            $this->view->setParameters($name);
            $this->view->setTemplate(new TemplateReference('LiipHelloBundle', 'Hello', 'index'));
        }

        return $this->view->handle();
    }

    public function serializerAction()
    {
        $article = new Article();
        $article->setPath('/foo');
        $article->setTitle('Example use of the GetSetMethodNormalizer normalizer');
        $article->setBody("fos_rest:
    normalizers:
        'Liip\\HelloBundle\\Document\\Article': 'liip_hello.get_set_method_normalizer'");

        $this->view->setParameters($article);

        return $this->view->handle();
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

        $errors = $validator->validate($article);
        if (!count($errors)) {
            $this->view->setParameters($article);
        } else {
            $this->view->setFailedValidationStatusCode();
            $this->view->setParameters($errors);
        }

        return $this->view->handle();
    }

    public function facebookAction()
    {
        // example of hardcoding the full template name
        $this->view->setTemplate('LiipHelloBundle:Hello:facebook.html.twig');

        return $this->view->handle();
    }
}
