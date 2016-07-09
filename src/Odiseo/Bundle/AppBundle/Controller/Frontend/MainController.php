<?php

namespace Odiseo\Bundle\AppBundle\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class MainController extends Controller
{
    public function indexAction()
    {
        return $this->render('OdiseoAppBundle:Frontend/Main:index.html.twig',array(
        ));
    }
}
