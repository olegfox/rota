<?php

namespace Site\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GalleryFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('date', 'filter_date_range', array(
                'required' => true,
                'label' => 'Фильтр по дате',
                'left_date_options' => array(
                    'required' => true,
                    'label' => 'От'
                ),
                'right_date_options' => array(
                    'required' => true,
                    'label' => 'До'
                )
            ))
            ->add('submit-filter', 'submit', array(
                'label' => 'Фильтровать'
            ))
        ;
    }

    public function getName()
    {
        return 'gallery_filter';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection'   => false,
            'validation_groups' => array('filtering') // avoid NotBlank() constraint-related message
        ));
    }
}