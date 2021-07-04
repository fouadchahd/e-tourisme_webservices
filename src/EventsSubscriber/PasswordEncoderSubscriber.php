<?php

namespace App\EventsSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Tourist;
use Exception;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
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
        $method=$event->getRequest()->getMethod();
        if ($tourist instanceof Tourist){
            var_dump( "hii ".$tourist->getPassword() );
            if($method===Request::METHOD_PATCH ||$method===Request::METHOD_PUT){
                $content= json_decode($event->getRequest()->getContent()) ;
                $var = get_object_vars($content);
                if(array_key_exists("password", $var)){
                    $hashPass=$this->encoder->encodePassword($tourist,$var['password']);
                }else{
                    $hashPass=$tourist->getPassword();
                }
                $tourist->setPassword($hashPass);
            }else{
                if($method===Request::METHOD_GET){}
                else{
                    $hashPass=$this->encoder->encodePassword($tourist,$tourist->getPassword());
                    $tourist->setPassword($hashPass);
                    if ($method===Request::METHOD_POST){
                        try {
                            $tourist->setPseudo(strtolower($tourist->getFirstName()).strtolower($tourist->getLastName()) . random_int(11, 9999));
                        } catch (Exception $e) {
                            $tourist->setPseudo($tourist->getFirstName() . $tourist->getLastName());            }
                    }
                }

            }

        }
    }
}