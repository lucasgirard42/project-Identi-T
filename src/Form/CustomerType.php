<?php

namespace App\Form;

use App\Entity\Customer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;

class CustomerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('gender')
            ->add('firstName')
            ->add('lastName')
            ->add('birthday', BirthdayType::class, [
                'widget' => 'single_text',
                'required' => 'false'
            ])
            ->add('phone')
            ->add('address')
            ->add('costumerPicture', FileType::class, [
                'mapped' => false
            ])
            ->add('fidelityCard')
            // ->add('user')
            ->add('appointments')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Customer::class,
        ]);
    }
}
