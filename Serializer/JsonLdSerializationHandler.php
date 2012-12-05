<?php

namespace Liip\HelloBundle\Serializer;

use JMS\Serializer\Handler\SubscribingHandlerInterface;
use Liip\HelloBundle\Document\Article;
use JMS\Serializer\GraphNavigator;
use JMS\Serializer\JsonSerializationVisitor;

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