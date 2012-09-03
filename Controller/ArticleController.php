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
 * @Prefix("liip/hello/r3st")
 * @NamePrefix("liip_hello_r3st_")
 * Following annotation is redundant, since FosRestController implements ClassResourceInterface
 * so the Controller name is used to define the resource. However with this annotation its
 * possible to set the resource to something else unrelated to the Controller name
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
    public function cgetAction($page)
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
     * Display the edit form
     *
     * @param string $article path
     * @return Form form instance
     *
     * @View(template="LiipHelloBundle:Article:new.html.twig")
     * @ApiDoc()
     */
    public function editAction($article)
    {
        $article = $this->createArticle($article);
        return $this->getForm($article);
    }

    private function createArticle($article)
    {
        $text = $article;
        $article = new Article();
        $article->setPath('/'.$text);
        $article->setTitle($text);
        $article->setBody("This article is about '$text' and its really great and all");

        return $article;
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
        $article = $this->createArticle($article);

        // using explicit View creation
        return $this->view(array('article' => $article));
    }

    protected function getForm($article = null)
    {
        return $this->createForm(new ArticleType(), $article);
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
    public function cpostAction(Request $request)
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
