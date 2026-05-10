<?php

namespace App\Form;

use App\Entity\EvaluationPerformance;
use App\Entity\AffectationTravail;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

class EvaluationPerformanceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('affectationTravail', EntityType::class, [
                'label' => 'Assignation de travail',
                'class' => AffectationTravail::class,
                'choice_label' => function(AffectationTravail $affectation) {
                    return sprintf(
                        '%s (%s - %s)',
                        $affectation->getTypeTravail(),
                        $affectation->getDateDebut()->format('d/m/Y'),
                        $affectation->getDateFin()->format('d/m/Y')
                    );
                },
                'placeholder' => 'Sélectionner une assignation',
                'constraints' => [
                    new NotNull(['message' => 'L\'affectation est obligatoire']),
                ],
            ])
            ->add('note', IntegerType::class, [
                'label' => 'Note (0-20)',
                'attr' => [
                    'placeholder' => 'Ex: 15',
                ],
                'constraints' => [
                    new NotNull(['message' => 'La note est obligatoire']),
                    new Range([
                        'min' => 0,
                        'max' => 20,
                        'notInRangeMessage' => 'La note doit être entre 0 et 20'
                    ]),
                ],
            ])
            ->add('qualite', ChoiceType::class, [
                'label' => 'Qualité du travail',
                'required' => true,
                'choices' => [
                    'Excellent' => 'Excellent',
                    'Très bon' => 'Très bon',
                    'Bon' => 'Bon',
                    'Acceptable' => 'Acceptable',
                    'Insuffisant' => 'Insuffisant',
                ],
                'placeholder' => 'Sélectionner une qualité',
                'constraints' => [
                    new NotBlank(['message' => 'La qualité est obligatoire']),
                    new Choice([
                        'choices' => ['Excellent', 'Très bon', 'Bon', 'Acceptable', 'Insuffisant'],
                        'message' => 'Qualité invalide'
                    ]),
                ],
            ])
            ->add('commentaire', TextareaType::class, [
                'label' => 'Commentaires',
                'required' => true,
                'attr' => [
                    'rows' => 4,
                    'placeholder' => 'Ajouter des commentaires...',
                ],
                'constraints' => [
                    new NotBlank(['message' => 'Le commentaire est obligatoire']),
                    new Length([
                        'max' => 500,
                        'maxMessage' => 'Maximum 500 caractères'
                    ]),
                ],
            ])
            ->add('dateEvaluation', DateType::class, [
                'label' => 'Date d\'évaluation',
                'required' => true,
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control'],
                'constraints' => [
                    new NotBlank(['message' => 'La date d\'évaluation est obligatoire']),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EvaluationPerformance::class,
        ]);
    }
}
