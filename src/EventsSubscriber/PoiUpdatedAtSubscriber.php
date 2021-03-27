<?php


namespace App\EventsSubscriber;


use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Poi;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class PoiUpdatedAtSubscriber
{
    /*
    public function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW=>['dateOfUpdate',EventPriorities::PRE_WRITE]
        ];
    }

    public function dateOfUpdate(ViewEvent $event):void
    {
        $poi = $event->getControllerResult();
        $method_called=$event->getRequest()->getMethod();
        if(!$poi instanceof Poi || !in_array($method_called,array(Request::METHOD_POST,Request::METHOD_PUT))){
            return;
        }
        if (Request::METHOD_PUT===$method_called){
            $poi->setUpdatedAt(new \DateTime());
        }
    }*/
}