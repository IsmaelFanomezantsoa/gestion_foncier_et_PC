<?php

namespace App\Controller;

use App\Entity\Contenance;
use App\Entity\ProprietaireTerrainCf;
use App\Entity\TerrainCf;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MesTerrainsCfController extends AbstractController
{
    #[Route('user/mes/terrains/cf', name: 'app_user_mes_terrains_cf')]
    public function toutMesTerrainsCf(ManagerRegistry $doctrine): Response
    {
        $cinProprietaire = $this->getUser()->getCin();

        $proprietairesTerrainsCfRepository = $doctrine->getRepository(ProprietaireTerrainCf::class);
        $proprietaire = $proprietairesTerrainsCfRepository->findOneBy(['cin' => $cinProprietaire]);
        
        if(!$proprietaire){
            $this->addFlash('danger',"Vous n'avez pas des terrains à certificat foncier");
            $mesTerrainsCf = null;
            return $this->render('mes_terrains_cf/mes terrains cf.html.twig', [
                'mesTerrainsCfs' => $mesTerrainsCf

            ]);
        }else{
            $mesTerrainsCfRepository = $doctrine->getRepository(TerrainCf::class);
            $mesTerrainsCf = $mesTerrainsCfRepository->findBy(['proprietaire' => $proprietaire->getId()]);
            return $this->render('mes_terrains_cf/mes terrains cf.html.twig', [
                'mesTerrainsCfs' => $mesTerrainsCf
            ]);
        }        
    }

    #[Route('user/show/terrainsCf/{id?0}', name: 'app_user_show_terrain_cf')]
    public function showTerrainCf($id , TerrainCf $terrainCf = null, ManagerRegistry $doctrine): Response // param converter
    {
     
        if (!$terrainCf){
            $this->addFlash('danger' , "Le terrain n'existe pas");
            return $this->redirectToRoute("app_user_mes_terrains_cf");
        }
        $repository = $doctrine->getRepository(Contenance::class);
        $contenance = $repository->findBy(['terrainCf' => $id]);

        return $this->render('mes_terrains_cf/show terrain cf.html.twig', [
            'terrainCf' => $terrainCf, 
            'contenances'=> $contenance,
        ]);
    }
}
