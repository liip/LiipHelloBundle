<?php

namespace Liip\HelloBundle\Controller;

use Liip\HelloBundle\Document\Article;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Bundle\FrameworkBundle\Templating\TemplateReference;

/**
 * imho injecting the container is a bad practice
 * however for the purpose of this demo it makes it easier since then not all Bundles are required
 * in order to play around with just a few of the actions.
 */
class PHPCRController extends ContainerAware
{
    public function indexAction($title)
    {
        $view = $this->container->get('my_view');
        $view->setTemplate(new TemplateReference('LiipHelloBundle', 'Hello', 'index'));

        $documentManager = $this->container->get('doctrine_phpcr.odm.document_manager');
        $repo = $documentManager->getRepository('Liip\HelloBundle\Document\Article');

        try {
            $article = $repo->find($repo->appendRootNodePath($title));
        } catch (\Exception $e) {
            $view->setParameters(array('name' => 'Did you run "app/console doctrine:phpcr:init:dbal" yet? (Exception: '.$e->getMessage()));
            return $view->handle();
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

        $view->setParameters(array('name' => $article->getBody()));

        return $view->handle();
    }
}
