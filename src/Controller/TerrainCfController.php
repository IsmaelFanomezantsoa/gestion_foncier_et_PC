<?php

namespace App\Controller;

use App\Entity\Contenance;
use App\Entity\ProprietaireTerrainCf;
use App\Entity\TerrainCf;
use App\Form\ContenanceType;
use App\Form\TerrainCfType;
use App\Services\UploaderImage;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TerrainCfController extends AbstractController
{
    #[Route('admin/terrain/cf', name: 'app_admin_terrain_cf'), 
    IsGranted('ROLE_ADMIN')
    ]
    public function tousLesTerraincf(ManagerRegistry  $doctrine): Response
    {
        $repository = $doctrine->getRepository(TerrainCf::class);
        $all_terrain_cf = $repository->findAll();
        return $this->render('terrain_cf/tousLesTerrainCf.html.twig', [
            'all_terrain_cfs'=> $all_terrain_cf
        ]);
    }




    #[Route('admin/terrain/cf/edit{id?0}', name: 'app_admin_add_terrain_cf'), 
    IsGranted('ROLE_ADMIN')
    ]
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
                'titre'=> $titre,
                'terrainCf'=> $terrainCf,
                'new'=>$new
            ]);

        } 
        
    }
    
    #[Route('admin/terrain/cf/show/{id?0<\d+>}', name: 'app_admin_show_terrain_cf', requirements: ['id' => '\d+']), 
    IsGranted('ROLE_ADMIN')
    ]
    public function AffichageTerrainCf( $id ,TerrainCf $terrainCf , ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Contenance::class);
        $contenance = $repository->findBy(['terrainCf'=> $id]);
        
        
        return $this->render('terrain_Cf/showTerrainCf.html.twig', [
            "terrainCf"=> $terrainCf,
            'contenances'=> $contenance
        ]);
    }


    /////////////////


    #[Route('admin/terrain/cf/confirmationDelete/{id}', name: 'app_admin_confirmation_delete_terrain_cf'), 
    IsGranted('ROLE_ADMIN')
    ]
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

    #[Route('admin/terrain/cf/delete/{id}', name: 'app_admin_delete_terrain_cf'), 
    IsGranted('ROLE_ADMIN')
    ]
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

    //////////////

    
    //////////////////////
    #[Route('admin/terrain/cf/confirmationDeleteContenanceTerrainCf/{id}', name: 'app_admin_confirmation_delete_contenance_terrain_cf'), 
    IsGranted('ROLE_ADMIN')
    ]
    public function deleteContenanceTerrainCfConfirmation(Contenance $contenance = null, $id, ManagerRegistry $doctrine): Response
    {
        if (!$contenance) {
            $this->addFlash("danger", "La contenace que vous voulez supprimer n'existe pas");
            return $this->redirectToRoute("app_admin_terrain_cf");
        }

        // Si l'utilisateur confirme la suppression, le lien de confirmation doit pointer vers la page de suppression
        $deleteConfirmationLink = $this->generateUrl('app_admin_delete_contenance_terrain_cf', ['id' => $id]);
        $idTerrain = $contenance->getTerrainCf()->getId();
        $urlCancel = $this->generateUrl('app_admin_show_terrain_cf', ['id' => $idTerrain]);

        return $this->render('terrain_cf/deleteConfirmationPageContenance.html.twig', [
            'contenance' => $contenance,
            'deleteConfirmationLink' => $deleteConfirmationLink,
            "urlCancel" => $urlCancel
        ]);
    }

    #[Route('admin/terrain/cf/deleteContenance/{id}', name: 'app_admin_delete_contenance_terrain_cf'), 
    IsGranted('ROLE_ADMIN')
    ]
    public function deleteContenanceTerrainCf(Contenance $contenance = null, $id, ManagerRegistry $doctrine): Response
    {
       
        if (!$contenance) {
            $this->addFlash("danger", "La contenance que vous voulez supprimer n'existe pas");
            return $this->redirectToRoute("app_admin_terrain_titre");
        }

        $idTerrainCf = $contenance->getTerrainCf()->getId();
        $urlAfterDelete = $this->generateUrl('app_admin_show_terrain_cf', ['id' => $idTerrainCf]);



        // Supprimez effectivement le terrain
        $entityManager = $doctrine->getManager();
        $entityManager->remove($contenance);
        $entityManager->flush();

        $this->addFlash("success", "Contenance supprimée avec succès");
        return $this->redirect($urlAfterDelete);
    }




    ////////////

    #[Route('admin/terrain/cf/Contenance/edit/{id?0}', name: 'app_admin_terrain_cf_edit_contenance'), 
    IsGranted('ROLE_ADMIN')
    ]
    public function editContenance(Contenance $contenance=null , ManagerRegistry $doctrine , Request $request): Response
    {

        $idTerrainCible = $request->query->get('idTerrain');

        if( $idTerrainCible){
            $terrainCibleRepository = $doctrine->getRepository(TerrainCf::class);
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
            $nCf = $request->request->get('n_titre'); 
            $terrain = $doctrine->getRepository(TerrainCf::class)->findOneBy(['n_certificat'=>$nCf ]);
            if($terrain){
                $idTerrain = $terrain->getId();
                $proprietaire = $terrain->getProprietaire();
                if($proprietaire->getCin() == $cinProprietaire){
                    $manager = $doctrine->getManager();
                    $contenance->setTerrainCf($terrain);
                    $manager->persist($contenance);
                    $routeAfterAddContenance = $this->generateUrl("app_admin_show_terrain_cf", ['id' => $idTerrain]);
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
                    return $this->redirectToRoute('app_admin_terrain_cf_edit_contenance');
                }
            }else{
                $this->addFlash('danger' , "Le terrain n'existe pas");
                return $this->redirectToRoute('app_admin_terrain_cf_edit_contenance');
            }
            
        }
        return $this->render('terrain_cf/addContenance.html.twig', [ 
            'form'=>$form->createView(),
            'titre'=>$titre,
            'terrainCible'=>$terrainCible
        ]);
    }


}
