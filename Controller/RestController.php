<?php

namespace Liip\HelloBundle\Controller;

use Symfony\Component\HttpFoundation\Request,
    Symfony\Component\Form\FormFactory,
    Symfony\Component\HttpFoundation\Session;

use FOS\RestBundle\Controller\Annotations\Prefix,
    FOS\RestBundle\Controller\Annotations\NamePrefix,
    FOS\RestBundle\Controller\Annotations\View,
    FOS\RestBundle\View\RouteRedirectView;

use Liip\HelloBundle\Document\Article;

/**
 * @Prefix("liip/hello/rest")
 * @NamePrefix("liip_hello_rest_")
 */
class RestController
{
    /**
     * @var Session
     */
    protected $session;

    /**
     * @var Symfony\Component\Form\FormFactory
     */
    protected $formFactory;

    public function __construct(Session $session, FormFactory $formFactory)
    {
        $this->session = $session;
        $this->formFactory = $formFactory;
    }

    /**
     * Get the list of articles
     *
     * @View()
     */
    public function getArticlesAction()
    {
        $articles = array('bim', 'bam', 'bingo');

        return array('articles' => $articles);
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
     * @View()
     */
    public function getNewArticlesAction()
    {
        $form = $this->getForm();

        return array('form' => $form);
    }

    /**
     * Create a new resource
     * 
     * @View()
     */
    public function postArticlesAction(Request $request)
    {
        $form = $this->getForm();

        $form->bindRequest($request);

        if ($form->isValid()) {
            // Note: FOSRestBundle will automatically move this flash message to a cookie
            $this->session->setFlash('article', $form->getData()->getTitle());
            // Note: normally one would likely create/update something in the database
            // and/or send an email and finally redirect to the resource url
            $view = RouteRedirectView::create('_welcome');
        } else {
            $view = View::create(array('form' => $form));
        }

        // Note: this would normally not be necessary, just a "hack" to make the format selectable in the form
        $view->setFormat($form->getData()->format);

        return $view;
    }

    /**
     * Get the article
     * 
     * @View()
     */
    public function getArticleAction($article)
    {
        $text = $article;
        $article = new Article();
        $article->setPath('/'.$text);
        $article->setTitle($text);
        $article->setBody("This article is about '$text' and its really great and all");

        return array('article' => $article);
    }
}
