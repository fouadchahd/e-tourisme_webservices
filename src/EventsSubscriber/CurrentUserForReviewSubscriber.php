<?php


namespace App\EventsSubscriber;


use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Review;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Security;

class CurrentUserForReviewSubscriber implements EventSubscriberInterface
{

    private $security;

    public function __construct(Security $security)
    {
        $this->security=$security;
    }

    public function currentUserForReview(ViewEvent $event): void
    {
        $review=$event->getControllerResult();
        $method=$event->getRequest()->getMethod();
        if($review instanceof Review && Request::METHOD_POST===$method ){
            $review->setPublishedBy($this->security->getUser());
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['currentUserForReview',EventPriorities::PRE_VALIDATE]
        ];
    }
}