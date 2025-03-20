<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{   

    #[Route('/')]
    public function index(): Response
    {   $content = '<html><body>default: '.$_ENV['token'].'</body></html>';
        return new Response(content: $content);
    }

}
