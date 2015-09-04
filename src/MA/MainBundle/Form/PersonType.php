<?php

namespace MA\MainBundle\Form;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PersonType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $ages = array('' => '');
        for ($i=1; $i < 100; $i++) { 
            $ages[$i] = $i;
        };
        $builder
            ->add('name', 'text', array('label' => 'Nom'))
            ->add('origin', 'text', array('label' => 'Origine'))
            ->add('age', 'choice', array('label' => 'Age',
                                            'choices' => $ages))
            ->add('description', 'redactor', array( 
                                            "redactor"=>"admin_person",
                                            'label' => 'Description'
                                            ))
            ->add('orderList', 'text', array('label' => 'Ordre affiché'))
            ->add('bgColor', 'text', array('label' => 'Couleur'))
            ->add('file', 'file')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MA\MainBundle\Entity\Person'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ma_mainbundle_person';
    }
}
