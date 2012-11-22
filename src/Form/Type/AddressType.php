<?php

namespace Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('street', 'text', array(
                'label' => 'label.address.street',
                'constraints' => array(
                    new NotBlank(),
                ),
                'autocomplete' => 'street-address',
            ))
            ->add('zipcode', 'text', array(
                'label' => 'label.address.zipcode',
                'constraints' => array(
                    new NotBlank(),
                    new Regex(array(
                        'pattern' => '/\d{5}/',
                    ))
                ),
                'attr' => array(
                    'pattern' => '\d{5}',
                ),
                'autocomplete' => 'postal-code',
            ))
            ->add('city', 'text', array(
                'label' => 'label.address.city',
                'constraints' => array(
                    new NotBlank(),
                ),
                'autocomplete' => 'city',
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Form\Model\Address',
        ));
    }

    public function getName()
    {
        return 'address';
    }
}
