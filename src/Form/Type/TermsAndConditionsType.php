<?php

namespace Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\True;

class TermsAndConditionsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('terms', 'checkbox', array(
                'label' => 'label.terms_and_conditions.terms',
                'constraints' => array(
                    new True(),
                ),
            ))
            ->add('privacy', 'checkbox', array(
                'label' => 'label.terms_and_conditions.privacy',
                'constraints' => array(
                    new True(),
                ),
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Form\Model\TermsAndConditions',
        ));
    }

    public function getName()
    {
        return 'terms_and_conditions';
    }
}
