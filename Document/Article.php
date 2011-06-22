<?php

namespace Liip\HelloBundle\Document;

use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCR;
/**
 *
 * @PHPCR\Document(repositoryClass="Liip\HelloBundle\Document\ArticleRepository", alias="article")
 *
 */
class Article
{
    /**
     * Format, just used in the RestController
     * In theory the right way would be to create a proxy class with this property
     * that contains an Article instance, but I wanted to keep things simple
     *
     * @var string
     */
    public $format = 'html';

    /**
     * @PHPCR\Id(strategy="repository")
     * @Assert\NotBlank(message = "The path may not be blank.")
     */
    protected $path;

    /** @PHPCR\Node */
    protected $node;

    /**
     * @PHPCR\String(name="title")
     * @Assert\MinLength(3)
     * @Assert\MaxLength(30)
     */
    protected $title;

    /**
     * @PHPCR\String(name="body")
     * @Assert\NotBlank
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
