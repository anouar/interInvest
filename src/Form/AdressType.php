<?php
namespace App\Form;

use App\Entity\Adress;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdressType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('number', NumberType::class, ['label' => 'Numéro', 'attr' => ['class' =>'form-control']])
            ->add('Type', ChoiceType::class, ['choices' => array_flip(Adress::getTypeAdressChoices()), 'required' => true, 'label' => 'Type de voie', 'autocomplete' => true, 'attr' => ['class' => 'form-control']])
            ->add('street', TextType::class, ['label' => 'Adresse', 'attr' => ['class' =>'form-control']])
            ->add('city', TextType::class, ['label' => 'Ville', 'attr' => ['class' =>'form-control']])
            ->add('codePostal', TextType::class, ['label' => 'Code Postal', 'attr' => ['class' =>'form-control']]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Adress::class
        ]);
    }
}
