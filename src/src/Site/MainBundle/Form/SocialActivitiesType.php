<?php

namespace Site\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SocialActivitiesType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('videoFile', 'file', array(
                'required' => false,
                'label' => 'backend.social_activities.video'
            ))
            ->add('file', 'file', array(
                'required' => false,
                'label' => 'backend.social_activities.img'
            ))
            ->add('main', 'choice', array(
                'required' => true,
                'label' => 'backend.social_activities.main',
                'choices' => array(
                    0 => 'backend.social_activities.main_no',
                    1 => 'backend.social_activities.main_yes'
                ),
                'translation_domain' => 'menu'
            ))
            ->add('text', 'textarea', array(
                'required' => false,
                'label' => 'backend.social_activities.text',
                "attr" => array(
                    "class" => "ckeditor"
                )
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Site\MainBundle\Entity\SocialActivities',
            'translation_domain' => 'menu'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'site_mainbundle_social_activities';
    }
}
