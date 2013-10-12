<?php

namespace Liip\HelloBundle\Controller;

use Doctrine\ODM\PHPCR\Document\File;
use Doctrine\ODM\PHPCR\Document\Generic;

use Liip\HelloBundle\Document\Article;

use PHPCR\Util\NodeHelper;

use Symfony\Component\DependencyInjection\ContainerAware,
    Symfony\Bundle\FrameworkBundle\Templating\TemplateReference,
    Symfony\Component\HttpKernel\Exception\ConflictHttpException;

use FOS\RestBundle\Util\Codes;
use FOS\RestBundle\View\View;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * imho injecting the container is a bad practice
 * however for the purpose of this demo it makes it easier since then not all Bundles are required
 * in order to play around with just a few of the actions.
 */
class PHPCRController extends ContainerAware
{
    public function indexAction($title)
    {
        $viewHandler = $this->container->get('my_view');

        $view = new View();
        $view->setTemplate(new TemplateReference('LiipHelloBundle', 'Hello', 'index'));

        try {
            $documentManager = $this->container->get('doctrine_phpcr')->getManager();
            $repo = $documentManager->getRepository('Liip\HelloBundle\Document\Article');
            $article = $repo->find($repo->appendRootNodePath($title));
        } catch (\Exception $e) {
            $view->setData(array('name' => 'Did you run "app/console doctrine:phpcr:init:dbal" yet? (Exception: '.$e->getMessage()));
            return $viewHandler->handle($view);
        }

        if ($article) {
            $article->setBody((string)($article->getBody() + 1));
        } else {
            $article = new Article();
            $article->setTitle($title);
            $article->setBody('1');
            $documentManager->persist($article);
        }

        $documentManager->flush();

        $view->setData(array('name' => $title.' '.$article->getBody()));

        return $viewHandler->handle($view);
    }

    /**
     * alternatively use class="LiipHelloBundle:Article", but this has a bit more overhead
     *
     * @ParamConverter("article", class="Liip\HelloBundle\Document\Article")
     */
    public function converterAction(Article $article = null)
    {
        $view = new View();
        $view->setTemplate(new TemplateReference('LiipHelloBundle', 'Hello', 'index'));

        $name = $article ? 'found: '.$article->getTitle() : 'No found';

        $view->setData(array('name' => $name));

        $viewHandler = $this->container->get('my_view');
        return $viewHandler->handle($view);
    }
}
