<?php

namespace Client\Bundle\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MainController extends Controller
{
    public function dashboardAction(Request $request)
    {
        return $this->render('ClientAdminBundle:Main:dashboard.html.twig', array(
        ));
    }
}