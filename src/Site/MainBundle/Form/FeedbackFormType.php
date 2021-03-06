<?php

namespace Site\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FeedbackFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                    'required' => true,
                    'label' => false,
                    'attr' => array(
                        'placeholder' => "Имя"
                    )
                )
            )
            ->add('company', 'text', array(
                    'required' => true,
                    'label' => false,
                    'attr' => array(
                        'placeholder' => "Компания"
                    )
                )
            )
            ->add('phone', 'text', array(
                    'required' => true,
                    'label' => false,
                    'attr' => array(
                        'placeholder' => "Телефон"
                    )
                )
            )
            ->add('email', 'email', array(
                    'required' => true,
                    'label' => false,
                    'attr' => array(
                        'placeholder' => "Электронная почта"
                    )
                )
            )
            ->add('message', 'text', array(
                    'required' => true,
                    'label' => false,
                    'attr' => array(
                        'placeholder' => "Сообщение"
                    )
                )
            )
            ->add('save', 'submit', array('label' => 'ОТПРАВИТЬ'));
    }

    public function getDefaultOptions(array $options)
    {
        $options = parent::getDefaultOptions($options);
        $options['csrf_protection'] = false;

        return $options;
    }

    public function getName()
    {
        return '';
    }
}
