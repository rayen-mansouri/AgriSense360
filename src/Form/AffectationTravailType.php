<?php

namespace App\Form;

use App\Entity\AffectationTravail;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Choice;

class AffectationTravailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('typeTravail', TextType::class, [
                'label' => 'Type de travail',
                'attr' => ['placeholder' => 'Ex: Récolte, Labour, Plantage'],
                'constraints' => [
                    new NotBlank(['message' => 'Le type de travail est obligatoire']),
                    new Length([
                        'min' => 2,
                        'max' => 100,
                        'minMessage' => 'Minimum 2 caractères',
                        'maxMessage' => 'Maximum 100 caractères'
                    ]),
                ],
            ])
            ->add('dateDebut', DateType::class, [
                'label' => 'Date de début',
                'widget' => 'single_text',
                'required' => true,
                'attr' => ['class' => 'form-control'],
            ])
            ->add('dateFin', DateType::class, [
                'label' => 'Date de fin',
                'widget' => 'single_text',
                'required' => true,
                'attr' => ['class' => 'form-control'],
            ])
            ->add('zoneTravail', TextType::class, [
                'label' => 'Zone de travail',
                'required' => true,
                'attr' => ['placeholder' => 'Ex: Champ Nord, Verger Est'],
                'constraints' => [
                    new NotBlank(['message' => 'La zone de travail est obligatoire']),
                    new Length([
                        'max' => 100,
                        'maxMessage' => 'Maximum 100 caractères'
                    ]),
                ],
            ])
            ->add('statut', ChoiceType::class, [
                'label' => 'Statut',
                'required' => true,
                'choices' => [
                    'En attente' => 'En attente',
                    'En cours' => 'En cours',
                    'Complété' => 'Complété',
                    'Suspendu' => 'Suspendu',
                    'Annulé' => 'Annulé',
                ],
                'placeholder' => 'Sélectionner un statut',
                'constraints' => [
                    new NotBlank(['message' => 'Le statut est obligatoire']),
                    new Choice([
                        'choices' => ['En attente', 'En cours', 'Complété', 'Suspendu', 'Annulé'],
                        'message' => 'Statut invalide'
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AffectationTravail::class,
        ]);
    }
}
