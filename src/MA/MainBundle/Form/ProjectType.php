<?php

namespace MA\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProjectType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', array('label' => 'Titre'))
            ->add('description','redactor', array( 
                                            "redactor"=>"admin_project",
                                            'label' => 'Description'
                                            ))
            ->add('totalAmount', 'integer')
            ->add('currentAmount', 'integer')
            ->add('orderList', 'text', array('label' => 'Ordre affiché'))
            ->add('deliveryAt', 'datetime', array(
                                            'input'  => 'datetime',
                                            'widget' => 'choice',
                                            'years' => range(2014,2050,1),
                                            'data' => new \Datetime
                                        ))
            ->add('forPerson', 'entity', array(   'class' => 'MAMainBundle:Person',
                                                'property' => 'Name'
                                            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MA\MainBundle\Entity\Project'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ma_mainbundle_project';
    }
}
