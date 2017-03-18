<?php

namespace Site\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BackgroundType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('position', null, array(
                'required' => false,
                'label' => 'backend.background.position',
                'attr' => array(
                    'min' => 0
                )
            ))
            ->add('videoFile', 'file', array(
                'required' => false,
                'label' => 'backend.background.video'
            ))
            ->add('file', 'file', array(
                'required' => false,
                'label' => 'backend.background.img'
            ))
            ->add('main', 'choice', array(
                'required' => true,
                'label' => 'backend.background.main',
                'choices' => array(
                    0 => 'backend.background.main_no',
                    1 => 'backend.background.main_yes'
                ),
                'translation_domain' => 'menu'
            ))
            ->add('text', 'textarea', array(
                'required' => false,
                'label' => 'backend.background.text',
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
            'data_class' => 'Site\MainBundle\Entity\Background',
            'translation_domain' => 'menu'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'site_mainbundle_background';
    }
}
