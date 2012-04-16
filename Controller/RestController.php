<?php

namespace Liip\HelloBundle\Controller;

use Symfony\Component\HttpFoundation\Request,
    Symfony\Bundle\FrameworkBundle\Controller\Controller;

use FOS\RestBundle\Controller\Annotations\Prefix,
    FOS\RestBundle\Controller\Annotations\NamePrefix,
    FOS\RestBundle\Controller\Annotations\View,
    FOS\RestBundle\View\RouteRedirectView,
    FOS\RestBundle\View\View AS FOSView,
    FOS\RestBundle\Controller\Annotations\QueryParam,
    FOS\RestBundle\Request\QueryFetcher;

use Liip\HelloBundle\Document\Article;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

/**
 * @Prefix("liip/hello/rest")
 * @NamePrefix("liip_hello_rest_")
 */
class RestController extends Controller
{
    /**
     * Get the list of articles
     *
     * @View()
     * @QueryParam(name="page", requirements="\d+", default="1", description="Page of the overview.")
     * @ApiDoc(
     *  description="Get a list of all articles"
     * )
     */
    public function getArticlesAction(QueryFetcher $queryFetcher)
    {
        $page = $queryFetcher->getParameter('page');
        $articles = array('bim', 'bam', 'bingo');

        return array('articles' => $articles, 'page' => $page);
    }

    /**
     * Get the article
     *
     * @View()
     * @ApiDoc(
     *  description="Get an article"
     * )
     */
    public function getArticleAction($article)
    {
        $text = $article;
        $article = new Article();
        $article->setPath('/'.$text);
        $article->setTitle($text);
        $article->setBody("This article is about '$text' and its really great and all");

        // using explicit View creation
        $view = new FOSView(array('article' => $article));
        // since we override the default handling for JSON, this will only affect XML
        $view->setObjectsGroups('data');
        return $view;
    }

    protected function getForm()
    {
        $article = new Article();

        return $this->get('form.factory')->createBuilder('form', $article)
            ->add('path', 'text', array('required' => false))
            ->add('title', 'text', array('required' => false))
            ->add('body', 'text', array('required' => false))
            ->add('format', 'choice', array('choices' => array('html' => 'html', 'json' => 'json', 'xml' => 'xml')))
            ->getForm();
    }

    /**
     * Display the form
     * 
     * @View(templateVar="form")
     * @ApiDoc(
     *  description="Get the form to create a new article"
     * )
     */
    public function getNewArticlesAction()
    {
        $form = $this->getForm();

        return $form;
    }

    /**
     * Create a new resource
     * 
     * @View(templateVar="form")
     * @ApiDoc(
     *  description="Create a new article"
     * )
     */
    public function postArticlesAction(Request $request)
    {
        $form = $this->getForm();

        $form->bindRequest($request);

        if ($form->isValid()) {
            // Note: use LiipCacheControlBundle to automatically move this flash message to a cookie
            $this->get('session')->setFlash('article', 'Article is stored at path: '.$form->getData()->getPath());

            // Note: normally one would likely create/update something in the database
            // and/or send an email and finally redirect to the newly created or updated resource url
            $view = RouteRedirectView::create('hello', array('name' => $form->getData()->getTitle()));
        } else {
            $view = FOSView::create($form);
        }

        // Note: this would normally not be necessary, just a "hack" to make the format selectable in the form
        $view->setFormat($form->getData()->format);

        return $view;
    }
}
