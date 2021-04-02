<?php


namespace App\EventsSubscriber;


use ApiPlatform\Core\EventListener\EventPriorities;
use App\Authorization\UserAuthorizationChecker;
use App\Entity\Tourist;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class BeforeUserInfoUpdateSubscriber implements EventSubscriberInterface
{
    private $methodAllowed=[Request::METHOD_POST,Request::METHOD_GET];
    private $userAuthorizationChecker;

    public function __construct(UserAuthorizationChecker $userAuthorizationChecker)
    {
        $this->userAuthorizationChecker=$userAuthorizationChecker;
    }

    public function check(ViewEvent $event)
    {
        $user=$event->getControllerResult();
        $method=$event->getRequest()->getMethod();
        if($user instanceof Tourist && !in_array($method,$this->methodAllowed,true)){
            $this->userAuthorizationChecker->check($user,$method);
            #update the updatedAt date here
        }

    }

    public static function getSubscribedEvents()
    {
        return[
          KernelEvents::VIEW=>['check',EventPriorities::PRE_VALIDATE]
        ];
    }
}