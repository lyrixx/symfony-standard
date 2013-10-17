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
            ->add('agreements', 'checkbox', array(
                'mapped' => false,
                'constraints' => array(
                    new Assert\True(array(
                        'message' => 'You must agree the TOS',
                    )),
                ),
                'label' => 'I agree the TOS',
            ))
            ->add('addresses', 'collection', array(
                'type' => 'address',
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ))

            ->addEventListener(FormEvents::POST_SET_DATA, function(FormEvent $event) {
                $form = $event->getForm();
                if (!$event->getData()->getId()) {
                    $form->add('submit', 'submit', array('label' => 'Add a dude'));

                    return;
                }
                $form->remove('agreements');
                $form->add('submit', 'submit', array('label' => 'Edit the dude'));
            })

            ->addEventListener(FormEvents::PRE_SUBMIT, function(FormEvent $event) {
                $dude = $event->getData();
                if (!isset($dude['addresses'])) {
                    return;
                }
                foreach ($dude['addresses'] as $key => $address) {
                    foreach ($address as $value) {
                        if ($value) {
                            continue 2;
                        }
                    }
                    unset($dude['addresses'][$key]);
                }
                $event->setData($dude);
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
