<?php

namespace App\Form;

use App\Entity\Rental;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class RentalFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date_start', DateType::class, [
                'widget' => 'single_text',
                'html5' => false,
                'attr' => ['class' => 'js-datepicker'],
                'constraints' => [
                    new Constraints\Callback(function($object, ExecutionContextInterface $context) {
                        $now = new \DateTime();
                        $stop = $object;

                        if ($stop->format('U') - $now->format('U') <= 0) {
                            $context
                                ->buildViolation('Date start must be after today')
                                ->addViolation();
                        }
                    }),
                ],
                ])
            ->add('date_end', DateType::class, [
                'widget' => 'single_text',
                'html5' => false,
                'attr' => ['class' => 'js-datepicker'],
                'constraints' => [
                    new Constraints\Callback(function($object, ExecutionContextInterface $context) {
                        $start = $context->getRoot()->getData()->getDateStart();
                        $stop = $object;

                        if (is_a($start, \DateTime::class) && is_a($stop, \DateTime::class)) {
                            if ($stop->format('U') - $start->format('U') <= 0) {
                                $context
                                    ->buildViolation('Date end must be after date start')
                                    ->addViolation();
                            }
                        }
                    }),
                ],
                ])
            ->add('first_name', null, [
                'label' => 'Your first name',
                ])
            ->add('last_name', null, [
                'label' => 'Your last name',
                ])
            ->add('phone')
            ->add('email', EmailType::class)
            ->add('drivers_license')
            ->add('drivers_license_expiry', DateType::class, [
                'widget' => 'single_text',
                'html5' => false,
                'attr' => ['class' => 'js-datepicker'],
                'constraints' => [
                    new Constraints\Callback(function($object, ExecutionContextInterface $context) {
                        $end = $context->getRoot()->getData()->getDateEnd();
                        $expiry = $object;

                        if (is_a($end, \DateTime::class) && is_a($end, \DateTime::class)) {
                            if ($expiry->format('U') - $end->format('U') <= 0) {
                                $context
                                    ->buildViolation('Driving license must be valid through all booking period')
                                    ->addViolation();
                            }
                        }
                    }),
                ],
            ])
            ->add('submit', SubmitType::class, [
                'attr' => ['class' => 'btn-primary']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Rental::class,
        ]);
    }
}
