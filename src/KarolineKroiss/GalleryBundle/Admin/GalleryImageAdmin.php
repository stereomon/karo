<?php

namespace KarolineKroiss\GalleryBundle\Admin;

use KarolineKroiss\GalleryBundle\Entity\GalleryImage;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

class GalleryImageAdmin extends AbstractAdmin
{

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Bild')
                ->add('gallery', 'entity', [
                    'class' => 'KarolineKroissGalleryBundle:Gallery',
                    'choice_label' => 'name',
                    'multiple'  => false,
                ])
                ->add('gallery_image_theme', 'entity', [
                    'class' => 'KarolineKroissGalleryBundle:GalleryImageTheme',
                    'choice_label' => 'name',
                    'multiple'  => false,
                    'label' => 'Thema'
                ])
                ->add('title', 'text', [
                    'label' => 'Titel'
                ])
                ->add('file', 'file', [
                    'label' => 'Bild',
                    'required' => false,
                    'data_class' => null
                ])
                ->add('gallery_image_technique', 'entity', [
                    'class' => 'KarolineKroissGalleryBundle:GalleryImageTechnique',
                    'choice_label' => 'technique',
                    'multiple'  => false,
                    'required' => false
                ])
                ->add('size', 'text', [
                    'label' => 'Größe (B x H x T)',
                    'required' => false
                ])
                ->add('year', 'choice', [
                    'label' => 'Datum',
                    'choices' => $this->getYearChoices(),
                    'required' => false
                ])
                ->add('saatchiLink', 'text', [
                    'label' => 'Saatchi-Link',
                    'required' => false
                ])
                ->add('pinterestLink', 'text', [
                    'label' => 'Pinterest-Link',
                    'required' => false
                ])
                ->add('isSold', 'checkbox', [
                    'label' => 'Verkauft',
                    'required' => false,
                ])
                ->add('isActive', 'checkbox', [
                    'label' => 'Aktiv',
                    'required' => false,
                ])
            ->end()
        ;
    }

    /**
     * @param \Sonata\AdminBundle\Datagrid\DatagridMapper $datagridMapper
     *
     * @return void
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('gallery.name', null, ['label' => 'Galerie'])
            ->add('galleryImageTheme.name', null, ['label' => 'Thema'])
            ->add('title', null, ['label' => 'Titel'])
            ->add('galleryImageTechnique.technique', null, ['label' => 'Technik'])
            ->add('size', null, ['label' => 'Größe (B x H x T)'])
            ->add('year', null, ['label' => 'Datum', 'choices' => $this->getYearChoices()])
            ->add('saatchiLink', null, ['label' => 'Saatchi-Link'])
            ->add('pinterestLink', null, ['label' => 'Pinterest-Link'])
            ->add('isSold', null, ['label' => 'Verkauft'])
            ->add('isActive', null, ['label' => 'Aktiv'])
        ;
    }

    /**
     * @param \Sonata\AdminBundle\Show\ShowMapper $showMapper
     *
     * @return void
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
//        echo '<pre>' . PHP_EOL . var_dump($showMapper->getAdmin()->getSubject()) . PHP_EOL . 'Line: ' . __LINE__ . PHP_EOL . 'File: ' . __FILE__ . die();
    }

    /**
     * @param \Sonata\AdminBundle\Datagrid\ListMapper $listMapper
     *
     * @return void
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->add('gallery.name', null, ['label' => 'Galerie'])
            ->add('galleryImageTheme.name', null, ['label' => 'Thema'])
            ->add('title', null, ['label' => 'Titel'])
            ->add('galleryImageTechnique.technique', null, ['label' => 'Technik'])
            ->add('size', null, ['label' => 'Größe (B x H x T)'])
            ->add('year', null, ['label' => 'Datum', 'choices' => $this->getYearChoices()])
            ->add('saatchiLink', null, ['label' => 'Saatchi-Link'])
            ->add('pinterestLink', null, ['label' => 'Pinterest-Link'])
            ->add('isSold', null, ['label' => 'Verkauft'])
            ->add('isActive', null, ['label' => 'Aktiv'])
            ->add('_action', 'actions', [
                'actions' => [
                    'show' => [], //['template' => 'KarolineKroissGalleryBundle:Admin:show_button.html.twig'],
                    'edit' => [],
                    'delete' => [],
                ]
            ])
        ;
    }

    /**
     * @param mixed $image
     * @return mixed|void
     */
    public function prePersist($image)
    {
        $this->manageFileUpload($image);
    }

    /**
     * @param mixed $image
     * @return mixed|void
     */
    public function preUpdate($image)
    {
        $this->manageFileUpload($image);
    }

    /**
     * @param GalleryImage $image
     */
    private function manageFileUpload(GalleryImage $image)
    {
        if ($image->getFile()) {
            $image->refreshUpdated();
        }
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('crop');
        $collection->add('resize');
    }

    /**
     * @return array
     */
    private function getYearChoices()
    {
        $current = date('Y');
        $choices = [];
        $choices[$current] = $current;
        for ($i = 0; $i <= 16; $i++) {
            $choices[$current - $i] = $current - $i;
        }

        return $choices;
    }
}
