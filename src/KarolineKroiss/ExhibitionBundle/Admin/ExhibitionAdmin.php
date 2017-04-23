<?php

namespace KarolineKroiss\ExhibitionBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class ExhibitionAdmin extends AbstractAdmin
{
    //Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Ausstellung')
                ->add('year', 'date', ['label' => 'Datum'])
                ->add('name', 'text', ['label' => 'Name'])
                ->add('gallery', 'text', ['label' => 'Galerie'])
                ->add('link', 'text', ['label' => 'Link'])
            ->end()
        ;
    }

    //Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('year', null, ['label' => 'Datum'])
            ->add('name', null, ['label' => 'Name'])
            ->add('gallery', null, ['label' => 'Galerie'])
            ->add('link', null, ['label' => 'Link'])
        ;
    }

    //Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->add('year', null, ['label' => 'Datum'])
            ->add('name', null, ['label' => 'Name'])
            ->add('gallery', null, ['label' => 'Galerie'])
            ->add('link', null, ['label' => 'Link'])
        ;
    }
}
