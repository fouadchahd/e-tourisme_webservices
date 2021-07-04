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
            $pictureUrl=null;
            if($currentUser->getProfilePicture()!=null){
                $pictureUrl= $currentUser->getProfilePicture()->getUrl();
            }
            $data['data'] = array(
                'id'             => $currentUser->getId(),
                'email'          => $currentUser->getEmail(),
                'password'       => $currentUser->getPassword(),
                'pseudo'         => $currentUser->getPseudo(),
                'firstName'      => $currentUser->getFirstName(),
                'lastName'       => $currentUser->getLastName(),
                'roles'          => $currentUser->getRoles(),
                'gender'         => $currentUser->getGender(),
                'bio'            => $currentUser->getBio(),
                'nationality'    => $currentUser->getNationality(),
                'profilePicture' => $pictureUrl,
            );
        }

        $event->setData($data);
    }
}