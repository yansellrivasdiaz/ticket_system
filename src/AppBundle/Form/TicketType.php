<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('subject',TextType::class,[
                "label"=>"Subject:",
                "attr"=>[
                    "class"=>"form-control form-control-sm",
                    "placeholder"=>"Subject",
                    "autofocus"=>true
                ]
            ])
            ->add('description',TextareaType::class,[
                "label"=>"Description:",
                "attr"=>[
                    "class"=>"form-control form-control-sm",
                    "placeholder"=>"Description..."
                ]
            ])
            ->add('employees',null,[
                "label"=>"Employee(s):",
                "attr"=>[
                    "class"=>"custom-select custom-select-sm employees_select",
                    "required"=>true,
                    "multiple"=>true
                ]
            ])
            ->add('status',ChoiceType::class,[
                "label"=>"Status:",
                "attr"=>[
                    "class"=>"custom-select custom-select-sm status_select",
                    "required"=>true,
                    "multiple"=>false
                ],
                'choices'  => [
                    'Open' => 'Open',
                    'Close' => 'Close'
                ],
            ]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\ticket'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_ticket';
    }


}
