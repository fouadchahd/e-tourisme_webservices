<?php


namespace App\Authorization;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class UserAuthorizationChecker
{
    private $user;
    private $allowedMethod=[Request::METHOD_PATCH,Request::METHOD_PUT];
    public function __construct(Security $security){
        $this->user=$security->getUser();
    }

    public function check(UserInterface $user,string $method){
            $this->isAuthenticated();
            if($this->checkMethod($user,$method) &&
                $user->getId()!==$this->user->getId() ){
                $error="It's not your resource";
                throw new UnauthorizedHttpException($error,$error);
            }
    }

    public function isAuthenticated():void{
        if($this->user===null){
            $error="You are not authenticated";
            throw new UnauthorizedHttpException($error,$error);
        }
    }

    public function checkMethod(UserInterface $user,string $method):bool
    {
            return in_array("ROLE_ADMIN",$user->getRoles())|| in_array($method,$this->allowedMethod,true);
    }
}