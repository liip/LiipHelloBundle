<?php

namespace Liip\HelloBundle\Controller;

use Symfony\Component\HttpFoundation\Request;

use FOS\RestBundle\Controller\Annotations\Prefix,
    FOS\RestBundle\Controller\Annotations\NamePrefix,
    FOS\RestBundle\Controller\Annotations\RouteResource,
    FOS\RestBundle\Controller\Annotations\View,
    FOS\RestBundle\Controller\Annotations\QueryParam,
    FOS\RestBundle\Controller\FOSRestController;

use Liip\HelloBundle\Document\Article,
    Liip\HelloBundle\Form\ArticleType,
    Liip\HelloBundle\Response;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

/**
 * @Prefix("liip/hello/rest_class")
 * @NamePrefix("liip_hello_rest_class_")
 * Following annotation is redundant, since the Controller nam already implicitly defines the same resource
 * However it speeds up route generation, since its not necessary to guess if the resource should be guessed
 * from the Controller or the Action names
 * @RouteResource("Article")
 */
class ArticleController extends FosRestController
{
    /**
     * Get the list of articles
     *
     * @param string $page integer with the page number (requires param_fetcher_listener: force)
     * @return array data
     *
     * @View()
     * @QueryParam(name="page", requirements="\d+", default="1", description="Page of the overview.")
     * @ApiDoc()
     */
    public function getListAction($page)
    {
        $articles = array('bim', 'bam', 'bingo');

        return new Response($articles, $page);
    }

    /**
     * Display the form
     *
     * @return Form form instance
     *
     * @View()
     * @ApiDoc()
     */
    public function newAction()
    {
        return $this->getForm();
    }

    /**
     * Get the article
     *
     * @param string $article path
     * @return View view instance
     *
     * @View()
     * @ApiDoc()
     */
    public function getAction($article)
    {
        $text = $article;
        $article = new Article();
        $article->setPath('/'.$text);
        $article->setTitle($text);
        $article->setBody("This article is about '$text' and its really great and all");

        // using explicit View creation
        return $this->view(array('article' => $article));
    }

    protected function getForm()
    {
        return $this->createForm(new ArticleType());
    }

    /**
     * Create a new resource
     *
     * @param Request $request
     * @return View view instance
     *
     * @View()
     * @ApiDoc()
     */
    public function postListAction(Request $request)
    {
        $form = $this->getForm();

        $form->bind($request);

        if ($form->isValid()) {
            // Note: use LiipCacheControlBundle to automatically move this flash message to a cookie
            $this->get('session')->setFlash('article', 'Article is stored at path: '.$form->getData()->getPath());

            // Note: normally one would likely create/update something in the database
            // and/or send an email and finally redirect to the newly created or updated resource url
            $view = $this->routeRedirectView('hello', array('name' => $form->getData()->getTitle()));
        } else {
            $view = $this->view($form);
        }

        // Note: this would normally not be necessary, just a "hack" to make the format selectable in the form
        $view->setFormat($form->getData()->format);

        return $view;
    }
}
