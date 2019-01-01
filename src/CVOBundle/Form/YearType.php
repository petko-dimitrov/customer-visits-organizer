<?php

namespace CVOBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;


class YearType extends AbstractType
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
            ));
    }
}