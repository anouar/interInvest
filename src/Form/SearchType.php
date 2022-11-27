<?php
namespace App\Form;

use App\Entity\CompanyHistory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $search = $builder->getData();
        $builder
            ->add('createdAt', DateTimeType::class, ['label' => 'Date de modification',
                'widget' => 'single_text',
                'format'=> DateTimeType::HTML5_FORMAT,
                'attr' => ['class' => ''],
                'data' => $search ? $search->getCreatedAt() : new \DateTime('now')
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CompanyHistory::class
        ]);
    }
}
