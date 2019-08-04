<?php

namespace AppBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname',TextType::class,[
                "label"=>"First Name:",
                "attr"=>[
                    "class"=>"form-control form-control-sm",
                    "placeholder"=>"First Name",
                    "autofocus"=>true
                ]
            ])
            ->add('lastname',TextType::class,[
                "label"=>"Last Name:",
                "attr"=>[
                    "class"=>"form-control form-control-sm",
                    "placeholder"=>"Last Name"
                ]
            ])
            ->add('username',TextType::class,[
                "label"=>"User Name:",
                "attr"=>[
                    "class"=>"form-control form-control-sm",
                    "placeholder"=>"User Name"
                ]
            ])
            ->add('email',EmailType::class,[
                "label"=>"Email:",
                "attr"=>[
                    "class"=>"form-control form-control-sm",
                    "placeholder"=>"Email"
                ]
            ])
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options'  => [
                    'label' => 'Password',
                    "attr"=>[
                        "class"=>"form-control form-control-sm",
                        "placeholder"=>"Password"
                    ]
                ],
                'second_options' => [
                    'label' => 'Repeat Password:',
                    "attr"=>[
                        "class"=>"form-control form-control-sm",
                        "placeholder"=>"Repeat Password"
                    ]
                ],
            ))
            ->add('status',ChoiceType::class,[
                "label"=>"Status:",
                "attr"=>[
                    "class"=>"custom-select custom-select-sm status_select",
                    "required"=>true,
                    "multiple"=>false
                ],
                'choices'  => [
                    'Active' => 'Active',
                    'Inactive' => 'Inactive'
                ],
            ]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_users';
    }


}
