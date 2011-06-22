<?php

namespace Liip\HelloBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Session;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use FOS\RestBundle\Controller\Annotations\Prefix;
use FOS\RestBundle\Controller\Annotations\NamePrefix;
use FOS\RestBundle\View\View;

use Liip\HelloBundle\Document\Article;

/**
 * @Prefix("liip/hello/rest")
 * @NamePrefix("liip_hello_")
 */
class RestController
{
    /**
     * @var Symfony\Component\HttpFoundation\Request
     */
    protected $request;

    /**
     * @var Session
     */
    protected $session;

    /**
     * @var FOS\RestBundle\View\View
     */
    protected $view;

    /**
     * @var Symfony\Component\Form\FormFactory
     */
    protected $formFactory;

    public function __construct(Request $request, Session $session, View $view, FormFactory $formFactory)
    {
        $this->request = $request;
        $this->session = $session;
        $this->view = $view;
        $this->formFactory = $formFactory;
    }

    /**
     * Get the list of articles
     *
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
     * Display the form
     * 
     * @Template()
     */
    public function getNewArticlesAction()
    {
        $form = $this->getForm();

        $this->view->setParameters(array('form' => $form));

        return $this->view;
    }

    /**
     * Create a new resource
     * 
     * @Template()
     */
    public function postArticlesAction()
    {
        $form = $this->getForm();

        $form->bindRequest($this->request);

        // Note: this would normally not be necessary, just a "hack" to make the format selectable in the form
        $this->view->setFormat($form->getData()->format);
        if ($form->isValid()) {
            // Note: FOSRestBundle will automatically move this flash message to a cookie
            $this->session->setFlash('article', $form->getData()->getTitle());
            // Note: normally one would likely create/update something in the database
            // and/or send an email and finally redirect to the resource url
            $this->view->setResourceRoute('_welcome');
        } else {
            $this->view->setParameters(array('form' => $form));
        }

        return $this->view;
    }

    /**
     * Get the article
     * 
     * @Template()
     */
    public function getArticleAction($article)
    {
        $text = $article;
        $article = new Article();
        $article->setPath('/'.$text);
        $article->setTitle($text);
        $article->setBody("This article is about '$text' and its really great and all");
        $this->view->setParameters(array('article' => $article));

        return $this->view;
    }
}
