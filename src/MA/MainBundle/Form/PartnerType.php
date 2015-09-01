<?php

namespace MA\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PartnerType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array('label' => 'Nom'))
            ->add('website', 'textarea', array('label' => 'Site web'))
            ->add('orderList', 'text', array('label' => 'Ordre affiche'))
            ->add('status', 'choice', array('label' => 'Statut',
                                            'choices' => array( 'Statut' => array(   'active' => 'Actif', 
                                                                                        'toCome' => 'A venir',
                                                                                        'inactive' => 'Inactif'))))
            ->add('file','file')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MA\MainBundle\Entity\Partner'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ma_mainbundle_partner';
    }
}
