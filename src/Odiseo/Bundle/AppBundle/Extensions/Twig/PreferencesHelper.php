<?php

namespace Odiseo\Bundle\AppBundle\Extensions\Twig;



use Odiseo\Bundle\AppBundle\Repository\PreferencesRepository;

class PreferencesHelper  extends \Twig_Extension
{
    private $preferencesRepository;
    private $preference;


    public function __construct($preferencesRepository ){
        $this->preferencesRepository = $preferencesRepository;
        $preferences = $this->preferencesRepository->findAll();
        if (count($preferences) > 0 )
            $this->preference = $preferences[0];

    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('layoutPreferences', array($this, 'getLayoutPreferences'), array('needs_environment' => true)),
        );
    }

    public function getLayoutPreferences(\Twig_Environment $environment)
    {
       if ( $this->preference != null ){
        $mainCss = $environment->render('OdiseoAppBundle:Frontend/Css:main.css.twig', array(
            'data' => $this->preference
        ));
       }
        else $mainCss = "";
        return $mainCss;

    }

    public function getName()
    {
        return 'layout_preferences_extension';
    }
}
