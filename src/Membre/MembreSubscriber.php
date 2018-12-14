<?php

namespace App\Membre;


use App\Entity\Membre;
use App\Entity\Newsletter;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Http\SecurityEvents;

class MembreSubscriber implements EventSubscriberInterface
{

    private $em;

    /**
     * MembreSubscriber constructor.
     * @param $manager
     */
    public function __construct(ObjectManager $manager)
    {
        $this->em = $manager;
    }


    public static function getSubscribedEvents()
    {
        return [
            SecurityEvents::INTERACTIVE_LOGIN => 'onSecurityInteractiveLogin',
            MembreEvents::MEMBRE_CREATED => 'onMembreCreated'
        ];
    }

    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        # Récupération de l'utilisateur
        $membre = $event->getAuthenticationToken()->getUser();

        if($membre instanceof Membre) {
            $membre->setDerniereConnexion();
            $this->em->flush();
        }
    }

    public function onMembreCreated(MembreEvent $membreEvent)
    {
        $newsletter = new Newsletter();
        $newsletter->setEmail($membreEvent->getMembre()->getEmail());
        $this->em->persist($newsletter);
        $this->em->flush();
    }
}