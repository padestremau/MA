<?php

namespace MA\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProjectEditType extends AbstractType
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
            ->add('deliveryAt', 'datetime', array(
                                            'input'  => 'datetime',
                                            'widget' => 'choice',
                                            'years' => range(2014,2050,1),
                                            'data' => new \Datetime
                                        ))
            ->add('orderList', 'text', array('label' => 'Ordre affiché'))
            ->add('forPerson', 'entity', array(   'class' => 'MAMainBundle:Person',
                                                'property' => 'Name'
                                            ))
            ->add('completedAt', 'datetime', array(
                                            'input'  => 'datetime',
                                            'widget' => 'choice',
                                            'years' => range(2014,2050,1),
                                            'data' => new \Datetime
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
        return 'ma_mainbundle_project_edit';
    }
}
