<?php

namespace Liip\HelloBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Templating\TemplateReference,
    Symfony\Component\Routing\Exception\ResourceNotFoundException,
    Symfony\Component\HttpFoundation\Request,
    Symfony\Component\HttpFoundation\Response;

use FOS\RestBundle\View\View;
use Liip\HelloBundle\Document\Article;
use Doctrine\ODM\PHPCR\DocumentManager;

class VieController
{
    /**
     * @var FOS\RestBundle\View\View
     */
    protected $view;

    /**
     * @var Symfony\Component\HttpFoundation\Request
     */
    protected $request;

    /**
     * @var Doctrine\ODM\PHPCR\DocumentManager
     */
    protected $dm;

    public function __construct(View $view, Request $request, DocumentManager $dm)
    {
        $this->view = $view;
        $this->request = $request;
        $this->dm = $dm;
    }

    protected function getArticle($set_defaults = false)
    {
        $repo = $this->dm->getRepository('Liip\HelloBundle\Document\Article');

        try {
            $path = '/vie';
            $article = $repo->find($path);
        } catch (\Exception $e) {
            return new Response('Please run "app/console doctrine:phpcr:init:dbal"');
        }

        if (!$article) {
            $article = new Article();
            $article->setPath($path);
            if ($set_defaults) {
                $article->setTitle('Hello VIE!');
                $article->setBody('<p>
                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi.
                </p>');
            }
            $this->dm->persist($article);
        }

        return $article;
    }

    public function vieAction()
    {
        $this->view->setTemplate(new TemplateReference('LiipHelloBundle', 'Vie', 'index'));

        $article = $this->getArticle(true);
        $this->view->setParameters(array('article' => $article));

        return $this->view->handle();
    }

    public function vieJsonLdAction()
    {
        $jsonld = $this->request->request->all();
        $jsonld['dcterms:title'] = trim($jsonld['dcterms:title']).'!!!';
        $jsonld['sioc:content'] = trim($jsonld['sioc:content']);

        $article = $this->getArticle();
        $article->setTitle($jsonld['dcterms:title']);
        $article->setBody($jsonld['sioc:content']);

        $this->dm->flush();

        // return the updated version
        $this->view->setParameters($jsonld);
        return $this->view->handle();
    }
}
