<?php

namespace App\Controller;

use App\Entity\Contenance;
use App\Entity\ProprietaireTerrainTitre;
use App\Entity\TerrainTitre;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MesTerrainsController extends AbstractController
{
    #[Route('user/mes/terrains/titres', name: 'app_user_mes_terrains_titres')]
    public function toutesMesTerrainsTitres(ManagerRegistry $doctrine): Response
    {
        $cinProprietaire = $this->getUser()->getCin();

        $proprietairesTerrainsTitreRepository = $doctrine->getRepository(ProprietaireTerrainTitre::class);
        $proprietaire = $proprietairesTerrainsTitreRepository->findOneBy(['cin' => $cinProprietaire]);
        
        if(!$proprietaire){
            $this->addFlash('danger',"Vous n'avez pas des terrains titrés");
            $mesTerrainsTitre = null;
            return $this->render('mes_terrains_titres/mes terrains titres.html.twig', [
                'mesTerrainsTitres' => $mesTerrainsTitre

            ]);
        }else{
            $mesTerrainsTitreRepository = $doctrine->getRepository(TerrainTitre::class);
            $mesTerrainsTitre = $mesTerrainsTitreRepository->findBy(['proprietaireTerrainTitre' => $proprietaire->getId()]);
            return $this->render('mes_terrains_titres/mes terrains titres.html.twig', [
                'mesTerrainsTitres' => $mesTerrainsTitre
            ]);
        }
    }


    #[Route('user/show/terrainsTitre/{id?0}', name: 'app_user_show_terrain_titre')]
    public function showTerrainTitre($id , TerrainTitre $terrainTitre=null, ManagerRegistry $doctrine): Response // param converter
    {
     
        if (!$terrainTitre){
            $this->addFlash('danger' , "Le terrain n'existe pas");
            return $this->redirectToRoute("app_user_mes_terrains_titres");
        }
        $repository = $doctrine->getRepository(Contenance::class);
        $contenance = $repository->findBy(['terrainTitre'=> $id]);

        return $this->render('mes_terrains_titres/show terrains titres.html.twig', [
            'terrainTitre' => $terrainTitre, 
            'contenances'=> $contenance
        ]);
    }
}
