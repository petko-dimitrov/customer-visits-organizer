<?php

namespace CVOBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExpenseType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('quantity', NumberType::class)
            ->add('singlePrice', MoneyType::class)
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
            ->add('totalPrice', MoneyType::class);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CVOBundle\Entity\Expense'
        ));
    }
}
