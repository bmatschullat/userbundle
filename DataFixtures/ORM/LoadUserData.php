<?php
/**
 * @author Bennet Matschullat, 3mweb <bennet@3mweb.de>
 * @date 05.11.15 - 10:44
 * @github <bmatschullat>
 * @project - user bundle
 */

namespace Dreimweb\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\Id\UuidGenerator;
use Dreimweb\UserBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUserData implements FixtureInterface, ContainerAwareInterface
{

    // - - -
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('developer');
        $user->setPassword($this->encodePassword($user, 'darthpass'));
        $user->setEmail('developer@appname.de');
        $user->setRoles(['ROLE_USER', 'ROLE_DEVELOPER', 'ROLE_ADMIN']);
        $user->setFirstname('Vorname');
        $user->setLastname('Nachname');
        $user->setIsActive(true);

        $manager->persist($user);
        $manager->flush();
    }

    private function encodePassword(User $user, $plainPassword)
    {
        $encoder = $this->container->get('security.encoder_factory')
            ->getEncoder($user);

        return $encoder->encodePassword($plainPassword, $user->getSalt());
    }


    public function getOrder()
    {
        return 1;
    }


}