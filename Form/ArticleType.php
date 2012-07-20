<?php

namespace Liip\HelloBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Generated via:
 *  php app/console simplethings:convert-jms-metadata "Liip\HelloBundle\Document\Article" > vendor/bundles/Liip/HelloBundle/Form/ArticleType.php
 */
class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('format', 'choice', array('choices' => array('html' => 'html', 'json' => 'json', 'xml' => 'xml')))
            ->add('path', 'text')
            ->add('title', 'text')
            ->add('body', 'text')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Liip\HelloBundle\Document\Article'
        ));
    }

    public function getName()
    {
        return 'article';
    }
}

