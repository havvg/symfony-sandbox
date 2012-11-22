<?php

namespace Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        switch ($options['flowStep']) {
            case 1:
                $builder
                    ->add('address', 'address')
                ;
                break;
            case 2:
                $builder
                    ->add('account', 'account')
                ;
                break;
            case 3:
                $builder
                    ->add('confirmation', 'terms_and_conditions')
                ;
                break;
        }
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Form\Model\Registration',
            'flowStep' => 1,
            'translation_domain' => 'registration',
        ));
    }

    public function getName()
    {
        return 'registration';
    }
}
