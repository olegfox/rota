<?php

namespace Site\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CompanyType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('group', 'entity', array(
                'required' => true,
                'label' => 'backend.company.group',
                'class' => 'SiteMainBundle:GroupCompany'
            ))
            ->add('title', 'text', array(
                'required' => true,
                'label' => 'backend.company.title'
            ))
            ->add('metaTitle', 'text', array(
                'required' => false,
                'label' => 'backend.company.metatitle'
            ))
            ->add('metaDescription', 'textarea', array(
                'required' => false,
                'label' => 'backend.company.metadescription'
            ))
            ->add('metaKeywords', 'text', array(
                'required' => false,
                'label' => 'backend.company.metakeywords'
            ))
            ->add('description', 'textarea', array(
                'required' => false,
                'label' => 'backend.company.description'
            ))
            ->add('text', 'textarea', array(
                'required' => false,
                'label' => 'backend.company.text',
                "attr" => array(
                    "class" => "ckeditor"
                )
            ))
            ->add('file', 'file', array(
                'required' => false,
                'label' => 'backend.company.img'
            ))
            ->add('link', 'text', array(
                'required' => false,
                'label' => 'backend.company.link'
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Site\MainBundle\Entity\Company',
            'translation_domain' => 'menu'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'site_mainbundle_company';
    }
}
