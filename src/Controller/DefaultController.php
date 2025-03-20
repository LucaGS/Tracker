<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{   

    #[Route('/')]
    public function index(): Response
    {   $content = '<html><body>default'.$_ENV['env:token'].'</body></html>';
        return new Response('<html><body>default</body></html>');
    }
}
