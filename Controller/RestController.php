<?php

namespace Liip\HelloBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormFactory;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use FOS\RestBundle\Controller\Annotations\Prefix;
use FOS\RestBundle\Controller\Annotations\NamePrefix;
use FOS\RestBundle\View\View;

use Liip\HelloBundle\Document\Article;

/**
 * imho injecting the container is a bad practice, however this is the example for all magic enabled
 *
 * @Prefix("liip/hello/rest")
 * @NamePrefix("liip_hello_")
 */
class RestController extends ContainerAware
{
    /**
     * @var Symfony\Component\HttpFoundation\Request
     */
    protected $request;

    /**
     * @var FOS\RestBundle\View\View
     */
    protected $view;

    /**
     * @var Symfony\Component\Form\FormFactory
     */
    protected $formFactory;

    public function __construct(Request $request, View $view, FormFactory $formFactory)
    {
        $this->request = $request;
        $this->view = $view;
        $this->formFactory = $formFactory;
    }

    /**
     * @Template()
     */
    public function getArticlesAction()
    {
        $articles = array('bim', 'bam', 'bingo');
        $this->view->setParameters(array('articles' => $articles));

        return $this->view;
    }

    protected function getForm()
    {
        $article = new Article();

        return $this->formFactory->createBuilder('form', $article)
            ->add('path', 'text', array('required' => false))
            ->add('title', 'text', array('required' => false))
            ->add('body', 'text', array('required' => false))
            ->add('format', 'choice', array('choices' => array('html' => 'html', 'json' => 'json', 'xml' => 'xml')))
            ->getForm();
    }

    /**
     * @Template()
     */
    public function getNewArticlesAction()
    {
        $form = $this->getForm();

        $this->view->setParameters(array('form' => $form));

        return $this->view;
    }

    /**
     * @Template()
     */
    public function postArticlesAction()
    {
        $form = $this->getForm();

        $form->bindRequest($this->request);

        $this->view->setFormat($form->getData()->format);
        if ($form->isValid()) {
            // Note: normally one would likely create/update something in the database
            // and/or send an email and finally redirect to the resource url
            $this->view->setResourceRoute('_welcome');
            return $this->view;
        }
    }

    /**
     * @Template()
     */
    public function getArticleAction($article)
    {
        $this->view->setParameters(array('article' => $article));

        return $this->view;
    }
}
