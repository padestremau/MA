<?php

namespace MA\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PageType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array('label' => 'Nom'))
            ->add('title', 'text', array('label' => 'Titre', 
                                        'required' => false))
            ->add('content','redactor', array( 
                                            "redactor"=>"admin_page",
                                            'label' => 'Description',
                                            'required' => false
                                            ))
            // ->add('dataBaseName', 'text', array('label' => 'Nom de la base de données'))
            // ->add('type', 'choice', array(
            //     'label' => 'type',
            //     'choices' => array(
            //                         'ltc' => 'Logo, Titre, Contenu',
            //                         'tc' => 'Titre, Contenu',
            //                         'c' => 'Contenu'
            //         )
            //     ))
            ->add('file','file', array('label' => 'File',
                                    'required' => false))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MA\MainBundle\Entity\Page'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ma_mainbundle_page';
    }
}
