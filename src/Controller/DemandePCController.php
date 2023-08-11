<?php

namespace App\Controller;

use App\Entity\DemandeEnvoye;
use App\Form\DemandePCType;
use App\Services\UploaderFile;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DemandePCController extends AbstractController
{
    #[Route('/demande/p/c', name: 'app_demande_p_c' )]
    public function envoyerDemandePC(HttpFoundationRequest $request , UploaderFile $file , ManagerRegistry $doctrine): Response
    {
        $demandePC = new DemandeEnvoye();
        
        $form = $this->createForm(DemandePCType::class, $demandePC);
        $form->handleRequest($request);





        if($form->isSubmitted() && $form->isValid()){

            $manager = $doctrine->getManager();
            ////////////////////
            $nomDemandePcFile = $form->get('nomDemandePc')->getData();
            if ($nomDemandePcFile) {
                 $directory = $this->getParameter('demande_du_permis_de_construire');
 
                $demandePC->setNomDemandePc($file->uploadFile($nomDemandePcFile , $directory));
            }
//////////////////////////////////
            $nomDemandeAlignementFile = $form->get('nomDemandeAlignement')->getData();
            if ($nomDemandeAlignementFile) {
                 $directory = $this->getParameter('demande_d_alignement');
 
                $demandePC->setNomDemandeAlignement($file->uploadFile($nomDemandeAlignementFile , $directory));

            }
            $nomAutreDossierFile = $form->get('nomAutreDossier')->getData();
            if ($nomAutreDossierFile) {
                $directory = $this->getParameter('autre_dossier');

                $demandePC->setNomAutreDossier($file->uploadFile($nomAutreDossierFile , $directory));
            }
            $demandePC->setDateEnvoie(new DateTime());
            $userId = $this->getUser();
            $demandePC->setUser($userId);

            $manager->persist($demandePC) ;
            $manager->flush();
            $this->addFlash('success', "Votre demande de permis de construction envoyé");

            
            return $this->render('demande_pc/demander pc.html.twig', [
                'form' => $form->createView()
            ]);
        }else{
            return $this->render('demande_pc/demander pc.html.twig', [
                'form' => $form->createView()
            ]);
        }
    }
}