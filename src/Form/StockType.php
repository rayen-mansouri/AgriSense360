<?php

namespace App\Form;

use App\Entity\Produit;
use App\Entity\Stock;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class StockType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        if ($options['show_produit']) {
            $builder->add('produit', EntityType::class, [
                'label' => 'Produit',
                'class' => Produit::class,
                'choice_label' => 'nom',
                'placeholder' => 'Sélectionner un produit sans stock...',
                'attr' => ['class' => 'form-control'],
                'required' => true,
                'constraints' => [new NotBlank(['message' => 'Le produit est obligatoire.'])],

                // IMPORTANT : Ne montrer QUE les produits qui n'ont PAS encore de stock
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('p')
                        ->leftJoin('p.stocks', 's')
                        ->where('s.id IS NULL')           // Pas de stock existant
                        ->orderBy('p.nom', 'ASC');
                },
            ]);
        }

        $builder
            ->add('quantiteActuelle', NumberType::class, [
                'label' => 'Quantité actuelle',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Ex : 150.00',
                    'step' => '0.01',
                    'min' => '0.01'
                ],
                'required' => true,
                'constraints' => [
                    new NotBlank(['message' => 'La quantité est obligatoire.']),
                    new Positive(['message' => 'La quantité doit être positive.'])
                ],
            ])
            ->add('seuilAlerte', NumberType::class, [
                'label' => "Seuil d'alerte",
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Ex : 20.00',
                    'step' => '0.01',
                    'min' => '0'
                ],
                'required' => true,
                'constraints' => [
                    new NotBlank(['message' => "Le seuil d'alerte est obligatoire."]),
                    new Positive(['message' => "Le seuil d'alerte doit être positif."])
                ],
            ])
            ->add('uniteMesure', ChoiceType::class, [
                'label' => 'Unité de mesure',
                'choices' => [
                    'Kilogramme (kg)' => 'kg',
                    'Gramme (g)' => 'g',
                    'Tonne (t)' => 't',
                    'Litre (L)' => 'L',
                    'Millilitre (mL)' => 'mL',
                    'Unité (u)' => 'u',
                    'Sac' => 'sac',
                    'Caisse' => 'caisse',
                    'Palette' => 'palette',
                ],
                'placeholder' => "Sélectionner l'unité...",
                'attr' => ['class' => 'form-control'],
                'required' => true,
                'constraints' => [new NotBlank(['message' => "L'unité de mesure est obligatoire."])],
            ])
            ->add('dateReception', DateType::class, [
                'label' => 'Date de réception',
                'required' => false,
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('dateExpiration', DateType::class, [
                'label' => "Date d'expiration",
                'required' => false,
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('emplacement', TextType::class, [
                'label' => 'Emplacement',
                'required' => false,
                'attr' => ['class' => 'form-control', 'placeholder' => 'Ex : Entrepôt A - Rayon 3'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Stock::class,
            'show_produit' => true,
            'constraints' => [
                new Callback([$this, 'validateDates']),
            ],
        ]);
    }

    public function validateDates(Stock $stock, ExecutionContextInterface $context): void
    {
        $dateReception = $stock->getDateReception();
        $dateExpiration = $stock->getDateExpiration();

        if ($dateReception && $dateExpiration && $dateExpiration < $dateReception) {
            $context->buildViolation("La date d'expiration doit être postérieure à la date de réception.")
                ->atPath('dateExpiration')
                ->addViolation();
        }
    }
}