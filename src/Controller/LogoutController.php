<?php

namespace App\Controller;

use Doctrine\DBAL\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Doctrine\DBAL\Connection;
/**
 * This handler is run on logout.
 * It removes all refresh tokens for the authenticated user. This prevents the usage of old
 * refresh tokens by an attacker. As there is no repository for refresh token we do it the
 * good old way and use the database connection directy.
 */
class LogoutController extends AbstractController
{
    private $token;
    private $user;
    private $isLogged;
    private $connection;
    public function __construct(TokenStorageInterface $tokenStorage,Connection $connection) {
        try{
            $this->connection=$connection;
            $this->token = $tokenStorage->getToken();
            $this->isLogged=$this->token->isAuthenticated();
            $this->user = $this->token->getUser();
        }catch (\Exception $exception){
            $this->token=null;
            $this->user=null;
            $this->isLogged=false;
            $this->user = null;
        }

    }

    /**
     * @Route("/api/logout", name="logout",methods={"POST"})
     * @throws Exception
     */
    public function index(): Response
    {

        if($this->isLogged==true){
            if($this->user=="anon."){
                return new Response("user not logged successfully",200);
            }else{
                /* @noinspection PhpUnhandledExceptionInspection */
                $stm=$this->connection->prepare("DELETE from refresh_tokens where username= :user_email");
                $stm->bindValue('user_email',$this->token->getUsername());
                $res = $stm->execute();
                return new Response("token:".$this->token->getUsername()."\n statut".$res,200);
            }
        }
        return new Response("user not logged successfully",200);
    }
}
