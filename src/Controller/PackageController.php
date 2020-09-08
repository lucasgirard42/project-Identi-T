<?php

namespace App\Controller;

use App\Entity\Package;
use App\Form\PackageType;
use App\Repository\PackageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/package")
 */
class PackageController extends AbstractController
{
    /**
     * @Route("/", name="package_index", methods={"GET"})
     */
    public function index(PackageRepository $packageRepository): Response
    {
        return $this->render('package/index.html.twig', [
            'packages' => $packageRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="package_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $package = new Package();
        $form = $this->createForm(PackageType::class, $package);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($package);
            $entityManager->flush();

            return $this->redirectToRoute('package_index');
        }

        return $this->render('package/new.html.twig', [
            'package' => $package,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="package_show", methods={"GET"})
     */
    public function show(Package $package): Response
    {
        return $this->render('package/show.html.twig', [
            'package' => $package,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="package_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Package $package): Response
    {
        $form = $this->createForm(PackageType::class, $package);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('package_index');
        }

        return $this->render('package/edit.html.twig', [
            'package' => $package,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="package_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Package $package): Response
    {
        if ($this->isCsrfTokenValid('delete'.$package->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($package);
            $entityManager->flush();
        }

        return $this->redirectToRoute('package_index');
    }
}
