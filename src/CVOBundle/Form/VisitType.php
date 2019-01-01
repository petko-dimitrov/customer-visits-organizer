<?php

namespace CVOBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VisitType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('taxCollected', MoneyType::class)
            ->add('paymentType', ChoiceType::class, array(
                'choices'  => array(
                    'Cash' => 'cash',
                    'Bank' => 'bank'
                ),
                'label' => false,
                'attr' => [
                    'class' => 'form-control',
                    'id' => 'paymentType'
                ]
            ))
            ->add('date', DateType ::class, array(
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'label' => false,
                'attr' => [
                    'class' => 'form-control',
                    'id' => 'date'
                ]
            ))
            ->add('time', TextType::class)
            ->add('isRegular', CheckboxType::class, array(
                'required' => true,
            ))
            ->add('serviceType', TextType::class)
            ->add('moreInfo', TextType::class)
            ->add('users', EntityType::class, array(
                'class' => 'CVOBundle:User',
                'choice_label' => 'fullName',
                'multiple' => true,
                'expanded' => false,
                'label' => false
            ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CVOBundle\Entity\Visit'
        ));
    }
}
