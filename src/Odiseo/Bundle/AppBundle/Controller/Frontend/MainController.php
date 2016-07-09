<?php

namespace Odiseo\Bundle\AppBundle\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class MainController extends Controller
{
    public function indexAction()
    {
        $preference = $this->get('odiseo.repository.preferences')->findAll();
        $preference = $preference[0];

        return $this->render('OdiseoAppBundle:Frontend/Main:index.html.twig',array(
            'preference' => $preference,
        ));
    }

    public function biographyAction()
    {
        $preference = $this->get('odiseo.repository.preferences')->findAll();
        $preference = $preference[0];

        return $this->render('OdiseoAppBundle:Frontend/Main:biography.html.twig',array(
            'preference' => $preference,
        ));
    }

    public function reasonsAction()
    {
        $preference = $this->get('odiseo.repository.preferences')->findAll();
        $preference = $preference[0];
        return $this->render('OdiseoAppBundle:Frontend/Main:reasons.html.twig',array(
            'preference' => $preference,
        ));
    }

    public function freeOscarAction()
    {
        $preference = $this->get('odiseo.repository.preferences')->findAll();
        $preference = $preference[0];

        return $this->render('OdiseoAppBundle:Frontend/Main:free.html.twig',array(
            'preference' => $preference,
        ));
    }

    public function newsAction(Request $request)
    {
        $noticeId = $request->get('id');
        $mainNews = null;
        $preference = $this->get('odiseo.repository.preferences')->findAll();
        
        $preference = $preference[0];
        $allNews = $preference->getNews();
        if ($noticeId){
            $mainNews = $this->get('odiseo.repository.news')->findOneById($noticeId);
        }
        if(!$mainNews && count($allNews)>0)
        {
            $mainNews = $allNews[0];
        }

        return $this->render('OdiseoAppBundle:Frontend/Main:news.html.twig',array(
            'preference' => $preference,
            'allNews' => $allNews,
            'mainNews' => $mainNews
        ));
    }

    public function photoAction()
    {
        $preference = $this->get('odiseo.repository.preferences')->findAll();
        $preference = $preference[0];

        return $this->render('OdiseoAppBundle:Frontend/Main:photo.html.twig',array(
            'preference' => $preference,
        ));
    }

    public function videoAction()
    {
        $preference = $this->get('odiseo.repository.preferences')->findAll();
        $preference = $preference[0];

        return $this->render('OdiseoAppBundle:Frontend/Main:video.html.twig',array(
            'preference' => $preference,
        ));
    }

    public function pagesAction()
    {
        return $this->render('OdiseoAppBundle:Frontend/Main:pages.html.twig');
    }
}
