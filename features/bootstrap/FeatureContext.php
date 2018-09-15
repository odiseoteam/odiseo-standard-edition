<?php

use Behat\Behat\Context\Context;
use Behat\MinkExtension\Context\MinkContext;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends MinkContext implements Context
{
    private $users = array();

    /** @var \Symfony\Component\DependencyInjection\Container */
    private static $container;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    /**
     * @BeforeSuite
     */
    public static function bootstrapSymfony()
    {
        require_once __DIR__.'/../../vendor/autoload.php';
        require_once __DIR__.'/../../src/Kernel.php';
        (new \Symfony\Component\Dotenv\Dotenv())->load(__DIR__.'/../../.env');
        $kernel = new \App\Kernel('test', true);
        $kernel->boot();
        self::$container = $kernel->getContainer();
    }

    /**
     * @Given /^there are following users:$/
     * @throws Exception
     */
    public function thereAreFollowingUsers(\Behat\Gherkin\Node\TableNode $table)
    {
        foreach ($table->getHash() as $row) {
            $this->users[$row['username']] = $row;
        }

        /** @var \Doctrine\ORM\EntityManagerInterface $em */
        $em = self::$container->get('doctrine')->getEntityManager();
        /** @var \App\Repository\AppUserRepository $userRepository */
        $userRepository = self::$container->get('sylius.repository.app_user');

        foreach ($this->users as $userData) {
            $user = $userRepository->findOneBy([
                'email' => $userData['username']
            ]);

            if (!$user) {
                $user = new \App\Entity\AppUser();
                $user->setEmail($userData['username']);
                $user->setPlainPassword($userData['password']);
                $user->setEnabled(true);
                $user->setFirstName('Test');
                $user->setLastName('Testing');

                $em->persist($user);
                $em->flush();
            }
        }
    }

    /**
     * @Given /^I am authenticated as "([^"]*)"$/
     */
    public function iAmAuthenticatedAs($username) {
        if (!isset($this->users[$username]['password'])) {
            throw new \OutOfBoundsException('Invalid user '. $username);
        }

        $this->visit('/login');
        $this->fillField('_username', $username);
        $this->fillField('_password', $this->users[$username]['password']);
        $this->pressButton('Ingresar');
    }

    /**
     * @Then /^I should see the "([^"]*)" email on homepage$/
     */
    public function iShouldSeeTheEmailOnHomepage($email)
    {
        $this->visit('/');

        $this->assertElementContainsText('h1', $email);
    }
}
