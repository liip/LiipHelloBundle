<?php

namespace Liip\HelloBundle\Document;

use Doctrine\ODM\PHPCR\Id\RepositoryIdInterface,
    Doctrine\ODM\PHPCR\DocumentRepository;

class ArticleRepository extends DocumentRepository implements RepositoryIdInterface
{
    public function generateId($document, $parent = null)
    {
        $path = $document->getPath();
        if ('' == $path) {
            return $this->appendRootNodePath($document->getTitle());
        }

        return $path;
    }

    public function appendRootNodePath($name)
    {
        if (0 === strpos($name, '/')) {
            return $name;
        }

        return '/'.$name;
    }

    public function find($id)
    {
        return parent::find($this->appendRootNodePath($id));
    }

    public function create()
    {
        return new Article();
    }
}
