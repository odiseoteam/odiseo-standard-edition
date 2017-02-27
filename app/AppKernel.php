<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = [

            // Symfony Bundles
            new \Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new \Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new \Symfony\Bundle\TwigBundle\TwigBundle(),
            new \Symfony\Bundle\MonologBundle\MonologBundle(),
            new \Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new \Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new \Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle(),

            // Extra Bundles
            new \FOS\RestBundle\FOSRestBundle(),
//            new \HWI\Bundle\OAuthBundle\HWIOAuthBundle(),
            new \Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),
            new \Bazinga\Bundle\HateoasBundle\BazingaHateoasBundle(),
            new \Knp\Bundle\MenuBundle\KnpMenuBundle(),
            new \WhiteOctober\PagerfantaBundle\WhiteOctoberPagerfantaBundle(),
            new \Lunetics\LocaleBundle\LuneticsLocaleBundle(),
            new \A2lix\TranslationFormBundle\A2lixTranslationFormBundle(),
            new \Knp\Bundle\GaufretteBundle\KnpGaufretteBundle(),
            new \Vich\UploaderBundle\VichUploaderBundle(),
            new \Liip\ImagineBundle\LiipImagineBundle(),
            new \JMS\SerializerBundle\JMSSerializerBundle($this),
            new \FOS\JsRoutingBundle\FOSJsRoutingBundle(),
            new \winzou\Bundle\StateMachineBundle\winzouStateMachineBundle(),
            new \Sylius\Bundle\ResourceBundle\SyliusResourceBundle(),
            new \Sylius\Bundle\GridBundle\SyliusGridBundle(),
            new \Sylius\Bundle\MailerBundle\SyliusMailerBundle(),
            new \Sylius\Bundle\UserBundle\SyliusUserBundle(),

            // For listeners which have to be processed first.
            new \Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),

            // Odiseo Bundles
            new \Odiseo\Bundle\UtilBundle\OdiseoUtilBundle(),
            new \Odiseo\Bundle\UserBundle\OdiseoUserBundle(),
            new \Odiseo\Bundle\AdminBundle\OdiseoAdminBundle(),

            // Client Bundles
            new \Client\Bundle\AdminBundle\ClientAdminBundle(),
            new \Client\Bundle\AppBundle\ClientAppBundle(),
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