<?php

namespace Liip\HelloBundle\Serializer;

use JMS\SerializerBundle\Serializer\Handler\SubscribingHandlerInterface;
use Liip\HelloBundle\Document\Article;
use JMS\SerializerBundle\Serializer\GraphNavigator;
use JMS\SerializerBundle\Serializer\JsonSerializationVisitor;

class JsonLdSerializationHandler implements SubscribingHandlerInterface
{
    public static function getSubscribingMethods()
    {
        return array(
            array(
                'direction' => GraphNavigator::DIRECTION_SERIALIZATION,
                'format' => 'json',
                'type' => 'Liip\HelloBundle\Document\Article',
                'method' => 'serializeJsonLd',
            ),
        );
    }

    public function serializeJsonLd(JsonSerializationVisitor $visitor, Article $article, array $type)
    {
        $visitor->setRoot(
            array(
                '@' => $article->getFullpath(),
                'a' => 'sioc:Post',
                'dcterms:partOf' => $article->getBasePath(),
                'dcterms:title' => $article->getTitle(),
                'sioc:content' => $article->getBody(),
            )
        );
    }
}