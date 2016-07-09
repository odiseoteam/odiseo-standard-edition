<?php

namespace Odiseo\Bundle\AppBundle\Form\Type;

use Odiseo\Bundle\AppBundle\Form\EventSubscriber\ResourceTranslationsSubscriber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ResourceTranslationsType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $locales = array('en', 'es');
        $localesWithRequirement = [];

        foreach ($locales as $locale) {
            $localesWithRequirement[$locale] = false;
            if ('en' === $locale) {
                $localesWithRequirement[$locale] = true;
                $localesWithRequirement = array_reverse($localesWithRequirement, true);
            }
        }

        $builder->addEventSubscriber(new ResourceTranslationsSubscriber($localesWithRequirement));
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'collection';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'sylius_translations';
    }
}