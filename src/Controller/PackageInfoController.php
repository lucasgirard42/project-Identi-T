<?php

namespace App\Controller;

use App\Entity\PackageInfo;
use App\Form\PackageInfoType;
use App\Repository\PackageInfoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/package/info")
 * @IsGranted("ROLE_ADMIN")
 */
class PackageInfoController extends AbstractController
{
    /**
     * @Route("/list", name="package_info_index", methods={"GET"})
     * @ISGRANTED("ROLE_ADMIN")
     */
    public function index(PackageInfoRepository $packageInfoRepository): Response
    {
        return $this->render('package_info/index.html.twig', [
            'package_infos' => $packageInfoRepository->findAll(),
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
     * @Route("/new", name="package_info_new", methods={"GET","POST"})
     */
    public function new(Request $request, SluggerInterface $slugger): Response
    {
        $packageInfo = new PackageInfo();
        $form = $this->createForm(PackageInfoType::class, $packageInfo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

             /** @var UploadedFile $file */
             $file = $form->get('packagePicture')->getData();
             if ($file){
                 $newFilename = $this->saveUploadFile(
                     $file, 
                     $this->getParameter('pictures_directory'),
                     $slugger
                 );
                 $packageInfo->setPackagePicture($newFilename);
             }

            $entityManager->persist($packageInfo);
            $entityManager->flush();

            return $this->redirectToRoute('package_info_index');
        }

        return $this->render('package_info/new.html.twig', [
            'package_info' => $packageInfo,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="package_info_show", methods={"GET"})
     */
    public function show(PackageInfo $packageInfo): Response
    {
        return $this->render('package_info/show.html.twig', [
            'package_info' => $packageInfo,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="package_info_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, PackageInfo $packageInfo): Response
    {
        $form = $this->createForm(PackageInfoType::class, $packageInfo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('package_info_index');
        }

        return $this->render('package_info/edit.html.twig', [
            'package_info' => $packageInfo,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="package_info_delete", methods={"DELETE"})
     */
    public function delete(Request $request, PackageInfo $packageInfo): Response
    {
        if ($this->isCsrfTokenValid('delete'.$packageInfo->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($packageInfo);
            $entityManager->flush();
        }

        return $this->redirectToRoute('package_info_index');
    }
}
