<?php

namespace App\Article;


use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Workflow\Event\Event;

class ArticleWorkflowSubscriber implements EventSubscriberInterface
{

    private $em;

    public function __construct(ObjectManager $manager)
    {
        $this->em = $manager;
    }

    public static function getSubscribedEvents()
    {
        return [
            'workflow.article_publishing.completed.editor_refused' => 'onRefused'
        ];
    }

    public function onRefused(Event $event)
    {
        # Quand est article est refusé, il est automatiquement supprimé.
        $this->em->remove($event->getSubject());
    }
}