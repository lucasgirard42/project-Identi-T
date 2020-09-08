<?php

namespace App\Controller;

use App\Entity\Staff;
use App\Entity\User;
use App\Form\StaffType;
use App\Repository\StaffRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/staff")
 */
class StaffController extends AbstractController
{
    /**
     * @Route("/list", name="staff_index", methods={"GET"})
     */
    public function index(StaffRepository $staffRepository): Response
    {
        return $this->render('staff/index.html.twig', [
            'staff' => $staffRepository->findAll(),
        ]);
    }

     /**
     * 
     */
    private function saveUploadFile(UploadedFile $file, string $directory, SluggerInterface $slugger)
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
               
        $safeFilename = $slugger->slug($originalFilename);
        $newFilename = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();

        try {
            $file->move(
                $directory,
                $newFilename
            );
        } catch (FileException $e) {
            $newFilename = 'error file upload';
        }

        return $newFilename;
    }


    /**
     * @Route("/new", name="staff_new", methods={"GET","POST"})
     */
    public function new(Request $request, SluggerInterface $slugger): Response
    {
        $user = $this->getUser();
        if ($user->getStaff() instanceof Staff){
             $staffId=$user->getStaff()->getId();
            return $this->redirectToRoute('staff_edit',[
                'id'=> $staffId
            ]);
        }


        $staff = new Staff();
        $form = $this->createForm(StaffType::class, $staff);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $staff->setUser($user);

            /** @var UploadedFile $file */
            $file = $form->get('staffPicture')->getData();
            if ($file){
                $newFilename = $this->saveUploadFile(
                    $file, 
                    $this->getParameter('pictures_directory'),
                    $slugger
                );
                $staff->setStaffPicture($newFilename);
            }


            $entityManager->persist($staff);
            $entityManager->flush();

            return $this->redirectToRoute('staff_show_user');
        }

        return $this->render('staff/new.html.twig', [
            'staff' => $staff,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/", name="staff_show_user", methods={"GET"})
     */
   public function showUser(): Response         //faire une fontion show>USer
   {   
       /** @var User $user */
       $user = $this->getUser();

       $staff = $user->getStaff();
       if (!isset($staff))
       {
           return $this->redirectToRoute('staff_new');
       }


       return $this->render('staff/show.html.twig', [
           'staff' => $staff,
       ]);
   }

    /**
     * @Route("/{id}", name="staff_show", methods={"GET"})
     */
    public function show(Staff $staff): Response
    {
        return $this->render('staff/show.html.twig', [
            'staff' => $staff,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="staff_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Staff $staff): Response
    {
        $form = $this->createForm(StaffType::class, $staff);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('staff_index');
        }

        return $this->render('staff/edit.html.twig', [
            'staff' => $staff,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="staff_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Staff $staff): Response
    {
        if ($this->isCsrfTokenValid('delete'.$staff->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($staff);
            $entityManager->flush();
        }

        return $this->redirectToRoute('staff_index');
    }
}
