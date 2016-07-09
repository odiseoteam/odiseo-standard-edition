<?php

use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

class AppKernel extends BaseKernel
{
    public function registerBundles()
    {
        $bundles = [
            // Symfony Bundles
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),

            new \Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new \Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle(),
            new \Doctrine\Bundle\DoctrineCacheBundle\DoctrineCacheBundle(),

            // Extra Bundles
            new RaulFraile\Bundle\LadybugBundle\RaulFraileLadybugBundle(),
            new FOS\UserBundle\FOSUserBundle(),
            new FOS\RestBundle\FOSRestBundle(),
            new Knp\Bundle\MenuBundle\KnpMenuBundle(),
            new WhiteOctober\PagerfantaBundle\WhiteOctoberPagerfantaBundle(),
            new Lunetics\LocaleBundle\LuneticsLocaleBundle(),
            new A2lix\TranslationFormBundle\A2lixTranslationFormBundle(),
            new Knp\Bundle\GaufretteBundle\KnpGaufretteBundle(),
            new Vich\UploaderBundle\VichUploaderBundle(),
            new Liip\ImagineBundle\LiipImagineBundle(),
            new JMS\SerializerBundle\JMSSerializerBundle($this),
            new FOS\JsRoutingBundle\FOSJsRoutingBundle(),
            new Ivory\CKEditorBundle\IvoryCKEditorBundle(),
            new Sylius\Bundle\ResourceBundle\SyliusResourceBundle(),
            new JavierEguiluz\Bundle\EasyAdminBundle\EasyAdminBundle(),

            // Odiseo Bundles
            new Odiseo\Bundle\ProjectBundle\OdiseoProjectBundle(),
            new Odiseo\Bundle\BackendBundle\OdiseoBackendBundle(),
            new Odiseo\Bundle\AppBundle\OdiseoAppBundle(),
        ];

        if (in_array($this->getEnvironment(), ['dev', 'test'], true)) {
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getRootDir().'/config/config_'.$this->getEnvironment().'.yml');
    }
}