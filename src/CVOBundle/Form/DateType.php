<?php

namespace CVOBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;


class DateType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $currentYear = new \DateTime('now');
        $currentYear = $currentYear->format('Y');

        $builder
            ->add('year', ChoiceType::class, array(
                'choices'  => array(
                    ++$currentYear => $currentYear,
                    --$currentYear => $currentYear,
                    --$currentYear => $currentYear,
                    --$currentYear => $currentYear,
                    --$currentYear => $currentYear,
                ),
                'placeholder' => 'Choose year',
            ))
            ->add('month', ChoiceType::class, array(
                'choices' => array(
                    'January' => 1,
                    'February' => 2,
                    'March' => 3,
                    'April' => 4,
                    'May' => 5,
                    'June' => 6,
                    'July' => 7,
                    'August' => 8,
                    'September' => 9,
                    'October' => 10,
                    'November' => 11,
                    'December' => 12
                ),
                'placeholder' => 'Choose month',
            ));
    }
}