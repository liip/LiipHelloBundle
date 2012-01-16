<?php

namespace Liip\HelloBundle\Document;

use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCR;

use Liip\VieBundle\FromJsonLdInterface;
use Liip\VieBundle\ToJsonLdInterface;

use JMS\SerializerBundle\Serializer\JsonSerializationVisitor;
use JMS\SerializerBundle\Serializer\VisitorInterface;
use JMS\SerializerBundle\Serializer\Handler\SerializationHandlerInterface;
use JMS\SerializerBundle\Annotation\XmlRoot;

/**
 * @PHPCR\Document(repositoryClass="Liip\HelloBundle\Document\ArticleRepository")
 * @XmlRoot("article")
 */
class Article implements SerializationHandlerInterface, FromJsonLdInterface, ToJsonLdInterface
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

    public function serialize(VisitorInterface $visitor, $data, $type, &$visited)
    {
        if (!$data instanceof Article) {
            return;
        }

        if ($visitor instanceof JsonSerializationVisitor) {
            $visited = true;

            return $visitor->setRoot($this->toJsonLd());
        }
    }

    public function toJsonLd()
    {
        return array(
            '@' => $this->getFullpath(),
            'a' => 'sioc:Post',
            'dcterms:partOf' => $this->getBasePath(),
            'dcterms:title' => $this->getTitle(),
            'sioc:content' => $this->getBody(),
        );
    }

    public function fromJsonLd($data)
    {
        $this->setTitle($data['title']);
        if (strlen($data['body']) > 100) {
            $data['body'] = substr($data['body'], 0, 100).'..';
        }
        $this->setBody($data['body']);
    }
}
