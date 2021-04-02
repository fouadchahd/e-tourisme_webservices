<?php


namespace App\EventsSubscriber;


use App\Entity\Tourist;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Gesdinet\JWTRefreshTokenBundle\Event\RefreshEvent;

class RefreshSubscriber implements EventSubscriberInterface
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * RefreshSubscriber constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public static function getSubscribedEvents()
    {
        return array(
            'gesdinet.refresh_token' => 'beforeRefresh',
        );
    }

    public function beforeRefresh(RefreshEvent $event)
    {
        $refreshToken = $event->getRefreshToken()->getRefreshToken();
        $currentUser = $event->getPreAuthenticatedToken()->getUser();
        $this->logger->debug(sprintf('User "%s" has refreshed it\'s JWT token with refresh token "%s".', $currentUser->getUsername(), $refreshToken));
    }
}