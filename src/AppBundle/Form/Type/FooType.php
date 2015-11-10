<?php

namespace AppBundle\Form\Type;

use AppBundle\Foo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FooType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('enabled', 'checkbox')
            ->add('name', 'text')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Foo::class,
            'empty_data' => new Foo(),
        ));
    }

    public function getName()
    {
        return 'foo';
    }
}
