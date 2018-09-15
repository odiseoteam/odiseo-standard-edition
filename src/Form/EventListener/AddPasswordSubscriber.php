<?php

namespace App\Form\EventListener;

use App\Entity\AppUser;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class AddPasswordSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return array(FormEvents::PRE_SET_DATA => 'preSetData');
    }

    public function preSetData(FormEvent $event)
    {
        /** @var AppUser $user */
        $user = $event->getData();
        $form = $event->getForm();

        if (null == $user || null === $user->getId()) {
            $form->add('plainPassword', PasswordType::class, [
                'label' => 'Contraseña',
                'attr' => [
                    'placeholder' => 'Contraseña'
                ]
            ]);
        }
    }
}