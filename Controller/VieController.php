<?php

namespace Liip\HelloBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Templating\TemplateReference;
use FOS\RestBundle\View\ViewInterface;
use Liip\HelloBundle\Document\ArticleRepository;
use Liip\HelloBundle\Document\Article;

class VieController
{
    /**
     * @var FOS\RestBundle\View\ViewInterface
     */
    protected $view;

    /**
     * @var Liip\HelloBundle\Document\ArticleRepository
     */
    protected $repository;

    public function __construct(ViewInterface $view, ArticleRepository $repository)
    {
        $this->view = $view;
        $this->repository = $repository;
    }

    /**
     * Get the blog article
     */
    public function articleAction($id)
    {
        $path = '/'.urlencode($id);
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

        $this->view->setTemplate(new TemplateReference('LiipHelloBundle', 'Vie', 'article'));
        $this->view->setParameters(array('article' => $article));

        return $this->view;
    }
}
