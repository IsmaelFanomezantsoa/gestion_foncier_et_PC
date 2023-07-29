<?php

namespace App\Controller;

use App\Entity\ProprietaireTerrainCf;
use App\Entity\TerrainCf;
use App\Form\TerrainCfType;
use App\Services\UploaderImage;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TerrainCfController extends AbstractController
{
    #[Route('admin/terrain/cf', name: 'app_admin_terrain_cf')]
    public function tousLesTerraincf(ManagerRegistry  $doctrine): Response
    {
        $repository = $doctrine->getRepository(TerrainCf::class);
        $all_terrain_cf = $repository->findAll();
        return $this->render('terrain_cf/tousLesTerrainCf.html.twig', [
            'all_terrain_cfs'=> $all_terrain_cf
        ]);
    }




    #[Route('admin/terrain/cf/edit{id?0}', name: 'app_admin_add_terrain_cf')]
    public function addTerrainTitre(TerrainCf $terrainCf=null , ManagerRegistry $doctrine ,Request $request , UploaderImage   $uploaderImage): Response
    {
        $new = false;
        if(!$terrainCf){
            $new = true;
            $terrainCf = new TerrainCf();
        }
        if ($new){
            $titre = "Ajouter un terrain certificat foncé";
        }else{
            $titre = "Modifier un terrain certificat foncé";
        }
        
        $form = $this->createForm(TerrainCfType::class , $terrainCf);
        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $cinProprietaire = $request->request->get('cin_proprietaire'); 
            $proprietaire = $doctrine->getRepository(ProprietaireTerrainCf::class)->findOneBy(['cin'=>$cinProprietaire]);
            $manager = $doctrine->getManager();
            
            $image = $form->get('image')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($image) {
                 $directory = $this->getParameter('image_du_plan_terrain_cf');

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $terrainCf->setImage($uploaderImage->uploadImage($image , $directory));
            }
            
            
            if($proprietaire){
                // $idProprietaire = $proprietaire->getId();
                $terrainCf->setProprietaire($proprietaire);
                $manager->persist($terrainCf);
                $manager->flush();
                if ($new){
                    $titre = "Ajouter un terrain certificat titré";
                    $message = "Terrain certificat foncé ajouté avec success";
                }else{
                    $titre = "Modifier un terrain titré";
                    $message = "Mis à jour effectuée avec success";
                }
                $this->addFlash("success","".$message);
                return $this->redirectToRoute("app_admin_terrain_cf");

            }else{ 
                $this->addFlash("danger","Le CIN du proprietaire n'existe pas");
                return $this->redirectToRoute("app_admin_add_terrain_cf");
            }

            
        }else{
            return $this->render('terrain_cf/addTerrainCf.html.twig', [
                'form' => $form->createView(), 
                'titre'=> $titre
            ]);

        } 
        
    }
    
    #[Route('admin/terrain/cf/show/{id}', name: 'app_admin_show_terrain_cf')]
    public function AffichageTerrainCf( TerrainCf $terrainCf , ManagerRegistry $doctrine): Response
    {
        
        return $this->render('terrain_Cf/showTerrainCf.html.twig', [
            "terrainCf"=> $terrainCf
        ]);
    }


    /////////////////


    #[Route('admin/terrain/cf/confirmationDelete/{id}', name: 'app_admin_confirmation_delete_terrain_cf')]
    public function deleteTerrainTitreConfirmation(TerrainCf $terrainCf = null, $id, ManagerRegistry $doctrine): Response
    {
        if (!$terrainCf) {
            $this->addFlash("danger", "Terrain que vous voulez supprimer n'existe pas");
            return $this->redirectToRoute("app_admin_terrain_cf");
        }

        // Si l'utilisateur confirme la suppression, le lien de confirmation doit pointer vers la page de suppression
        $deleteConfirmationLink = $this->generateUrl('app_admin_delete_terrain_cf', ['id' => $id]);

        return $this->render('terrain_cf/deleteConfirmationPage.html.twig', [
            'terrainCf' => $terrainCf,
            'deleteConfirmationLink' => $deleteConfirmationLink,
        ]);
    }

    #[Route('admin/terrain/c/delete/{id}', name: 'app_admin_delete_terrain_cf')]
    public function deleteTerrainTitre(TerrainCf $terrainCf = null, $id, ManagerRegistry $doctrine): Response
    {
        if (!$terrainCf) {
            $this->addFlash("danger", "Terrain que vous voulez supprimer n'existe pas");
            return $this->redirectToRoute("app_admin_terrain_cf");
        }

        // Supprimez effectivement le terrain
        $entityManager = $doctrine->getManager();
        $entityManager->remove($terrainCf);
        $entityManager->flush();

        $this->addFlash("success", "Terrain supprimé avec succès");
        return $this->redirectToRoute("app_admin_terrain_cf");
    }


}
