<?php

namespace Site\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DirectorType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', array(
                'required' => true,
                'label' => 'backend.director.title'
            ))
            ->add('metaTitle', 'text', array(
                'required' => false,
                'label' => 'backend.director.metatitle'
            ))
            ->add('metaDescription', 'textarea', array(
                'required' => false,
                'label' => 'backend.director.metadescription'
            ))
            ->add('metaKeywords', 'text', array(
                'required' => false,
                'label' => 'backend.director.metakeywords'
            ))
            ->add('description', 'textarea', array(
                'required' => false,
                'label' => 'backend.director.description'
            ))
            ->add('text', 'textarea', array(
                'required' => false,
                'label' => 'backend.director.text',
                "attr" => array(
                    "class" => "ckeditor"
                )
            ))
            ->add('file', 'file', array(
                'required' => false,
                'label' => 'backend.director.img'
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Site\MainBundle\Entity\Director',
            'translation_domain' => 'menu'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'site_mainbundle_director';
    }
}
