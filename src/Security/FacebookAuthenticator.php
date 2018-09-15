<?php

namespace App\Security;

use App\Entity\AppUser;
use Doctrine\Common\Persistence\ObjectManager;
use KnpU\OAuth2ClientBundle\Security\Authenticator\SocialAuthenticator;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Sylius\Component\User\Model\UserInterface;
use Sylius\Component\User\Model\UserOAuthInterface;
use Sylius\Component\User\Repository\UserRepositoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use KnpU\OAuth2ClientBundle\Client\Provider\FacebookClient;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class FacebookAuthenticator extends SocialAuthenticator
{
    private $clientRegistry;
    private $router;
    private $userRepository;
    private $oauthFactory;
    private $oauthRepository;
    private $userFactory;
    private $userManager;

    public function __construct(
        ClientRegistry $clientRegistry,
        RouterInterface $router,
        FactoryInterface $userFactory,
        UserRepositoryInterface $userRepository,
        FactoryInterface $oauthFactory,
        RepositoryInterface $oauthRepository,
        ObjectManager $userManager
    )
    {
        $this->clientRegistry = $clientRegistry;
        $this->router = $router;
        $this->userFactory = $userFactory;
        $this->userRepository = $userRepository;
        $this->oauthFactory = $oauthFactory;
        $this->oauthRepository = $oauthRepository;
        $this->userManager = $userManager;
    }

    public function supports(Request $request)
    {
        // continue ONLY if the URL matches the check URL
        return $request->getPathInfo() == '/connect/facebook/check';
    }

    public function getCredentials(Request $request)
    {
        // this method is only called if supports() returns true
        return $this->fetchAccessToken($this->getFacebookClient());
    }

    /**
     * @param mixed $credentials
     * @param UserProviderInterface $userProvider
     * @return null|\Symfony\Component\Security\Core\User\UserInterface
     * @throws \Exception
     */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $facebookUser = $this->getFacebookClient()->fetchUserFromToken($credentials)->toArray();

        $oauth = $this->oauthRepository->findOneBy([
            'provider' => 'facebook',
            'identifier' => $facebookUser['id'],
        ]);

        if ($oauth instanceof UserOAuthInterface) {
            return $oauth->getUser();
        }

        if (isset($facebookUser['email']) && null !== $facebookUser['email']) {
            $user = $this->userRepository->findOneByEmail($facebookUser['email']);
            if (null !== $user) {
                return $this->updateUserByOAuthUser($user, $facebookUser);
            }
        }

        $user = $this->createUserByOAuthUser($facebookUser);

        //return $userProvider->loadUserByUsername($user->getUsername());
        return $user;
    }

    /**
     * Ad-hoc creation of user.
     */
    private function createUserByOAuthUser($facebookUser)
    {
        /** @var AppUser $user */
        $user = $this->userFactory->createNew();

        // set default values taken from OAuth sign-in provider account
        if (isset($facebookUser['email']) && null !== $email = $facebookUser['email']) {
            $user->setEmail($email);
        }

        if (null !== $name = $facebookUser['first_name']) {
            $user->setFirstName($name);
        } elseif (null !== $realName = $facebookUser['name']) {
            $user->setFirstName($realName);
        }

        if (null !== $lastName = $facebookUser['last_name']) {
            $user->setLastName($lastName);
        }

        if (!$user->getUsername()) {
            $user->setUsername(isset($facebookUser['email']) && $facebookUser['email'] ?$facebookUser['email']:$facebookUser['id']);
        }

        // set random password to prevent issue with not nullable field & potential security hole
        $user->setPlainPassword(substr(sha1($facebookUser['email']), 0, 10));

        $user->setEnabled(true);

        return $this->updateUserByOAuthUser($user, $facebookUser);
    }

    /**
     * Attach OAuth sign-in provider account to existing user.
     */
    private function updateUserByOAuthUser(UserInterface $user, $facebookUser)
    {
        /** @var UserOAuthInterface $oauth */
        $oauth = $this->oauthFactory->createNew();
        $oauth->setIdentifier($facebookUser['id']);
        $oauth->setProvider('facebook');
     /*   $oauth->setAccessToken($accessToken);
        $oauth->setRefreshToken($accessToken);*/

        $user->addOAuthAccount($oauth);

        $this->userManager->persist($user);
        $this->userManager->flush();

        return $user;
    }

    /**
     * @return FacebookClient
     */
    private function getFacebookClient()
    {
        return $this->clientRegistry
            // "facebook_main" is the key used in config.yml
            ->getClient('facebook_main');
    }

    // ...

    /**
     * Returns a response that directs the user to authenticate.
     *
     * This is called when an anonymous request accesses a resource that
     * requires authentication. The job of this method is to return some
     * response that "helps" the user start into the authentication process.
     *
     * Examples:
     *  A) For a form login, you might redirect to the login page
     *      return new RedirectResponse('/login');
     *  B) For an API token authentication system, you return a 401 response
     *      return new Response('Auth header required', 401);
     *
     * @param Request $request The request that resulted in an AuthenticationException
     * @param AuthenticationException $authException The exception that started the authentication process
     *
     * @return Response
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        // TODO: Implement start() method.
    }

    /**
     * Called when authentication executed, but failed (e.g. wrong username password).
     *
     * This should return the Response sent back to the user, like a
     * RedirectResponse to the login page or a 403 response.
     *
     * If you return null, the request will continue, but the user will
     * not be authenticated. This is probably not what you want to do.
     *
     * @param Request $request
     * @param AuthenticationException $exception
     *
     * @return Response|null
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $url = $this->router->generate('app_login');

        return new RedirectResponse($url);
    }

    /**
     * Called when authentication executed and was successful!
     *
     * This should return the Response sent back to the user, like a
     * RedirectResponse to the last page they visited.
     *
     * If you return null, the current request will continue, and the user
     * will be authenticated. This makes sense, for example, with an API.
     *
     * @param Request $request
     * @param TokenInterface $token
     * @param string $providerKey The provider (i.e. firewall) key
     *
     * @return Response|null
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        return new RedirectResponse($this->router->generate('app_participate'));
    }
}