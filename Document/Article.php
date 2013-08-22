<?php

namespace Liip\HelloBundle\Document;

use Symfony\Component\Validator\Constraints as Assert;

use JMS\Serializer\Annotation as Serializer;

/**
 * @Serializer\XmlRoot("article")
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
     * @Assert\NotBlank(message = "The path may not be blank.")
     * @Serializer\Groups({"data"})
     * @Serializer\Until("1.x")
     */
    protected $path;

    protected $node;

    /**
     * @Assert\Length(min = 3)
     * @Assert\Length(max = 30)
     * @Serializer\Groups({"data"})
     * @Serializer\Since("2.0")
     */
    protected $title;

    /**
     * @Assert\NotBlank
     * @Serializer\Groups({"data"})
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

    public function getRelativePath()
    {
        return substr($this->path, 1);
    }

    public function getBasepath()
    {
        return 'http://symfony-standard.lo/liip/vie';
    }

    public function getFullpath()
    {
        return $this->getBasePath().$this->getPath();
    }

    public function __toString()
    {
        return $this->title;
    }
}
