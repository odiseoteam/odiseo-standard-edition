<?php

namespace Odiseo\Bundle\AppBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;

class NewsTranslationFormType extends AbstractResourceType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('text', 'ckeditor', array(
                'label' => 'Texto'
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'odiseo_news_translation';
    }
}