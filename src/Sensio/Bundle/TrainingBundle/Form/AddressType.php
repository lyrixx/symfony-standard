<?php

namespace Sensio\Bundle\TrainingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('street')
            ->add('zipcode')
            ->add('city')
            ->add('country', 'country')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sensio\Bundle\TrainingBundle\Entity\Address',
            'attr' => array('class' => 'address'),
        ));
    }

    public function getName()
    {
        return 'address';
    }
}
