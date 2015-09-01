<?php

namespace MA\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AideType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('header', 'text', array('label' => 'Phrase'))
            ->add('name', 'text', array('label' => 'Nom'))
            ->add('description', 'textarea', array('label' => 'Description'))
            ->add('orderList', 'text', array('label' => 'Ordre affiché'))
            ->add('status', 'choice', array('label' => 'Statut',
                                            'choices' => array( 'Statut' => array(   'active' => 'Actif', 
                                                                                        'toCome' => 'A venir',
                                                                                        'inactive' => 'Inactif'))))
            ->add('price', 'text', array('label' => 'Prix'))
            ->add('file','file')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MA\MainBundle\Entity\Aide'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ma_mainbundle_aide';
    }
}
