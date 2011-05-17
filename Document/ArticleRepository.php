<?php

namespace Liip\HelloBundle\Document;

use Doctrine\ODM\PHPCR\Id\RepositoryIdInterface,
    Doctrine\ODM\PHPCR\DocumentRepository;

class ArticleRepository extends DocumentRepository implements RepositoryIdInterface
{
    /**
     * Generate a document id
     *
     * @param object $document
     * @return string
     */
    public function generateId($document)
    {
        return $this->appendRootNodePath($document->getTitle());
    }

    public function appendRootNodePath($name)
    {
        return '/'.$name;
    }
}
