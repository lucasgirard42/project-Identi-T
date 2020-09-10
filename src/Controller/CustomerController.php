<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Entity\Appointment;
use App\Entity\User;
use App\Form\CustomerType;
use App\Repository\CustomerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Repository\AppointmentRepository;
use App\Repository\StaffRepository;

/**
 * @Route("/customer")
 */
class CustomerController extends AbstractController
{
    /**
     * @Route("/list", name="customer_index", methods={"GET"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function index(CustomerRepository $customerRepository): Response
    {
        return $this->render('customer/index.html.twig', [
            'customers' => $customerRepository->findAll(),
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
     * @Route("/new", name="customer_new", methods={"GET","POST"})
     *  @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function new(Request $request, SluggerInterface $slugger): Response
    {   
        $user = $this->getUser();
        if ($user->getCustomer() instanceof Customer){
             $customerId=$user->getCustomer()->getId();
            return $this->redirectToRoute('customer_edit',[
                'id'=> $customerId
            ]);
        }



        $customer = new Customer();
        $form = $this->createForm(CustomerType::class, $customer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $customer->setUser($user);

            /** @var UploadedFile $file */
            $file = $form->get('costumerPicture')->getData();
            if ($file){
                $newFilename = $this->saveUploadFile(
                    $file, 
                    $this->getParameter('pictures_directory'),
                    $slugger
                );
                $customer->setCostumerPicture($newFilename);
            }

            $entityManager->persist($customer);
            $entityManager->flush();

            return $this->redirectToRoute('customer_show_user');
        }

        return $this->render('customer/new.html.twig', [
            'customer' => $customer,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/", name="customer_show_user", methods={"GET"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
   public function showUser(): Response         //faire une fontion show>USer
   {   
       
       
       

       /** @var User $user */
       $user = $this->getUser();

       $customer = $user->getCustomer();
       if (!isset($customer))
       {
           return $this->redirectToRoute('customer_new');
       }


       return $this->render('customer/show.html.twig', [
           'customer' => $customer,
           'appointments' =>$customer->getAppointments(),
        
       ]);
   }

    /**
     * @Route("/{id}", name="customer_show", methods={"GET"})
     *
     */
    public function show(Customer $customer): Response
    {
        return $this->render('customer/show.html.twig', [
            'customer' => $customer,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="customer_edit", methods={"GET","POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function edit(Request $request, Customer $customer): Response
    {
        $form = $this->createForm(CustomerType::class, $customer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('customer_index');
        }

        return $this->render('customer/edit.html.twig', [
            'customer' => $customer,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="customer_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Customer $customer): Response
    {
        if ($this->isCsrfTokenValid('delete'.$customer->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($customer);
            $entityManager->flush();
        }

        return $this->redirectToRoute('customer_index');
    }
}
