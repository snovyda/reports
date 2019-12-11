<?php

namespace App\Form;

use App\Validator\Constraints\XSDSchema;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;

class ReportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('file', FileType::class, [
                'label' => 'Выберите файл',
                'constraints' => [
                    new NotBlank(),
                    new File([
                        'mimeTypes' => ['text/xml']
                    ]),
                    new XSDSchema()
                ]
            ])
            ->add('save', SubmitType::class, ['label' => 'Загрузить отчет'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
