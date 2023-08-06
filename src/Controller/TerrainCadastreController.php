<?php

namespace App\Controller;

use App\Entity\Contenance;
use App\Entity\Parcelle;
use App\Entity\ProprietaireParcelle;
use App\Entity\TerrainCadastre;
use App\Form\ContenanceType;
use App\Form\ParcelleType;
use App\Form\TerrainCadastreType;
use App\Services\UploaderImage;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TerrainCadastreController extends AbstractController
{
    #[Route('admin/terrain/cadastre', name: 'app_admin_terrain_cadastre')]
    public function tousLesTerrainCadastre(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(TerrainCadastre::class);
        $all_terrain_cadastres = $repository->findAll();
        return $this->render('terrain_cadastre/tousLesTerrainCadastre.html.twig', [
            'all_terrain_cadastres'=> $all_terrain_cadastres
        ]);
    }

    #[Route('admin/terrain/cadastre/show/{id?0<\d+>}', name: 'app_admin_show_terrain_cadastre', requirements: ['id' => '\d+'])]
    public function AffichageTerrainCadastre( $id ,TerrainCadastre $terrainCadastre , ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Parcelle::class);
        $parcelle = $repository->findBy(['TerrainCadastre'=> $id]);
        
        return $this->render('terrain_cadastre/showTerrainCadastre.html.twig', [
            "terrainCadastres"=> $terrainCadastre, 
            'parcelles'=> $parcelle
        ]);
    }

    /////////////////////////
    #[Route('admin/terrain/cadastre/confirmationDelete/{id}', name: 'app_admin_confirmation_delete_terrain_cadastre')]
    public function deleteTerrainCadastreConfirmation(TerrainCadastre $terrainCadastre = null, $id, ManagerRegistry $doctrine): Response
    {
        if (!$terrainCadastre) {
            $this->addFlash("danger", "Le cadastre que vous voulez supprimer n'existe pas");
            return $this->redirectToRoute("app_admin_terrain_cadastre");
        }

        // Si l'utilisateur confirme la suppression, le lien de confirmation doit pointer vers la page de suppression
        $deleteConfirmationLink = $this->generateUrl('app_admin_delete_terrain_cadastre', ['id' => $id]);

        return $this->render('terrain_cadastre/deleteConfirmationPage.html.twig', [
            'terrainCadastres' => $terrainCadastre,
            'deleteConfirmationLink' => $deleteConfirmationLink,
        ]);
    }

    #[Route('admin/terrain/cadastre/delete/{id}', name: 'app_admin_delete_terrain_cadastre')]
    public function deleteTerrainCadastre(TerrainCadastre $terrainCadastre = null, $id, ManagerRegistry $doctrine): Response
    {
        if (!$terrainCadastre) {
            $this->addFlash("danger", "Le cadastre que vous voulez supprimer n'existe pas");
            return $this->redirectToRoute("app_admin_terrain_cadastre");
        }

        // Supprimez effectivement le terrain
        $entityManager = $doctrine->getManager();
        $entityManager->remove($terrainCadastre);
        $entityManager->flush();

        $this->addFlash("success", "Cadastre supprimé avec succès");
        return $this->redirectToRoute("app_admin_terrain_cadastre");
    }
/////////////////////////////////////////


/////////////////////////////////////////

    
    #[Route('admin/terrain/cadastre/edit{id?0 }', name: 'app_admin_add_terrain_cadastre')]
    public function addTerrainCadastre(TerrainCadastre $terrainCadastre=null , ManagerRegistry $doctrine ,Request $request , UploaderImage  $uploaderImage): Response
    {
        $new = false;
        if(!$terrainCadastre){
            $new = true;
            $terrainCadastre = new TerrainCadastre();
        }
        if ($new){
            $titre = "Ajouter un cadastre";
        }else{
            $titre = "Modifier un cadastre";
        }
        
        $form = $this->createForm(TerrainCadastreType::class , $terrainCadastre);
        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager = $doctrine->getManager();
            
            $image = $form->get('image')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($image) {
                $directory = $this->getParameter('image_du_plan_cadastre');

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $terrainCadastre->setImage($uploaderImage->uploadImage($image , $directory));
            }
            
            $manager->persist($terrainCadastre);
            $manager->flush();
            if ($new){
                $titre = "Ajouter un cadastre";
                $message = "Cadastre ajouté avec success";
            }else{
                $titre = "Modifier un cadastre";
                $message = "Mis à jour effectuée avec success";
            }
            $this->addFlash("success","".$message);
            return $this->redirectToRoute("app_admin_terrain_cadastre");


            
        }else{
            return $this->render('terrain_cadastre/addTerrainCadastre.html.twig', [
                'form' => $form->createView(), 
                'titre'=> $titre
            ]);
        } 
    }

    //////////////////////
    #[Route('admin/terrain/cadastre/confirmationDeleteParcelleTerrainCadastre/{id}', name: 'app_admin_confirmation_delete_parcelle_terrain_cadastre')]
    public function deleteParcelleTerrainCadastreConfirmation(Parcelle $parcelle = null, $id, ManagerRegistry $doctrine): Response
    {

        if (!$parcelle) {
            $this->addFlash("danger", "La parcelle que vous voulez supprimer n'existe pas");
            return $this->redirectToRoute("app_admin_terrain_cadastre");
        }

        // Si l'utilisateur confirme la suppression, le lien de confirmation doit pointer vers la page de suppression
        $deleteConfirmationLink = $this->generateUrl('app_admin_delete_parcelle_terrain_cadastre', ['id' => $id]);
        $idCadastre = $parcelle->getTerrainCadastre()->getId();
        $urlCancel = $this->generateUrl('app_admin_show_terrain_cadastre', ['id' => $idCadastre]);

        return $this->render('terrain_cadastre/deleteConfirmationPageParcelle.html.twig', [
            'parcelle' => $parcelle,
            'deleteConfirmationLink' => $deleteConfirmationLink,
            "urlCancel" => $urlCancel
        ]);
    }

    #[Route('admin/terrain/cadastre/deleteParcelle/{id}', name: 'app_admin_delete_parcelle_terrain_cadastre')]
    public function deleteParcelleTerrainCadastre(Parcelle $parcelle = null, $id, ManagerRegistry $doctrine): Response
    {
    
        if (!$parcelle) {
            $this->addFlash("danger", "La parcelle que vous voulez supprimer n'existe pas");
            return $this->redirectToRoute("app_admin_terrain_cadastre");
        }

        $idCadastre = $parcelle->getTerrainCadastre()->getId();
        $urlAfterDelete = $this->generateUrl('app_admin_show_terrain_cadastre', ['id' => $idCadastre]);



        // Supprimez effectivement le terrain
        $entityManager = $doctrine->getManager();
        $entityManager->remove($parcelle);
        $entityManager->flush();

        $this->addFlash("success", "Parcelle supprimée avec succès");
        return $this->redirect($urlAfterDelete);
    }
    #[Route('admin/terrain/cadastre/show/parcelle/{id?0<\d+>}', name: 'app_admin_show_parcelle_terrain_cadastre', requirements: ['id' => '\d+'])]
    public function AffichageParcelleTerrainCadastre( $id ,Parcelle $parcelle , ManagerRegistry $doctrine): Response
    {
        if(!$parcelle){
            $this->addFlash("danger","La parcelle n'existe pas");
            return $this->redirectToRoute("app_admin_terrain_cadastre");
        }
        $repository = $doctrine->getRepository(Contenance::class);
        $contenance = $repository->findBy(['parcelle'=> $id]);
        
        return $this->render('terrain_cadastre/showParcelleTerrainCadastre.html.twig', [
            "parcelle"=> $parcelle,
            'contenances'=> $contenance
        ]);
    }

    #[Route('admin/terrain/cadastre/parcelle/edit{id?0 }', name: 'app_admin_add_parcelle_terrain_cadastre')]
    public function addParcelleTerrainCadastre(Parcelle $parcelle=null , ManagerRegistry $doctrine ,Request $request , UploaderImage  $uploaderImage): Response
    {


        $idTerrainCible = $request->query->get('idTerrain');

        if( $idTerrainCible){
            $terrainCibleRepository = $doctrine->getRepository(TerrainCadastre::class);
            $terrainCible = $terrainCibleRepository->findOneBy(['id'=>$idTerrainCible]);
        }else{
            return $this->redirectToRoute('app_admin_terrain_titre_edit_contenance');
        }



        $new = false;
        if(!$parcelle){
            $new = true;
            $parcelle = new Parcelle();
        }
        if ($new){
            $titre = "Ajouter une parcelle";
        }else{
            $titre = "Modifier une parcelle";
        }


        
        
        $form = $this->createForm(ParcelleType::class , $parcelle);
        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager = $doctrine->getManager();
            



            $nTitreCadastre = $request->request->get('n_titre');  
            $terrainCadastreRepository = $doctrine->getRepository(TerrainCadastre::class);
            $terrainCadastre = $terrainCadastreRepository->findOneBy(['n_titre'=>$nTitreCadastre]);

            if(!$terrainCadastre){
                $this->addFlash('danger',"Le cadastre n'existe pas");
                return $this->render('terrain_cadastre/addParcelle.html.twig', [
                    'form' => $form->createView(), 
                    'titre'=> $titre,
                    'terrainCible'=>$terrainCible ,
                    'new'=>$new,
                    'parcelleCible'=>$parcelle
                ]);
            }
            
            // $idProprietaire = $parcelle->getProprietaireParcelle()->getId();
            
            $cinProprietaire = $request->request->get('cin_proprietaire');
            $proprietaireParcelleRepository = $doctrine->getRepository(ProprietaireParcelle::class);
            $proprietaireParcelle = $proprietaireParcelleRepository->findOneBy(['cin'=>$cinProprietaire]);



            if(!$proprietaireParcelle){
                $this->addFlash('danger',"Le proprietaire de la parcelle n'existe pas");
                return $this->render('terrain_cadastre/addParcelle.html.twig', [
                    'form' => $form->createView(), 
                    'titre'=> $titre,
                    'terrainCible'=>$terrainCible,
                    'new'=>$new,
                    'parcelleCible'=>$parcelle
                ]);
            }

            
            $image = $form->get('image')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($image) {
                $directory = $this->getParameter('image_du_plan_parcelle');

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $parcelle->setImageParcelle($uploaderImage->uploadImage($image , $directory));
            }
            $parcelle->setTerrainCadastre($terrainCadastre);
            $parcelle->setProprietaireParcelle($proprietaireParcelle);

            $manager->persist($parcelle);
            $manager->flush();
            if ($new){
                $titre = "Ajouter une parcelle";
                $message = "Parcelle ajoutée avec success";
            }else{
                $titre = "Modifier un parcelle";
                $message = "Mis à jour effectuée avec success";
            }
            
            $idCadastre = $terrainCadastre->getId();
            $urlLink = $this->generateUrl("app_admin_show_terrain_cadastre",['id' => $idCadastre]);

            $this->addFlash("success","".$message);
            return $this->redirect($urlLink);


            
        }else{
            return $this->render('terrain_cadastre/addParcelle.html.twig', [
                'form' => $form->createView(), 
                'titre'=> $titre,
                'terrainCible'=>$terrainCible,
                'new'=>$new,
                'parcelleCible'=>$parcelle
            ]);
        } 
    }

    //////////////////////
    #[Route('admin/terrain/cadastre/confirmationDeleteContenanceParcelle/{id}', name: 'app_admin_confirmation_delete_contenance_parcelle')]
    public function deleteContenanceParcelleConfirmation(Contenance $contenance = null, $id, ManagerRegistry $doctrine): Response
    {
        if (!$contenance) {
            $this->addFlash("danger", "La contenace que vous voulez supprimer n'existe pas");
            return $this->redirectToRoute("app_admin_terrain_cadastre");
        }

        // Si l'utilisateur confirme la suppression, le lien de confirmation doit pointer vers la page de suppression
        $deleteConfirmationLink = $this->generateUrl('app_admin_delete_contenance_parcelle', ['id' => $id]);
        $idParcelle = $contenance->getParcelle()->getId();
        $urlCancel = $this->generateUrl('app_admin_show_parcelle_terrain_cadastre', ['id' => $idParcelle]);

        return $this->render('terrain_cadastre/deleteConfirmationPageContenance.html.twig', [
            'contenance' => $contenance,
            'deleteConfirmationLink' => $deleteConfirmationLink,
            "urlCancel" => $urlCancel
        ]);
    }

    #[Route('admin/terrain/cadastre/deleteContenanceParcelle/{id}', name: 'app_admin_delete_contenance_parcelle')]
    public function deleteContenanceParcelle(Contenance $contenance = null, $id, ManagerRegistry $doctrine): Response
    {
       
        if (!$contenance) {
            $this->addFlash("danger", "La contenance que vous voulez supprimer n'existe pas");
            return $this->redirectToRoute("app_admin_terrain_cadastre");
        }

        $idParcelle = $contenance->getParcelle()->getId();
        $urlAfterDelete = $this->generateUrl('app_admin_show_parcelle_terrain_cadastre', ['id' => $idParcelle]);



        // Supprimez effectivement le terrain
        $entityManager = $doctrine->getManager();
        $entityManager->remove($contenance);
        $entityManager->flush();

        $this->addFlash("success", "Contenance supprimée avec succès");
        return $this->redirect($urlAfterDelete);
    }

    #[Route('admin/terrain/cadastre/Contenance/edit/{id?0}', name: 'app_admin_terrain_cadastre_edit_contenance')]
    public function editContenance(Contenance $contenance=null , ManagerRegistry $doctrine , Request $request): Response
    {


        $idTerrainCible = $request->query->get('idTerrain');

        if( $idTerrainCible){
            $terrainCibleRepository = $doctrine->getRepository(Parcelle::class);
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
            $nParcelleInput = $request->request->get('n_parcelle'); 

            // $idCadastre= $doctrine->getRepository(TerrainCadastre::class)->findOneBy(['n_titre'=>$nTitre ]);
            $parcelleRepository = $doctrine->getRepository(Parcelle::class);
            $parcelle = $parcelleRepository->findParcelleCadastre($nTitre,$nParcelleInput);
            if ($parcelle){

                if($parcelle[0] && $parcelle[0]->getProprietaireParcelle()->getCin() ==  $cinProprietaire){
                    $manager = $doctrine->getManager();
                        $contenance->setParcelle($parcelle[0]); 
                        $manager->persist($contenance);
                        $routeAfterAddContenance = $this->generateUrl("app_admin_show_parcelle_terrain_cadastre", ['id' => $parcelle[0]->getId()]);
                         
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
                    $this->addFlash("danger","La parcelle n'existe pas"); 
                    return $this->render('terrain_cadastre/addContenance.html.twig', [ 
                        'form'=>$form->createView(),
                        'titre'=>$titre,
                        'terrainCible'=>$terrainCible,
                        'new'=>$new,
                    ]);
                }
                
            }else{
                $this->addFlash("danger","La parcelle n'existe pas"); 
                    return $this->render('terrain_cadastre/addContenance.html.twig', [ 
                        'form'=>$form->createView(),
                        'titre'=>$titre,
                        'terrainCible'=>$terrainCible,
                        'new'=>$new,
                    ]);
            }
        }
        return $this->render('terrain_cadastre/addContenance.html.twig', [ 
            'form'=>$form->createView(),
            'titre'=>$titre,
            'terrainCible'=>$terrainCible,
            'new'=>$new,
        ]);
    }




}
