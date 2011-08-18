<?php

namespace Liip\HelloBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Templating\TemplateReference;
use FOS\RestBundle\View\ViewHandlerInterface;
use FOS\RestBundle\View\View;
use Liip\HelloBundle\Document\ArticleRepository;
use Liip\HelloBundle\Document\Article;

class VieController
{
    /**
     * @var FOS\RestBundle\View\ViewInterface
     */
    protected $viewHandler;

    /**
     * @var Liip\HelloBundle\Document\ArticleRepository
     */
    protected $repository;

    public function __construct(ViewHandlerInterface $viewHandler, ArticleRepository $repository)
    {
        $this->viewHandler = $viewHandler;
        $this->repository = $repository;

        $this->ensureVieNode();
    }

    protected function ensureVieNode()
    {
        // ensure that /vie exists
        $path = '/vie';
        $article = $this->repository->find($path);
        if (!$article) {
            $article = $this->repository->create();
            $article->setPath($path);
            $article->setTitle('Vie subnode');
            $article->setBody('');
            $dm = $this->repository->getDocumentManager();
            $dm->persist($article);
            $dm->flush();
        }
    }

    /**
     * Get the blog article
     */
    public function articleAction($id)
    {
        $path = '/vie/'.urlencode($id);
        $article = $this->repository->find($path);
        if (!$article) {
            $article = new Article();
            $article->setPath($path);
            $article->setTitle('Enter title');
            $article->setBody('<p>Enter body</p>');
            $dm = $this->repository->getDocumentManager();
            $dm->persist($article);
            $dm->flush();
        }

        $view = View::create(array('article' => $article))
            ->setTemplate(new TemplateReference('LiipHelloBundle', 'Vie', 'article'))
        ;

        return $this->viewHandler->handle($view);
    }
}
