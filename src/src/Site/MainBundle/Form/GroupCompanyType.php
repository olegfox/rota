<?php

namespace Site\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class GroupCompanyType extends AbstractType
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
                'label' => 'backend.group_company.title'
            ))
            ->add('metaTitle', 'text', array(
                'required' => false,
                'label' => 'backend.group_company.metatitle'
            ))
            ->add('metaDescription', 'textarea', array(
                'required' => false,
                'label' => 'backend.group_company.metadescription'
            ))
            ->add('metaKeywords', 'text', array(
                'required' => false,
                'label' => 'backend.group_company.metakeywords'
            ))
            ->add('description', 'textarea', array(
                'required' => false,
                'label' => 'backend.group_company.description'
            ))
            ->add('text', 'textarea', array(
                'required' => false,
                'label' => 'backend.group_company.text',
                "attr" => array(
                    "class" => "ckeditor"
                )
            ))
            ->add('file', 'file', array(
                'required' => false,
                'label' => 'backend.group_company.img'
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Site\MainBundle\Entity\GroupCompany',
            'translation_domain' => 'menu'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'site_mainbundle_group_company';
    }
}
