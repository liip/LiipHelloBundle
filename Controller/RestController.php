<?php

namespace Liip\HelloBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Form;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Liip\HelloBundle\Document\Article;
use Liip\HelloBundle\Form\ArticleType;
use Liip\HelloBundle\Response as HelloResponse;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class RestController extends Controller
{
    /**
     * Get the list of articles.
     *
     * @param ParamFetcher $paramFetcher
     * @param string       $page         integer with the page number (requires param_fetcher_listener: force)
     *
     * @return array data
     *
     * @QueryParam(name="page", requirements="\d+", default="1", description="Page of the overview.")
     * @ApiDoc()
     */
    public function getArticlesAction(ParamFetcherInterface $paramFetcher)
    {
        $page = $paramFetcher->get('page');
        $articles = array('bim', 'bam', 'bingo');

        $data = new HelloResponse($articles, $page);
        $view = new View($data);
        $view->setTemplate('LiipHelloBundle:Rest:getArticles.html.twig');

        return $this->get('fos_rest.view_handler')->handle($view);
    }

    /**
     * Display the form.
     *
     * @return Form form instance
     *
     * @ApiDoc()
     */
    public function newArticleAction()
    {
        $data = $this->getForm(null, 'post_articles');
        $view = new View($data);
        $view->setTemplate('LiipHelloBundle:Rest:newArticle.html.twig');

        return $this->get('fos_rest.view_handler')->handle($view);
    }

    /**
     * Display the edit form.
     *
     * @param string $article path
     *
     * @return Form form instance
     *
     * @ApiDoc()
     */
    public function editArticleAction($article)
    {
        $article = $this->createArticle($article);
        $data = $this->getForm($article);
        $view = new View($data);
        $view->setTemplate('LiipHelloBundle:Rest:newArticle.html.twig');

        return $this->get('fos_rest.view_handler')->handle($view);
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
     * Get the article.
     *
     * @param string $article path
     *
     * @return View view instance
     *
     * @ApiDoc()
     */
    public function getArticleAction($article, Request $request, $_format)
    {
        $data = $this->createArticle($article);

        if ('xml' === $request->getRequestFormat()) {
            // Using SimpleThingsFormSerializerBundle
//            $serializer = $this->get('form_serializer');
//            $data       = $serializer->serialize($data, new ArticleType(), 'xml');
//            return new Response($data);
        }

        // using explicit View creation
        $view = new View($data);

        // since we override the default handling for JSON, this will only affect XML
        //$view->setSerializerVersion('2.0');
        //$view->setSerializerGroups(array('data'));

        // via a callback its possible to dynamically set anything on the serializer
        // the following example is essentially the same as $view->setSerializerGroups(array('data'));
        //$view->setSerializerCallback(function ($viewHandler, $serializer) { $serializer->setGroups(array('data')); } );

        $view->setTemplate('LiipHelloBundle:Rest:getArticle.html.twig');

        return $this->get('fos_rest.view_handler')->handle($view);
    }

    /**
     * Get a Form instance.
     *
     * @param Article|null $article
     * @param string|null  $routeName
     *
     * @return Form
     */
    protected function getForm($article = null, $routeName = null)
    {
        $options = array();
        if (null !== $routeName) {
            $options['action'] = $this->generateUrl($routeName);
        }

        if (null === $article) {
            $article = new Article();
        }

        return $this->createForm(new ArticleType(), $article, $options);
    }

    /**
     * Create a new resource.
     *
     * @param Request $request
     *
     * @return View view instance
     *
     * @ApiDoc()
     */
    public function postArticlesAction(Request $request)
    {
        $form = $this->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            // Note: use FOSHttpCacheBundle to automatically move this flash message to a cookie
            $this->get('session')->getFlashBag()->set('article', 'Article is stored at path: '.$form->getData()->getPath());

            // Note: normally one would likely create/update something in the database
            // and/or send an email and finally redirect to the newly created or updated resource url
            $view = View::createRouteRedirect('hello', array('name' => $form->getData()->getTitle()));
        } else {
            $view = View::create($form);
            $view->setTemplate('LiipHelloBundle:Rest:postArticles.html.twig');
        }

        // Note: this would normally not be necessary, just a "hack" to make the format selectable in the form
        $view->setFormat($form->getData()->format);

        return $this->get('fos_rest.view_handler')->handle($view);
    }
}
