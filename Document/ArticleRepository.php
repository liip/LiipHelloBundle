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
        $path = $document->getPath();
        if ('' == $path) {
            return $this->appendRootNodePath($document->getTitle());
        }

        return $path;
    }

    public function appendRootNodePath($name)
    {
        return '/'.$name;
    }

    public function create()
    {
        return new Article();
    }
}
