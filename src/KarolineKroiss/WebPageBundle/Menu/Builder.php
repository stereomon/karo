<?php

namespace KarolineKroiss\WebPageBundle\Menu;

use KarolineKroiss\GalleryBundle\Entity\Gallery;
use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class Builder implements ContainerAwareInterface
{

    use ContainerAwareTrait;

    /**
     * @param FactoryInterface $factory
     * @param array $options
     * @return \Knp\Menu\ItemInterface
     */
    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');
        $menu->setChildrenAttributes(['class' => 'nav nav-tabs', 'role' => 'tablist']);

        $navigationElements = [
            'malerei' => 'Malerei',
            'papierarbeiten' => 'Papierarbeiten',
            'druckgrafiken' => 'Druckgrafiken'
        ];
        foreach ($navigationElements as $galleryType => $linkLabel) {
            $items = $this->getGaleriesByType($galleryType);
            if ($items) {
                $this->addNavigationElement($menu, $items, $linkLabel, $galleryType);
            }
        }

        $menu->addChild('Ausstellungen', [
            'route' => 'karoline_kroiss_exhibition_homepage',
        ]);

        $menu->addChild('Galerien', [
            'route' => 'karoline_kroiss_art_gallery_homepage',
        ]);


        return $menu;
    }

    /**
     * @param $type
     * @return Gallery[]
     */
    private function getGaleriesByType($type)
    {
        $galleryRepository = $this->getGalleryRepository();
        $items = $galleryRepository->getYearsByType($type);

        return $items;
    }

    /**
     * @param $menu
     * @param $items
     * @param $linkLabel
     * @param $galleryType
     * @return array
     */
    protected function addNavigationElement($menu, $items, $linkLabel, $galleryType)
    {
        $firstItem = $items[0];
        $firstItemYear = $firstItem->getYear();
        $menu->addChild($linkLabel, [
            'attributes' => [
                'class' => 'dropdown'
            ],
            'route' => 'karoline_kroiss_gallery_by_year',
            'routeParameters' => ['type' => $galleryType, 'year' => $firstItemYear],
            'childrenAttributes' => ['class' => 'dropdown-menu', 'role' => 'menu'],
            'linkAttributes' => ['class' => 'dropdown-toggle', 'data-toggle' => 'dropdown'],
        ]);

        foreach ($items as $item) {
            $year = $item->getYear();
            $menu[$linkLabel]->addChild($year, [
                'route' => 'karoline_kroiss_gallery_by_year',
                'routeParameters' => ['type' => $galleryType, 'year' => $year]
            ]);
        }
    }

    /**
     * @return \KarolineKroiss\GalleryBundle\Entity\GalleryRepository
     */
    private function getGalleryRepository()
    {
        return $this->container->get('doctrine')->getRepository('KarolineKroissGalleryBundle:Gallery');
    }
}
