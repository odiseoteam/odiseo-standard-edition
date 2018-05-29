<?php

namespace App\Controller;

use App\Repository\AppUserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller
{

    public function dashboard(Request $request)
    {
        /** @var AppUserRepository $participantRepository */
        $userRepository = $this->get('sylius.repository.app_user');

        $statistics = [];

        //Users statistics
        $users = $userRepository->count([]);
        $statistics['users'] = [
            'totals' => $users,
        ];
        //Winner statistics
        /*$winners = $winnerRepository->count([]);
        $statistics['winners'] = $winners;*/

        /*$twitterParticipants = $participantRepository->searchByPlatform('twitter');
        $facebookParticipants = $participantRepository->searchByPlatform('facebook');
        $commonParticipants = $participantRepository->searchByPlatform('form');

        $statistics['participants'] = [
            'totals' => count($participants),
            'commonRegister' => count($commonParticipants),
            'twitterTotals' => count($twitterParticipants),
            'facebookTotals' => count($facebookParticipants),
        ];
        $diaParticipations = $participationRepository->findBy(['side' => 'dia']);
        $nocheParticipations = $participationRepository->findBy(['side' => 'noche']);
        $twitterParticipations = $participationRepository->searchByPlatform('twitter');
        $facebookParticipations = $participationRepository->searchByPlatform('facebook');
        $commonParticipations = $participationRepository->searchByPlatform('form');*/

        //Participations statistics
        //$participations = $participationRepository->count([]);
        /*$statistics['participations'] = [
            'totals' => $participations,
            'commonRegister' => count($commonParticipations),
            'twitterTotals' => count($twitterParticipations),
            'facebookTotals' => count($facebookParticipations),
            'diaTotals' => count($diaParticipations),
            'nocheTotals' => count($nocheParticipations),
        ];

        //Winner statistics
        $winners = $winnerRepository->count([]);
        $statistics['winners'] = $winners;*/

        return $this->render('Admin/dashboard.html.twig', array(
            'statistics' => $statistics
        ));
    }
}