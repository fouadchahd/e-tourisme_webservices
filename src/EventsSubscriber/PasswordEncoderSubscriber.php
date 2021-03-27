<?php

namespace App\EventsSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Tourist;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class PasswordEncoderSubscriber implements EventSubscriberInterface
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW=>['encodePassword',EventPriorities::PRE_WRITE]
        ];
    }

    public function encodePassword(ViewEvent $event):void
    {
        $tourist=$event->getControllerResult();
        if ($tourist instanceof Tourist){
            $hashPass=$this->encoder->encodePassword($tourist,$tourist->getPassword());
            $tourist->setPassword($hashPass);
            try {
                $tourist->setPseudo($tourist->getFirstName() . $tourist->getLastName() . random_int(111, 999));
            } catch (\Exception $e) {
                $tourist->setPseudo($tourist->getFirstName() . $tourist->getLastName());            }
        }
    }
}