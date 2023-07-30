<?php

namespace App\Controller;

use App\Entity\ProprietaireTerrainCf;
use App\Entity\ProprietaireTerrainTitre;
use App\Entity\TerrainTitre;
use App\Form\ProprietaireTerrainTitreType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProprietaireTerrainTitreController extends AbstractController
{
    #[Route('admin/proprietaire/terrain/titre', name: 'app_admin_proprietaire_terrain_titre')]
    public function tousLesProprietaireTerrainTitre(ManagerRegistry $doctrine): Response
    {

        $repository = $doctrine->getRepository(ProprietaireTerrainTitre::class);
        $proprietaireTerrainTitre = $repository->findAll();
        return $this->render('proprietaire_terrain_titre/AllProprietaireTerrainTitre.html.twig', [
            'propietaireTerrainTitres' => $proprietaireTerrainTitre
        ]);
    }
    #[Route('admin/proprietaire/terrain/titre/show{id?0}', name: 'app_admin_show_proprietaire_terrain_titre')]
    public function showProprietaireTerrainTitre($id ,ProprietaireTerrainTitre $proprietaireTerrainTitre=null , ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(TerrainTitre::class);
        $SesTerrains = $repository->findBy(['proprietaireTerrainTitre'=>$id]);
        return $this->render('proprietaire_terrain_titre/showProprietaireTerrainTitre.html.twig', [
            "proprietaireTerrainTitre"=>$proprietaireTerrainTitre,
            "all_terrain_titres"=>$SesTerrains
        ]);
    }

    #[Route('admin/proprietaire/terrain/titre/edit{id?0}', name: 'app_admin_add_proprietaire_terrain_titre')]
    public function addProprietaireTerrainTitre(ProprietaireTerrainTitre $proprietaireTerrainTitre=null , ManagerRegistry $doctrine , Request $request): Response
    {
        $new = false ; 
        
         if (!$proprietaireTerrainTitre){
            $new = true;
            $proprietaireTerrainTitre = new ProprietaireTerrainTitre();
         }
         if ($new){
            $titre = "Ajouter un nouveau propriétaire d'un terrain titré";
            $message = "Proprietaire ajouté avec success";
        }else{
            $titre = "Modifier propriétaire d'un terrain titré";
            $message = "Mis à jour effectuée avec success";
        }

         $form = $this->createForm(ProprietaireTerrainTitreType::class , $proprietaireTerrainTitre);
         $form->handleRequest($request);

         if ($form->isSubmitted() && $form->isValid()){
            $manager = $doctrine->getManager();

            $manager->persist($proprietaireTerrainTitre);
            $manager->flush();
            $this->addFlash('success', "".$message);
            return $this->redirectToRoute('app_admin_proprietaire_terrain_titre');
         }

        return $this->render('proprietaire_terrain_titre/addProprietaireTerrainTitre.html.twig', [
            'form'=> $form->createView(),
            'titre'=>$titre
        ]);
    }

    //////////////


    #[Route('admin/proprietaire/terrain/titre/confirmationDelete/{id}', name: 'app_admin_confirmation_delete_proprietaire_terrain_titre')]
    public function deleteProprietaireTerrainTitreConfirmation(ProprietaireTerrainTitre $proprietaireTerrainTitre = null, $id, ManagerRegistry $doctrine): Response
    {
        if (!$proprietaireTerrainTitre) {
            $this->addFlash("danger", "Le proprietaire que vous voulez supprimer n'existe pas");
            return $this->redirectToRoute("app_admin_proprietaire_terrain_titre");
        }

        // Si l'utilisateur confirme la suppression, le lien de confirmation doit pointer vers la page de suppression
        $deleteConfirmationLink = $this->generateUrl('app_admin_delete_proprietaire_terrain_titre', ['id' => $id]);
        $urlCancel = $this->generateUrl("app_admin_show_proprietaire_terrain_titre" , ['id'=>$id]);
        return $this->render('proprietaire_terrain_titre/deleteConfirmationPageProprietaireTerrainTitre.html.twig', [
            'proprietaireTerrainTitre' => $proprietaireTerrainTitre,
            'deleteConfirmationLink' => $deleteConfirmationLink,
            'urlCancel'=> $urlCancel
        ]);
    }
    #[Route('admin/proprietaire/terrain/titre/delete/{id}', name: 'app_admin_delete_proprietaire_terrain_titre')]
    public function deleteProprietaireTerrainTitre(ProprietaireTerrainTitre $proprietaireTerrainTitre = null, $id, ManagerRegistry $doctrine): Response
    {
        if (!$proprietaireTerrainTitre) {
            $this->addFlash("danger", "Le proprietaire que vous voulez supprimer n'existe pas");
            return $this->redirectToRoute("app_admin_proprietaire_terrain_titre");
        }

        // Supprimez effectivement le terrain
        $entityManager = $doctrine->getManager();
        $entityManager->remove($proprietaireTerrainTitre);
        $entityManager->flush();

        $this->addFlash("success", "Le proprietaire a été supprimé avec succès");
        return $this->redirectToRoute("app_admin_proprietaire_terrain_titre");
    }

    

}
