<?php

namespace Odiseo\Bundle\AppBundle\Twig;

class AppContextExtension extends \Twig_Extension
{
    public function __construct()
    {
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('appContext', array($this, 'getAppContext'), array('needs_environment' => true)),
        );
    }

    public function getAppContext(\Twig_Environment $environment)
    {
       return $this;
    }

    public function getName()
    {
        return 'odiseo_app_context_extension';
    }
}
