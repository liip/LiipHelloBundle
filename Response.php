<?php

namespace Liip\HelloBundle;

use JMS\Serializer\Annotation as Serializer;

use Doctrine\Common\Collections\ArrayCollection,
    Doctrine\Common\Collections\Collection;

class Response
{
    /**
     * @var Collection
     * @Serializer\XmlList(inline = true, entry = "article")
     */
    protected $articles;

    /**
     * @var int
     * @Serializer\XmlAttribute()
     */
    protected $page;

    public function __construct($articles, $page)
    {
        if (is_array($articles)) {
            $articles = new ArrayCollection($articles);
        } elseif (!$articles instanceof Collection) {
            throw new \RuntimeException('Response requires a Collection or an array');
        }

        $this->articles = $articles;
        $this->page = $page;
    }

    public function getArticles()
    {
        return $this->articles;
    }

    public function getPage()
    {
        return $this->page;
    }
}
