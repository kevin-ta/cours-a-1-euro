<?php

namespace Zephyr\CoursBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CourseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('classe', 'entity', array(
                  'class'    => 'ZephyrCoursBundle:Classe',
                  'property' => 'name',
                  'multiple' => false,
                  'expanded' => false))
            ->add('subject', 'entity', array(
                  'class'    => 'ZephyrCoursBundle:Subject',
                  'property' => 'name',
                  'multiple' => false,
                  'expanded' => false))
            ->add('unit', 'entity', array(
                  'class'    => 'ZephyrCoursBundle:Unit',
                  'property' => 'name',
                  'multiple' => false,
                  'expanded' => false))
            ->add('date', 'collot_datetime', array( 'pickerOptions' => array(
            	'format' => 'dd/mm/yyyy hh:ii',
                'weekStart' => 1,
                'startDate' => date('d/m/Y 00:00'), //example
                'endDate' => date('01/07/2016 00:00'), //example
                'daysOfWeekDisabled' => [], //example
                'autoclose' => false,
                'startView' => 'month',
                'minView' => 'hour',
                'maxView' => 'year',
                'todayBtn' => false,
                'todayHighlight' => true,
                'keyboardNavigation' => true,
                'language' => 'fr',
                'forceParse' => false,
                'minuteStep' => 60,
                'pickerReferer ' => 'default', //deprecated
                'pickerPosition' => 'top-right',
                'viewSelect' => 'hour',
                'showMeridian' => false,
                'initialDate' => date('d/m/Y'), //example
                )))
        ;
    }

	public function configureOptions(OptionsResolver $resolver)
	{
	    $resolver->setDefaults(array(
	        'data_class' => 'Zephyr\CoursBundle\Entity\Course',
          'csrf_protection' => false,
	    ));
	}

    public function getName()
    {
        return 'course';
    }
}