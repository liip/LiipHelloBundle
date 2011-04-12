<?php

namespace Liip\HelloBundle\Document;

/**
 *
 * @phpcr:Document(repositoryClass="Liip\HelloBundle\Document\ArticleRepository", alias="article")
 * 
 */
class Article
{
    /** @phpcr:Id(strategy="repository") */
    protected $path;

    /** @phpcr:Node */
    protected $node;

    /**
     * @phpcr:String(name="title")
     * @validation:MinLength(3)
     * @validation:MaxLength(30)
     */
    protected $title;

    /**
     * @phpcr:String(name="body")
     * @validation:NotBlank
     */
    protected $body;

    public function setTitle($title)
    {
      $this->title = $title;
    }

    public function getTitle()
    {
      return $this->title;
    }

    public function setBody($body)
    {
      $this->body = $body;
    }

    public function getBody()
    {
      return $this->body;
    }

    public function setPath($path)
    {
      $this->path = $path;
    }

    public function getPath()
    {
      return $this->path;
    }

    public function __toString()
    {
      return $this->title;
    }
}
