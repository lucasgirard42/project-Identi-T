<?php

namespace App\Controller;

use App\Entity\Staff;
use App\Repository\StaffRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index(StaffRepository $staffRepository) : Response
    {
        $staffs = $staffRepository->findAll();

        return $this->render('Identi-T.html.twig', [
            'controller_name' => 'HomeController',
            'staffs' => $staffs
        ]);
    }

    
}
