<?php

namespace KarolineKroiss\GalleryBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class GalleryType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('date')
            ->add('images', 'collection', [
                'type' => new GalleryImageType(),
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'data_class' => null
            ])
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
//            'data_class' => 'KarolineKroiss\GalleryBundle\Entity\Gallery'
            'data_class' => null
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'karolinekroiss_gallerybundle_gallery';
    }
}
