<?php


namespace App\EventsSubscriber;

use App\Entity\Tourist;
use Symfony\Component\HttpFoundation\RequestStack;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\Security\Core\User\UserInterface;

#we should add this service to services.yaml  to work
class JWTCreateSubscriber
{

    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @param RequestStack $requestStack
     */
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    /**
     * @param AuthenticationSuccessEvent $event
     */
    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
    {
        $data = $event->getData();
        $currentUser = $event->getUser();

        if (!$currentUser instanceof UserInterface) {
            return;
        }

        if ($currentUser instanceof Tourist) {
            $data['data'] = array(
                'id'        => $currentUser->getId(),
                'email'     => $currentUser->getEmail(),
                'pseudo'    => $currentUser->getPseudo(),
                'gender'    =>$currentUser->getGender(),
                'roles'     => $currentUser->getRoles(),
            );
        }

        $event->setData($data);
    }
}