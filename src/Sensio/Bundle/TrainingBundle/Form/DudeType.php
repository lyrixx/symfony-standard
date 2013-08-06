<?php

namespace Sensio\Bundle\TrainingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints as Assert;

class DudeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text')
            ->add('email', 'email')
            ->add('password', 'repeated', array(
                'type' => 'password',
                'first_options' => array('label' => 'Password'),
                'second_options' => array('label' => 'Confirm your password'),
                'invalid_message' => 'The two password are differents',
            ))
            ->add('country', 'country', array(
                'empty_value' => 'Choose a country',
                'preferred_choices' => array('FR', 'ES', 'IT'),
            ))
            ->add('language', 'language', array(
                'empty_value' => 'Choose a Language',
                'preferred_choices' => array('fr', 'es', 'it'),
            ))
            ->add('submit', 'submit', array(
               'label' => 'Add a dude',
            ))
            ->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event) {
                $dude = $event->getData();
                $form = $event->getForm();
                if ($dude->getId()) {
                    return;
                }
                $form
                    ->add('agreements', 'checkbox', array(
                        'mapped' => false,
                        'constraints' => array(
                            new Assert\True(array(
                                'message' => 'You must agree the TOS',
                            )),
                        ),
                        'label' => 'I agree the TOS',
                    ))
                ;
            })
            ->addEventListener(FormEvents::PRE_SUBMIT, function(FormEvent $event) {
                $newDude = $event->getData();

                if (!$newDude['password']['first'] && !$newDude['password']['second']) {
                    $initialDude = $event->getForm()->getConfig()->getData();
                    $newDude['password']['first'] = $initialDude->getPassword();
                    $newDude['password']['second'] = $initialDude->getPassword();
                    $event->setData($newDude);
                }
            })
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sensio\Bundle\TrainingBundle\Entity\Dude',
            'error_mapping' => array(
                'passwordValid' => 'password',
            ),
        ));
    }

    public function getName()
    {
        return 'dude';
    }
}
