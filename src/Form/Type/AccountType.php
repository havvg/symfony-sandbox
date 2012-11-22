<?php

namespace Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;

class AccountType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', 'email', array(
                'label' => 'label.account.email',
                'constraints' => array(
                    new NotBlank(),
                    new Email(),
                ),
                'autocomplete' => false,
            ))
            ->add('password', 'repeated', array(
                'type' => 'password',
                'first_options' => array(
                    'label' => 'label.account.password',
                    'autocomplete' => false,
                ),
                'second_options' => array(
                    'label' => 'label.account.password_repeat',
                    'autocomplete' => false,
                ),
                'constraints' => array(
                    new NotBlank(),
                    new Length(array(
                        'min' => 3,
                    )),
                ),
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Form\Model\Account',
        ));
    }

    public function getName()
    {
        return 'account';
    }
}
