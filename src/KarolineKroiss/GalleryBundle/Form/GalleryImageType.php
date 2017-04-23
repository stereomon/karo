<?php

namespace KarolineKroiss\GalleryBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class GalleryImageType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', [
                'label' => 'Original Bild'
            ])
            ->add('original', 'file', [
                'label' => 'Original Bild'
            ])
            ->add('thumbnail', 'file', [
                'label' => 'Thumbnail Bild'
            ])
            ->add('technic', 'text', [
                'label' => 'Technik'
            ])
            ->add('size', 'text', [
                'label' => 'Größe (B x H x T)'
            ])
            ->add('year', 'date', [
                'label' => 'Jahr'
            ])
            ->add('link', 'text', [
                'label' => 'Link',
                'required' => false
            ])
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
//            'data_class' => 'KarolineKroiss\GalleryBundle\Entity\GalleryImage'
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
