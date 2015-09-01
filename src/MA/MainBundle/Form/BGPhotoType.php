<?php

namespace MA\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BGPhotoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('sectionName', 'choice', array('label' => 'Statut',
                                            'choices' => array( 'Section' => array(   'actu' => 'Actualité', 
                                                                                        'ecoliers' => 'Ecoliers',
                                                                                        'etudiants' => 'Etudiants',
                                                                                        'jeunesPro' => 'Jeunes Pro', 
                                                                                        'besoins' => 'Nos besoins',
                                                                                        'association' => "L'association"))))
            ->add('file','file')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MA\MainBundle\Entity\BGPhoto'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ma_mainbundle_bgphoto';
    }
}
