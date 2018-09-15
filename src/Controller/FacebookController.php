<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FacebookController extends Controller
{
    /**
     * Link to this controller to start the "connect" process
     */
    public function connect()
    {
        $scopes = ['public_profile', 'email'];

        // will redirect to Facebook!
        return $this->get('oauth2.registry')
            ->getClient('facebook_main') // key used in config.yml
            ->redirect($scopes);
    }

    /**
     * After going to Facebook, you're redirected back here
     * because this is the "redirect_route" you configured
     * in config.yml
     */
    public function connectCheck()
    {
        $client = $this->get('oauth2.registry')
            ->getClient('facebook_main');

        // the exact class depends on which provider you're using
        /** @var \League\OAuth2\Client\Provider\FacebookUser $user */
        $user = $client->fetchUser();

        // do something with all this new power!
        $user->getFirstName();
    }
}
