<?php

namespace Liip\HelloBundle\Controller;

use Liip\HelloBundle\Document\Article;
use Symfony\Component\DependencyInjection\ContainerAware;

/**
 * imho injecting the container is a bad practice
 * however for the purpose of this demo it makes it easier since then not all Bundles are required
 * in order to play around with just a few of the actions.
 */
class PHPCRController extends ContainerAware
{
    public function indexAction($path)
    {
        $documentManager = $this->container->get('doctrine.phpcr_odm.document_manager');

        $repo = $documentManager->getRepository('Liip\HelloBundle\Document\Article');

        $article = $repo->find($path);
        if ($article) {
            $article->setBody((string)($article->getBody() + 1));
        } else {
            $article = new Article();
            $article->setPath($path);
            $article->setTitle('Foo');
            $article->setBody('1');
            $documentManager->persist($article);
        }

        $documentManager->flush();

        $view = $this->container->get('my_view');
        $view->setParameters(array('name' => $article->getBody()));
        $view->setTemplate(array('bundle' => 'LiipHelloBundle', 'controller' => 'Hello', 'name' => 'index'));

        return $view->handle();
    }
}
