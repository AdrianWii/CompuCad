<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class RegisterType extends AbstractType {
    
    public function getName(){
        return 'register_form';
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options){
        
        $builder
                ->add('excercise', ChoiceType::class, array(
                    'choices' => array('a'=>'a', 'o'=>'o'),
                    'expanded' => false,
                    'multiple' => false, 
                    'label'=>'Zadanie'))
                ->add('comments', TextareaType::class, array(
                    'label' => 'Komentarz'
                    ))
                ->add('paymentfile', FileType::class, array(
                    'label' => 'Plik z zadaniem'
                    ))
                ->add('rules', CheckboxType::class, array(
                    'label' => 'Akceptacja regulaminu',
                    'mapped' => false,
                    'constraints'=>array(
                        new Assert\NotBlank()
                        )
                    ))
                ->add('save', SubmitType::class, array(
                    'label' => 'Prześlij zadanie'
                    ));
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(['data_class' => 'AppBundle\Entity\Register',
            ]);
    }
}