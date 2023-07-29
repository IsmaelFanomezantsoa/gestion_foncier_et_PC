<?php

namespace App\Controller;

use App\Entity\ProprietaireTerrainTitre;
use App\Entity\TerrainTitre;
use App\Form\TerrainTitreType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use App\Services\UploaderImage;

use function PHPSTORM_META\type;

class TerrainTitreController extends AbstractController
{
    #[Route('admin/terrain/titre', name: 'app_admin_terrain_titre')]
    public function tousLesTerrainTitre(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(TerrainTitre::class);
        $all_terrain_titres = $repository->findAll();
        return $this->render('terrain_titre/tousLesTerrainTitre.html.twig', [
            'all_terrain_titres'=> $all_terrain_titres
        ]);
    }
    #[Route('admin/terrain/titre/show/{id}', name: 'app_admin_show_terrain_titre')]
    public function AffichageTerrainTitre( TerrainTitre $terrainTitre , ManagerRegistry $doctrine): Response
    {
        
        return $this->render('terrain_titre/showTerrainTitre.html.twig', [
            "terrainTitre"=> $terrainTitre
        ]);
    }

    #[Route('admin/terrain/titre/confirmationDelete/{id}', name: 'app_admin_confirmation_delete_terrain_titre')]
    public function deleteTerrainTitreConfirmation(TerrainTitre $terrainTitre = null, $id, ManagerRegistry $doctrine): Response
    {
        if (!$terrainTitre) {
            $this->addFlash("danger", "Terrain que vous voulez supprimer n'existe pas");
            return $this->redirectToRoute("app_admin_terrain_titre");
        }

        // Si l'utilisateur confirme la suppression, le lien de confirmation doit pointer vers la page de suppression
        $deleteConfirmationLink = $this->generateUrl('app_admin_delete_terrain_titre', ['id' => $id]);

        return $this->render('terrain_titre/deleteConfirmationPage.html.twig', [
            'terrainTitre' => $terrainTitre,
            'deleteConfirmationLink' => $deleteConfirmationLink,
        ]);
    }

    #[Route('admin/terrain/titre/delete/{id}', name: 'app_admin_delete_terrain_titre')]
    public function deleteTerrainTitre(TerrainTitre $terrainTitre = null, $id, ManagerRegistry $doctrine): Response
    {
        if (!$terrainTitre) {
            $this->addFlash("danger", "Terrain que vous voulez supprimer n'existe pas");
            return $this->redirectToRoute("app_admin_terrain_titre");
        }

        // Supprimez effectivement le terrain
        $entityManager = $doctrine->getManager();
        $entityManager->remove($terrainTitre);
        $entityManager->flush();

        $this->addFlash("success", "Terrain supprimé avec succès");
        return $this->redirectToRoute("app_admin_terrain_titre");
    }


/////////////////////////////////////////

    
    #[Route('admin/terrain/titre/edit{id?0}', name: 'app_admin_add_terrain_titre')]
    public function addTerrainTitre(TerrainTitre $terrainTitre=null , ManagerRegistry $doctrine ,Request $request , UploaderImage  $uploaderImage): Response
    {
        $new = false;
        if(!$terrainTitre){
            $new = true;
            $terrainTitre = new TerrainTitre();
        }
        if ($new){
            $titre = "Ajouter un terrain titré";
        }else{
            $titre = "Modifier un terrain titré";
        }
        
        $form = $this->createForm(TerrainTitreType::class , $terrainTitre);
        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $cinProprietaire = $request->request->get('cin_proprietaire'); 
            $proprietaire = $doctrine->getRepository(ProprietaireTerrainTitre::class)->findOneBy(['cin'=>$cinProprietaire]);
            $manager = $doctrine->getManager();
            
            $image = $form->get('image')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($image) {
                 $directory = $this->getParameter('image_du_plan_terrain_titre');

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $terrainTitre->setImage($uploaderImage->uploadImage($image , $directory));
            }
            
            
            if($proprietaire){
                // $idProprietaire = $proprietaire->getId();
                $terrainTitre->setProprietaireTerrainTitre($proprietaire);
                $manager->persist($terrainTitre);
                $manager->flush();
                if ($new){
                    $titre = "Ajouter un terrain titré";
                    $message = "Terrain Titré ajouté avec success";
                }else{
                    $titre = "Modifier un terrain titré";
                    $message = "Mis à jour effectuée avec success";
                }
                $this->addFlash("success","".$message);
                return $this->redirectToRoute("app_admin_terrain_titre");

            }else{ 
                $this->addFlash("danger","Le CIN du proprietaire n'existe pas");
                return $this->redirectToRoute("app_admin_add_terrain_titre");
            }

            
        }else{
            return $this->render('terrain_titre/addTerrainTitre.html.twig', [
                'form' => $form->createView(), 
                'titre'=> $titre
            ]);

        } 
        
    }
    
}
