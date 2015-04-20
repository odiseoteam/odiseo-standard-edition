<?php

use Symfony\Component\Config\Loader\LoaderInterface;
use Odiseo\Bundle\ProjectBundle\Kernel\Kernel;

class AppKernel extends Kernel
{
	public function registerBundles()
	{
		$bundles = array(
            new Odiseo\Bundle\BrancaRallyBundle\OdiseoBrancaRallyBundle(),
            new Odiseo\Bundle\BackendBundle\OdiseoBackendBundle(),
			new JavierEguiluz\Bundle\EasyAdminBundle\EasyAdminBundle()
		);
		
		if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }
		
		return array_merge(parent::registerBundles(), $bundles);
	}
}