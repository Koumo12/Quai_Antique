<?php

namespace App\Controller;

use App\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class ApiController extends AbstractController
{
    private $jwtManager;

    public function __construct(JWTTokenManagerInterface $jwtManager, private Security $security)
    {
        $this->jwtManager = $jwtManager;
    }

    
    #[Route(path:'/login/api/login_check', name: 'login_check')]
    public function test() : Response
    {
        $user = $this->security->getUser();
        if(null ===$user)
        {
            return $this->json(['message' => 'Vous n´êtez pas connecté.'], Response::HTTP_UNAUTHORIZED);
        }

        $token = $this->jwtManager->create($user);

        // Retourner le jeton dans une réponse JSON
        return $this->json([
            'user' => $user->getUserIdentifier(),
            'token' => $token,
        ]);
    }

}
