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
    FOS\RestBundle\Request\ParamFetcherInterface;

use Liip\HelloBundle\Document\Article,
    Liip\HelloBundle\Response;

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
     * @param ParamFetcher $paramFetcher
     * @param string $page integer with the page number (requires param_fetcher_listener: force)
     * @return array data
     *
     * @View()
     * @QueryParam(name="page", requirements="\d+", default="1", description="Page of the overview.")
     * @ApiDoc()
     */
    public function getArticlesAction(ParamFetcherInterface $paramFetcher, $page)
    {
        // alternative of passing $page in via the method signature
        // which only requires setting query_fetcher_listener: true
        // $page = $paramFetcher->get('page');
        $articles = array('bim', 'bam', 'bingo');

        return new Response($articles, $page);
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
        //$view->setSerializerVersion('2.0');
        //$view->setSerializerGroups(array('data'));

        // via a callback its possible to dynamically set anything on the serializer
        // the following example is essentially the same as $view->setSerializerGroups(array('data'));
        //$view->setSerializerCallback(function ($viewHandler, $serializer) { $serializer->setGroups(array('data')); } );

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
     * @return Form form instance
     *
     * @View(templateVar="form")
     * @ApiDoc()
     */
    public function getNewArticlesAction()
    {
        $form = $this->getForm();

        return $form;
    }

    /**
     * Create a new resource
     *
     * @param Request $request
     * @return View view instance
     * 
     * @View(templateVar="form")
     * @ApiDoc()
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
