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
        $image = $this->getSubject();
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
                    'label' => 'Bild Typ'
                ])
                ->add('title', 'text', [
                    'label' => 'Titel'
                ])
                ->add('file', 'file', [
                    'label' => 'Bild',
                    'required' => false,
                    'data_class' => null
                ])
                ->add('technic', 'text', [
                    'label' => 'Technik',
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
            ->end()
        ;
    }

    //Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('gallery.name', null, ['label' => 'Galerie'])
            ->add('galleryImageTheme.name', null, ['label' => 'Bild Typ'])
            ->add('title', null, ['label' => 'Titel'])
            ->add('technic', null, ['label' => 'Technik'])
            ->add('size', null, ['label' => 'Größe (B x H x T)'])
            ->add('year', null, ['label' => 'Datum', 'choices' => $this->getYearChoices()])
            ->add('saatchiLink', null, ['label' => 'Saatchi-Link'])
            ->add('pinterestLink', null, ['label' => 'Pinterest-Link'])
        ;
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
//        echo '<pre>' . PHP_EOL . var_dump($showMapper->getAdmin()->getSubject()) . PHP_EOL . 'Line: ' . __LINE__ . PHP_EOL . 'File: ' . __FILE__ . die();
    }

    //Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->add('gallery.name', null, ['label' => 'Galerie'])
            ->add('galleryImageTheme.name', null, ['label' => 'Bild Typ'])
            ->add('title', null, ['label' => 'Titel'])
            ->add('technic', null, ['label' => 'Technik'])
            ->add('size', null, ['label' => 'Größe (B x H x T)'])
            ->add('year', null, ['label' => 'Datum', 'choices' => $this->getYearChoices()])
            ->add('saatchiLink', null, ['label' => 'Saatchi-Link'])
            ->add('pinterestLink', null, ['label' => 'Pinterest-Link'])
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
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
