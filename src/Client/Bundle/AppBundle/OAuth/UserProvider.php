<?php

declare(strict_types=1);

namespace Client\Bundle\AppBundle\OAuth;

use Client\Bundle\AppBundle\Entity\AppUserInterface;
use Doctrine\Common\Persistence\ObjectManager;
use HWI\Bundle\OAuthBundle\Connect\AccountConnectorInterface;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\OAuthAwareUserProviderInterface;
use Sylius\Bundle\UserBundle\Provider\UsernameOrEmailProvider as BaseUserProvider;
use Client\Bundle\AppBundle\Entity\AppUserInterface as SyliusUserInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Sylius\Component\User\Canonicalizer\CanonicalizerInterface;
use Sylius\Component\User\Model\UserOAuthInterface;
use Sylius\Component\User\Repository\UserRepositoryInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Loading and ad-hoc creation of a user by an OAuth sign-in provider account.
 */
class UserProvider extends BaseUserProvider implements AccountConnectorInterface, OAuthAwareUserProviderInterface
{
    /**
     * @var FactoryInterface
     */
    private $oauthFactory;

    /**
     * @var RepositoryInterface
     */
    private $oauthRepository;

    /**
     * @var FactoryInterface
     */
    private $userFactory;

    /**
     * @var ObjectManager
     */
    private $userManager;

    /**
     * @param string $supportedUserClass
     * @param FactoryInterface $userFactory
     * @param UserRepositoryInterface $userRepository
     * @param FactoryInterface $oauthFactory
     * @param RepositoryInterface $oauthRepository
     * @param ObjectManager $userManager
     * @param CanonicalizerInterface $canonicalizer
     */
    public function __construct(
        string $supportedUserClass,
        FactoryInterface $userFactory,
        UserRepositoryInterface $userRepository,
        FactoryInterface $oauthFactory,
        RepositoryInterface $oauthRepository,
        ObjectManager $userManager,
        CanonicalizerInterface $canonicalizer
    ) {
        parent::__construct($supportedUserClass, $userRepository, $canonicalizer);

        $this->oauthFactory = $oauthFactory;
        $this->oauthRepository = $oauthRepository;
        $this->userFactory = $userFactory;
        $this->userManager = $userManager;
    }

    /**
     * {@inheritdoc}
     */
    public function loadUserByOAuthUserResponse(UserResponseInterface $response): UserInterface
    {
        $oauth = $this->oauthRepository->findOneBy([
            'provider' => $response->getResourceOwner()->getName(),
            'identifier' => $response->getUsername(),
        ]);

        if ($oauth instanceof UserOAuthInterface) {
            return $oauth->getUser();
        }

        if (null !== $response->getEmail()) {
            $user = $this->userRepository->findOneByEmail($response->getEmail());
            if (null !== $user) {
                return $this->updateUserByOAuthUserResponse($user, $response);
            }
        }

        return $this->createUserByOAuthUserResponse($response);
    }

    /**
     * {@inheritdoc}
     */
    public function connect(UserInterface $user, UserResponseInterface $response): void
    {
        $this->updateUserByOAuthUserResponse($user, $response);
    }

    /**
     * Ad-hoc creation of user.
     *
     * @param UserResponseInterface $response
     *
     * @return SyliusUserInterface
     */
    private function createUserByOAuthUserResponse(UserResponseInterface $response): SyliusUserInterface
    {
        /** @var SyliusUserInterface $user */
        $user = $this->userFactory->createNew();

        // set default values taken from OAuth sign-in provider account
        if (null !== $email = $response->getEmail()) {
            $user->setEmail($email);
        }

        if (null !== $name = $response->getFirstName()) {
            $user->setFirstName($name);
        } elseif (null !== $realName = $response->getRealName()) {
            $user->setFirstName($realName);
        }

        if (null !== $lastName = $response->getLastName()) {
            $user->setLastName($lastName);
        }

        if (!$user->getUsername()) {
            $user->setUsername($response->getEmail() ?: $response->getNickname());
        }

        // set random password to prevent issue with not nullable field & potential security hole
        $user->setPlainPassword(substr(sha1($response->getAccessToken()), 0, 10));

        $user->setEnabled(true);

        return $this->updateUserByOAuthUserResponse($user, $response);
    }

    /**
     * Attach OAuth sign-in provider account to existing user.
     *
     * @param UserInterface $user
     * @param UserResponseInterface $response
     *
     * @return AppUserInterface
     */
    private function updateUserByOAuthUserResponse(UserInterface $user, UserResponseInterface $response): AppUserInterface
    {
        /** @var UserOAuthInterface $oauth */
        $oauth = $this->oauthFactory->createNew();
        $oauth->setIdentifier($response->getUsername());
        $oauth->setProvider($response->getResourceOwner()->getName());
        $oauth->setAccessToken($response->getAccessToken());
        $oauth->setRefreshToken($response->getRefreshToken());

        /** @var $user SyliusUserInterface */
        $user->addOAuthAccount($oauth);

        $this->userManager->persist($user);
        $this->userManager->flush();

        return $user;
    }
}