<?php

namespace KarolineKroiss\ExhibitionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ExhibitionType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('year', 'datetime', [
                'label' => 'Jahr'
            ])
            ->add('name', 'text', [
                'label' => 'Name'
            ])
            ->add('gallery', 'text', [
                'label' => 'Gallery'
            ])
            ->add('link', 'text', [
                'label' => 'Link'
            ])
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'KarolineKroiss\ExhibitionBundle\Entity\Exhibition'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'karolinekroiss_exhibitionbundle_exhibition';
    }
}
