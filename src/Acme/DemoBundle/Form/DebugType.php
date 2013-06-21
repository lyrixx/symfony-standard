<?php

namespace Acme\DemoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class DebugType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('myCheckbox', 'checkbox', array('mapped' => false));
    }

    public function getName()
    {
        return 'debug';
    }
}
