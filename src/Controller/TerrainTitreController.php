<?php

namespace App\Controller;

use App\Entity\Contenance;
use App\Entity\ProprietaireTerrainTitre;
use App\Entity\TerrainTitre;
use App\Form\ContenanceType;
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
    #[Route('admin/terrain/titre/show/{id?0<\d+>}', name: 'app_admin_show_terrain_titre', requirements: ['id' => '\d+'])]
    public function AffichageTerrainTitre( $id ,TerrainTitre $terrainTitre , ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Contenance::class);
        $contenance = $repository->findBy(['terrainTitre'=> $id]);
        
        return $this->render('terrain_titre/showTerrainTitre.html.twig', [
            "terrainTitre"=> $terrainTitre, 
            'contenances'=> $contenance
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


/////////////////////////////////////////

    
    #[Route('admin/terrain/titre/edit{id?0 }', name: 'app_admin_add_terrain_titre')]
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
                'titre'=> $titre,
                'terrainTitre'=> $terrainTitre,
                'new'=>$new
            ]);

        } 
        
    }

    #[Route('admin/terrain/titre/Contenance/edit/{id?0}', name: 'app_admin_terrain_titre_edit_contenance')]
    public function editContenance(Contenance $contenance=null , ManagerRegistry $doctrine , Request $request): Response
    {
        $idTerrainCible = $request->query->get('idTerrain');

        if( $idTerrainCible){
            $terrainCibleRepository = $doctrine->getRepository(TerrainTitre::class);
            $terrainCible = $terrainCibleRepository->findOneBy(['id'=>$idTerrainCible]);
        }else{
            return $this->redirectToRoute('app_admin_terrain_titre_edit_contenance');
        }
         
        $new = false;

        if (!$contenance){
            $new = true;
            $contenance = new Contenance();
        }
         
        if ($new){
            
            $titre = "Ajouter une contenance";
        }else{
            $titre = "Modifier une contenance";
        }
        


        $form = $this->createForm(ContenanceType::class , $contenance);
        $form->handleRequest($request);
        

        if($form->isSubmitted() && $form->isValid()){

            $cinProprietaire = $request->request->get('cin_proprietaire'); 
            $nTitre = $request->request->get('n_titre'); 
            $terrain = $doctrine->getRepository(TerrainTitre::class)->findOneBy(['n_titre'=>$nTitre ]);
            if($terrain){
                $idTerrain = $terrain->getId();
                $proprietaire = $terrain->getProprietaireTerrainTitre();
                if($proprietaire->getCin() == $cinProprietaire){
                    $manager = $doctrine->getManager();
                    $contenance->setTerrainTitre($terrain);
                    $manager->persist($contenance);
                    $routeAfterAddContenance = $this->generateUrl("app_admin_show_terrain_titre", ['id' => $idTerrain]);
                    // dd($routeAfterAddContenance);
                    $manager->flush();
                    if ($new){
                        
                        $message = "Contenance ajoutée avec success";
                    }else{
                        
                        $message = "Mis à jour effectuée avec success";
                    }
                    
                    
                    $this->addFlash('success' , "".$message);
                    // return $this->redirectToRoute($routeAfterAddContenance);
                    return $this->redirect($routeAfterAddContenance);
                }else{
                    $this->addFlash('danger' , "Le terrain n'existe pas");
                    return $this->redirectToRoute('app_admin_terrain_titre_edit_contenance');
                }
            }else{
                $this->addFlash('danger' , "Le terrain n'existe pas");
                return $this->redirectToRoute('app_admin_terrain_titre_edit_contenance');
            }
            
        }
        return $this->render('terrain_titre/addContenance.html.twig', [ 
            'form'=>$form->createView(),
            'titre'=>$titre ,
            'terrainCible'=>$terrainCible
        ]);
    }

    
    //////////////////////
    #[Route('admin/terrain/titre/confirmationDeleteContenanceTerrainTitre/{id}', name: 'app_admin_confirmation_delete_contenance_terrain_titre')]
    public function deleteContenanceTerrainTitreConfirmation(Contenance $contenance = null, $id, ManagerRegistry $doctrine): Response
    {
        if (!$contenance) {
            $this->addFlash("danger", "La contenace que vous voulez supprimer n'existe pas");
            return $this->redirectToRoute("app_admin_terrain_titre");
        }

        // Si l'utilisateur confirme la suppression, le lien de confirmation doit pointer vers la page de suppression
        $deleteConfirmationLink = $this->generateUrl('app_admin_delete_contenance_terrain_titre', ['id' => $id]);
        $idTerrain = $contenance->getTerrainTitre()->getId();
        $urlCancel = $this->generateUrl('app_admin_show_terrain_titre', ['id' => $idTerrain]);

        return $this->render('terrain_titre/deleteConfirmationPageContenance.html.twig', [
            'contenance' => $contenance,
            'deleteConfirmationLink' => $deleteConfirmationLink,
            "urlCancel" => $urlCancel
        ]);
    }

    #[Route('admin/terrain/titre/deleteContenance/{id}', name: 'app_admin_delete_contenance_terrain_titre')]
    public function deleteContenanceTerrainTitre(Contenance $contenance = null, $id, ManagerRegistry $doctrine): Response
    {
       
        if (!$contenance) {
            $this->addFlash("danger", "La contenance que vous voulez supprimer n'existe pas");
            return $this->redirectToRoute("app_admin_terrain_titre");
        }

        $idTerrain = $contenance->getTerrainTitre()->getId();
        $urlAfterDelete = $this->generateUrl('app_admin_show_terrain_titre', ['id' => $idTerrain]);



        // Supprimez effectivement le terrain
        $entityManager = $doctrine->getManager();
        $entityManager->remove($contenance);
        $entityManager->flush();

        $this->addFlash("success", "Contenance supprimée avec succès");
        return $this->redirect($urlAfterDelete);
    }
    
}
