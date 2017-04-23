<?php

namespace KarolineKroiss\WebPageBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CmsPageType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('content', 'sonata_formatter_type', [
                'event_dispatcher' => $builder->getEventDispatcher(),
                'format_field'   => 'contentFormatter',
                'source_field'   => 'rawContent',
                'source_field_options' => [
                    'attr' => ['class' => 'span10', 'rows' => 20]
                ],
                'listener'       => true,
                'target_field'   => 'content'
            ])
            ->add('date', 'date', [
                'label' => 'Jahr'
            ])
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
//            'data_class' => 'KarolineKroiss\WebPageBundle\Entity\CmsPage'
            'data_class' => null
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'karolinekroiss_webpage_bundle_cms_page';
    }
}
