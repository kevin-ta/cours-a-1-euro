<?php

namespace Zephyr\CoursBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class StudentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', null, array(
                'mapped' => false,
            ))
        ;
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Zephyr\CoursBundle\Entity\Student',
            'allow_extra_fields' => true,
            'csrf_protection' => false,
        ));
    }

    public function getName()
    {
        return 'student';
    }
}
