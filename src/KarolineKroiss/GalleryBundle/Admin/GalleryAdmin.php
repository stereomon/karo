<?php

namespace KarolineKroiss\GalleryBundle\Admin;

use KarolineKroiss\GalleryBundle\Entity\Gallery;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class GalleryAdmin extends AbstractAdmin
{

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $gallery = $this->getSubject();

        $formMapper
            ->with('Bilder Galerie')
                ->add('name')
                ->add('year', 'choice', [
                    'label' => 'Datum',
                    'choices' => $this->getYearChoices(),
                    'required' => true,
                ])
                ->add('type', 'choice', [
                    'choices' => [
                        'malerei' => 'Malerei', 'papierarbeiten' => 'Papierarbeiten', 'druckgrafiken' => 'Druckgrafiken',
                    ]
                ])
                ->add('isHomePageGallery', 'checkbox', [
                    'label' => 'Zeige diese Galerie auf der Startseite',
                    'required' => false,
                    'disabled' => ($gallery && $this->isHomepageGallery($gallery)) ? : false,
                ])
                ->add('isActive', 'checkbox', [
                    'label' => 'Aktiv',
                    'required' => false,
                    'disabled' => ($gallery && $this->isHomepageGallery($gallery)) ? : false,
                ])
            ->end()
            ->with('Bilder')
                ->add('images', 'sonata_type_collection', [
                    'label' => 'Bilder',
                ], [
                    'edit' => 'inline',
                    'sortable' => 'id'
                ])
            ->end()
        ;
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
    /**
     * @param mixed $gallery
     * @return mixed|void
     */
    public function prePersist($gallery)
    {
        $this->manageFileUpload($gallery);
        $this->updateHomepageGallery($gallery);
    }

    /**
     * @param Gallery $gallery
     * @return mixed|void
     */
    public function preUpdate($gallery)
    {
        $this->manageFileUpload($gallery);
        $this->updateHomepageGallery($gallery);
    }

    /**
     * @param \KarolineKroiss\GalleryBundle\Entity\Gallery $gallery
     *
     * @return void
     */
    private function updateHomepageGallery(Gallery $gallery)
    {
        if ($this->isHomepageGallery($gallery)) {
            $gallery->setIsActive(true);

            $galleryRepository = $this->getGalleryRepository();
            $homePageGallery = $galleryRepository->getHomepageGallery();
            if ($homePageGallery && $homePageGallery->getId() !== $gallery->getId()) {
                $homePageGallery->setIsHomepageGallery(false);
                $galleryRepository->saveGallery($homePageGallery);
            }
        }
    }

    /**
     * @param Gallery $gallery
     *
     * @return bool
     */
    private function isHomepageGallery(Gallery $gallery)
    {
        return $gallery->isHomepageGallery();
    }

    /**
     * @param Gallery $gallery
     */
    private function manageFileUpload(Gallery $gallery)
    {
        foreach ($gallery->getImages() as $image) {
            if ($image->getFile()) {
                $image->refreshUpdated();
            }
        }
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name', null, ['label' => 'Name'])
            ->add('year', null, ['label' => 'Datum'])
            ->add('isHomepageGallery', null, ['label' => 'Auf Startseite'])
            ->add('isActive', null, ['label' => 'Aktiv'])
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->add('name', null, ['label' => 'Name'])
            ->add('year', null, ['label' => 'Datum'])
            ->add('isHomepageGallery', null, ['label' => 'Auf Startseite'])
            ->add('isActive', null, ['label' => 'Aktiv'])
            ->add('_action', 'actions', [
                'actions' => [
                    'edit' => [],
                    'delete' => [],
                ]
            ])
        ;
    }

    /**
     * @return \KarolineKroiss\GalleryBundle\Entity\GalleryRepository
     */
    private function getGalleryRepository()
    {
        return $this->getConfigurationPool()->getContainer()->get('doctrine')->getRepository($this->getClass());
    }

}
