<?php

use Cocur\Slugify\Bridge\Symfony\CocurSlugifyBundle;
use FOS\UserBundle\FOSUserBundle;
use Ivory\CKEditorBundle\IvoryCKEditorBundle;
use KarolineKroiss\ArtGalleryBundle\KarolineKroissArtGalleryBundle;
use KarolineKroiss\ExhibitionBundle\KarolineKroissExhibitionBundle;
use KarolineKroiss\GalleryBundle\KarolineKroissGalleryBundle;
use KarolineKroiss\WebPageBundle\KarolineKroissWebPageBundle;
use Knp\Bundle\MarkdownBundle\KnpMarkdownBundle;
use Knp\Bundle\MenuBundle\KnpMenuBundle;
use Sonata\AdminBundle\SonataAdminBundle;
use Sonata\BlockBundle\SonataBlockBundle;
use Sonata\CoreBundle\SonataCoreBundle;
use Sonata\DoctrineORMAdminBundle\SonataDoctrineORMAdminBundle;
use Sonata\FormatterBundle\SonataFormatterBundle;
use Sonata\jQueryBundle\SonatajQueryBundle;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{

    /**
     * @param string $environment
     * @param bool $debug
     */
    public function __construct($environment, $debug)
    {
        date_default_timezone_set( 'Europe/Paris' );
        parent::__construct($environment, $debug);
    }

    /**
     * @return array
     */
    public function registerBundles()
    {
        $bundles = [
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),

            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),

            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),

            new KnpMenuBundle(),
            new KnpMarkdownBundle(),

            new KarolineKroissArtGalleryBundle(),
            new KarolineKroissGalleryBundle(),
            new KarolineKroissWebPageBundle(),
            new KarolineKroissExhibitionBundle(),

            new SonataCoreBundle(),
            new SonataAdminBundle(),
            new SonataBlockBundle(),
            new SonataFormatterBundle(),
            new SonatajQueryBundle(),
            new SonataDoctrineORMAdminBundle(),

            new IvoryCKEditorBundle(),
            new FOSUserBundle(),
        ];

        if (in_array($this->getEnvironment(), ['dev', 'test'], true)) {
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

    public function getRootDir()
    {
        return __DIR__;
    }

    public function getCacheDir()
    {
        return dirname(__DIR__).'/var/cache/'.$this->getEnvironment();
    }

    public function getLogDir()
    {
        return dirname(__DIR__).'/var/logs';
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getRootDir().'/config/config_'.$this->getEnvironment().'.yml');
    }
}
