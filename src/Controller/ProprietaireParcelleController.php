<?php

namespace App\Controller;

use App\Entity\Parcelle;
use App\Entity\ProprietaireParcelle;
use App\Form\ProprietaireParcelleType;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProprietaireParcelleController extends AbstractController
{
    #[Route('admin/proprietaire/parcelle', name: 'app_admin_proprietaire_parcelle') , 
        IsGranted('ROLE_ADMIN')
    ]
    public function tousLesProprietaireParcelle(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(ProprietaireParcelle::class);
        $proprietaireParcelle = $repository->findAll();
        return $this->render('proprietaire_parcelle/allProprietaireParcelle.html.twig', [
            'propietaireParcelles' => $proprietaireParcelle
        ]);
    }




    /////////////////
    #[Route('admin/proprietaire/parcelle/confirmationDelete/{id}', name: 'app_admin_confirmation_delete_proprietaire_parcelle'), 
    IsGranted('ROLE_ADMIN')
    ]
    public function deleteProprietaireParcelleConfirmation(ProprietaireParcelle $proprietaireParcelle = null, $id, ManagerRegistry $doctrine): Response
    {
        if (!$proprietaireParcelle) {
            $this->addFlash("danger", "Le proprietaire que vous voulez supprimer n'existe pas");
            return $this->redirectToRoute("app_admin_proprietaire_parcelle");
        }

        // Si l'utilisateur confirme la suppression, le lien de confirmation doit pointer vers la page de suppression
        $deleteConfirmationLink = $this->generateUrl('app_admin_delete_proprietaire_parcelle', ['id' => $id]);
        $urlCancel = $this->generateUrl("app_admin_proprietaire_parcelle" );
        return $this->render('proprietaire_parcelle/deleteConfirmationPageProprietaireParcelle.html.twig', [
            'proprietaireParcelle' => $proprietaireParcelle,
            'deleteConfirmationLink' => $deleteConfirmationLink,
            'urlCancel'=> $urlCancel
        ]);
    }
    #[Route('admin/proprietaire/parcelle/delete/{id}', name: 'app_admin_delete_proprietaire_parcelle'), 
    IsGranted('ROLE_ADMIN')
    ]
    public function deleteProprietaireParcelle(ProprietaireParcelle $proprietaireParcelle = null, $id, ManagerRegistry $doctrine): Response
    {
        if (!$proprietaireParcelle) {
            $this->addFlash("danger", "Le proprietaire que vous voulez supprimer n'existe pas");
            return $this->redirectToRoute("app_admin_proprietaire_parcelle");
        }

        // Supprimez effectivement le terrain
        $entityManager = $doctrine->getManager();
        $entityManager->remove($proprietaireParcelle);
        $entityManager->flush();

        $this->addFlash("success", "Le proprietaire a été supprimé avec succès");
        return $this->redirectToRoute("app_admin_proprietaire_parcelle");
    }


    #[Route('admin/proprietaire/parcelle/show{id?0}', name: 'app_admin_show_proprietaire_parcelle'), 
    IsGranted('ROLE_ADMIN')
    ]
    public function showProprietaireParcelle($id ,ProprietaireParcelle $proprietaireParcelle=null , ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Parcelle::class);
        $SesTerrains = $repository->findBy(['proprietaireParcelle'=>$id]);
        return $this->render('proprietaire_parcelle/showProprietaireParcelle.html.twig', [
            "proprietaireParcelle"=>$proprietaireParcelle,
            "all_terrains"=>$SesTerrains
        ]);
    }
    #[Route('admin/proprietaire/parcelle/edit{id?0}', name: 'app_admin_add_proprietaire_parcelle'), 
    IsGranted('ROLE_ADMIN')
    ]
    public function addProprietaireParcelle(ProprietaireParcelle $proprietaireParcelle=null , ManagerRegistry $doctrine , Request $request): Response
    {
        $new = false ; 
        
         if (!$proprietaireParcelle){
            $new = true;
            $proprietaireParcelle = new ProprietaireParcelle();
         }
         if ($new){
            $titre = "Ajouter un nouveau propriétaire d'une parcelle d'un cadastre";
            $message = "Proprietaire ajouté avec success";
        }else{
            $titre = "Modifier propriétaire d'une parcelle d'un cadastre";
            $message = "Mis à jour effectuée avec success";
        }

         $form = $this->createForm(ProprietaireParcelleType::class , $proprietaireParcelle);
         $form->handleRequest($request);

         if ($form->isSubmitted() && $form->isValid()){
            $manager = $doctrine->getManager();

            $manager->persist($proprietaireParcelle);
            $manager->flush();
            $this->addFlash('success', "".$message);
            return $this->redirectToRoute('app_admin_proprietaire_parcelle');
         }

        return $this->render('proprietaire_parcelle/addProprietaireParcelle.html.twig', [
            'form'=> $form->createView(),
            'titre'=>$titre
        ]);
    }
}
