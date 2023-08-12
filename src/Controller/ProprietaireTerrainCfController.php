<?php

namespace App\Controller;

use App\Entity\ProprietaireTerrainCf;
use App\Entity\TerrainCf;
use App\Form\ProprietaireTerrainCfType;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProprietaireTerrainCfController extends AbstractController
{
    #[Route('admin/proprietaire/terrain/cf', name: 'app_admin_proprietaire_terrain_cf'), 
    IsGranted('ROLE_ADMIN')
    ]
    public function tousLesProprietaireTerrainCf(ManagerRegistry $doctrine): Response
    {

        $repository = $doctrine->getRepository(ProprietaireTerrainCf::class);
        $proprietaireTerrainCf = $repository->findAll();
        return $this->render('proprietaire_terrain_cf/allProprietaireTerrainCf.html.twig', [
            'propietaireTerrainCfs' => $proprietaireTerrainCf
        ]);
    }
    #[Route('admin/proprietaire/terrain/cf/show{id?0}', name: 'app_admin_show_proprietaire_terrain_cf'), 
    IsGranted('ROLE_ADMIN')
    ]
    public function showProprietaireTerrainTitre($id ,ProprietaireTerrainCf $proprietaireTerrainCf=null , ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(TerrainCf::class);
        $SesTerrains = $repository->findBy(['proprietaire'=>$id]);
        return $this->render('proprietaire_terrain_cf/showProprietaireTerrainCf.html.twig', [
            "proprietaireTerrainCf"=>$proprietaireTerrainCf,
            "all_terrain_cfs"=>$SesTerrains
        ]);
    }

    ///////

    #[Route('admin/proprietaire/terrain/cf/edit{id?0}', name: 'app_admin_add_proprietaire_terrain_cf'), 
    IsGranted('ROLE_ADMIN')
    ]
    public function addProprietaireTerrainCf(ProprietaireTerrainCf $proprietaireTerrainCf=null , ManagerRegistry $doctrine , Request $request): Response
    {
        $new = false ; 
        
         if (!$proprietaireTerrainCf){
            $new = true;
            $proprietaireTerrainCf = new ProprietaireTerrainCf();
         }
         if ($new){
            $titre = "Ajouter un nouveau propriétaire  ";
            $message = "Proprietaire ajouté avec success";
        }else{
            $titre = "Modifier propriétaire d'un terrain certificat foncé";
            $message = "Mis à jour effectuée avec success";
        }

         $form = $this->createForm(ProprietaireTerrainCfType::class , $proprietaireTerrainCf);
         $form->handleRequest($request);

         if ($form->isSubmitted() && $form->isValid()){
            $manager = $doctrine->getManager();

            $manager->persist($proprietaireTerrainCf);
            $manager->flush();
            $this->addFlash('success', "".$message);
            return $this->redirectToRoute('app_admin_proprietaire_terrain_cf');
         }

        return $this->render('proprietaire_terrain_cf/addProprietaireTerrainCf.html.twig', [
            'form'=> $form->createView(),
            'titre'=>$titre
        ]);
    }


    #[Route('admin/proprietaire/terrain/cf/confirmationDelete/{id}', name: 'app_admin_confirmation_delete_proprietaire_terrain_cf'), 
    IsGranted('ROLE_ADMIN')
    ]
    public function deleteProprietaireTerrainCfConfirmation(ProprietaireTerrainCf $proprietaireTerrainCf = null, $id, ManagerRegistry $doctrine): Response
    {
        if (!$proprietaireTerrainCf) {
            $this->addFlash("danger", "Le proprietaire que vous voulez supprimer n'existe pas");
            return $this->redirectToRoute("app_admin_proprietaire_terrain_cf");
        }

        // Si l'utilisateur confirme la suppression, le lien de confirmation doit pointer vers la page de suppression
        $deleteConfirmationLink = $this->generateUrl('app_admin_delete_proprietaire_terrain_cf', ['id' => $id]);

        return $this->render('proprietaire_terrain_cf/deleteConfirmationPageProprietaireTerrainCf.html.twig', [
            'proprietaireTerrainCf' => $proprietaireTerrainCf,
            'deleteConfirmationLink' => $deleteConfirmationLink,
        ]);
    }
    #[Route('admin/proprietaire/terrain/cf/delete/{id}', name: 'app_admin_delete_proprietaire_terrain_cf'), 
    IsGranted('ROLE_ADMIN')
    ]
    public function deleteProprietaireTerrainCf(ProprietaireTerrainCf $proprietaireTerrainCf = null, $id, ManagerRegistry $doctrine): Response
    {
        if (!$proprietaireTerrainCf) {
            $this->addFlash("danger", "Le proprietaire que vous voulez supprimer n'existe pas");
            return $this->redirectToRoute("app_admin_proprietaire_terrain_cf");
        }

        // Supprimez effectivement le terrain
        $entityManager = $doctrine->getManager();
        $entityManager->remove($proprietaireTerrainCf);
        $entityManager->flush();

        $this->addFlash("success", "Le proprietaire a été supprimé avec succès");
        return $this->redirectToRoute("app_admin_proprietaire_terrain_cf");
    }
}
