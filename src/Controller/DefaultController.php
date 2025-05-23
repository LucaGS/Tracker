<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function Symfony\Component\DependencyInjection\Loader\Configurator\env;

class DefaultController extends AbstractController
{   

    #[Route('/')]
    public function index(): Response
    {   $content = '<html><body>default:</body></html>';
        return new Response(content: $content);
    }

}
