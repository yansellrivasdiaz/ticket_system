<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\User;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUserData implements FixtureInterface, ContainerAwareInterface {
    private  $container;
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('admin');
        $user->setEmail('admin@admin.com');
        $encoder = $this->container->get('security.password_encoder');
        $password = $encoder->encodePassword($user,'admin');
        $user->setPassword($password);
        $user->setFirstname('Administrator');
        $user->setLastname('');
        $user->setStatus('Active');
        $manager->persist($user);
        $manager->flush();
    }

    /**
     * Sets the container.
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}