<?php
namespace App\Form;

use App\Entity\Produit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('categorie', ChoiceType::class, [
                'label' => 'Catégorie',
                'choices' => [
                    'Engrais' => 'Engrais',
                    'Semences' => 'Semences',
                    'Pesticides' => 'Pesticides',
                    'Outils & Matériel' => 'Outils & Matériel',
                    'Irrigation' => 'Irrigation',
                    'Alimentation animale' => 'Alimentation animale',
                    'Produits phytosanitaires' => 'Produits phytosanitaires',
                    'Autre' => 'Autre',
                ],
                'placeholder' => 'Sélectionner une catégorie...',
                'attr' => ['class' => 'form-control'],
                'required' => true,
                'constraints' => [new NotBlank(['message' => 'La catégorie est obligatoire.'])],
            ])
            ->add('nom', TextType::class, [
                'label' => 'Nom du produit',
                'attr' => ['class' => 'form-control', 'placeholder' => 'Ex : Engrais NPK 15-15-15'],
                'required' => true,
                'constraints' => [
                    new NotBlank(['message' => 'Le nom du produit est obligatoire.']),
                    new Length([
                        'min' => 3,
                        'minMessage' => 'Le nom du produit doit contenir au moins {{ limit }} caractères.',
                    ])
                ],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'required' => false,
                'attr' => ['class' => 'form-control', 'placeholder' => 'Décrivez le produit en détail...', 'rows' => 4],
            ])
            ->add('prixUnitaire', NumberType::class, [
                'label' => 'Prix unitaire (DT)',
                'attr' => ['class' => 'form-control', 'placeholder' => 'Ex : 125.50', 'step' => '0.01'],
                'required' => true,
                'constraints' => [
                    new NotBlank(['message' => 'Le prix unitaire est obligatoire.']),
                    new Positive(['message' => 'Le prix unitaire doit être un nombre positif.'])
                ],
            ])
            ->add('photoFile', FileType::class, [
                'label' => 'Photo du produit',
                'mapped' => false,
                'required' => false,  // false car en modification ce n'est pas obligatoire
                'constraints' => [
                    new File([
                        'maxSize' => '5M',
                        'mimeTypes' => ['image/jpeg', 'image/png', 'image/webp'],
                        'mimeTypesMessage' => 'Veuillez télécharger une image valide (JPEG, PNG ou WebP).',
                    ]),
                ],
                'attr' => ['class' => 'form-control-file', 'id' => 'photoInput', 'accept' => 'image/*'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}