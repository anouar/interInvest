<?php
namespace App\Form;

use App\Entity\Company;
use App\Entity\LegalStatus;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompanyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $company = $builder->getData();

        $builder
            ->add('name', TextType::class, ['label' => 'Nom de l\'entreprise'])
            ->add('codeSiren', null,['label' => 'SIREN', 'attr' => ['class' => 'siren' , 'maxlength' => '11','data-inputmask' => "'mask':'999 999 999','autoUnmask':true"]])
            ->add('capital', MoneyType::class, ['label' => 'Capital'])
            ->add('legalStatus', EntityType::class, [
                'required' => true,
                'label' => 'Forme Juridique',
                'class' => LegalStatus::class,
                'placeholder' => 'Nature juridique',
                'autocomplete' => true
            ])
            ->add('cityRegistration', TextType::class, ['label' => 'Ville d\'immatriculation'])
            ->add('dateRegistration', DateType::class, [
                'widget' => 'single_text',
                'html5' => false,
                'required'=>true,
                'format' => 'dd/MM/yyyy',
                'label' => 'Date d\'immatriculation',
                'data' => $company ? $company->getDateRegistration() : new \DateTime('now')
            ])
             ->add('adresses', CollectionType::class,
                 [   'entry_type' => AdressType::class,
                     'allow_add' => true,
                     'allow_delete' => true,
                     'entry_options' => ['label' => false],
                     'by_reference' => true,
                     'block_name' => 'adress',
                 ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Company::class
        ]);
    }
}
