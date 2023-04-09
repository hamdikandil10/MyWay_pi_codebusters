<?php

namespace App\Controller;


use App\Form\SearchEtablissementType;
use App\Form\EtablissementType;
use App\Entity\Etablissement;
use App\Repository\EtablissementRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EtablissementController extends AbstractController
{
    #[Route('/etablissement/list', name: 'app_etablissement_list')]
    public function list(EtablissementRepository $repository, Request $request): Response
    {
        $etablissements = $repository->findAll();
        $form = $this->createForm(SearchEtablissementType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $etablissements = $repository->findByAnyField($form['field']->getData());
            return $this->renderForm('admin/etablissement/list.html.twig', [
                'searchForm' => $form,
                'pageName' => 'Liste des etablissements',
                'etablissements' => $etablissements
            ]);

        }
        return $this->renderForm('admin/etablissement/list.html.twig', [
            'searchForm' => $form,
            'pageName' => 'Liste des etablissements',
            'etablissements' => $etablissements
        ]);
    }

    #[Route('/etablissement/create', name: 'app_etablissement_create')]
    public function create(ManagerRegistry $doctrine, Request $request): Response
    {
        $display='none';
        $etablissement = new Etablissement();
        $form = $this->createForm(EtablissementType::class, $etablissement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $rep = $doctrine->getRepository(Etablissement::class);
            $etab = $rep->findOneBy(['adresse' => $form['adresse']->getData()]);
            if ($etab == null) {
                $em = $doctrine->getManager();
                $em->persist($etablissement);
                $em->flush();
                return $this->redirectToRoute('app_etablissement_list');
            } else {
                $display = '';
                return $this->renderForm('admin/etablissement/create.html.twig', [
                    'pageName' => 'Creation d\'un Etablissement',
                    "form" => $form,
                    "display" => $display
                ]);
                
            }


        }

        return $this->renderForm('admin/etablissement/create.html.twig', [
            'pageName' => 'Creation d\'un Etablissement',
            "form" => $form,
            "display" => $display
        ]);
    }

    #[Route('/etablissement/read/{id}', name: 'app_etablissement_read')]
    public function read($id, EtablissementRepository $repository): Response
    {
        $etablissement = $repository->find($id);
        return $this->render('admin/etablissement/read.html.twig', [
            'pageName' => 'Etablissement / ' . $etablissement->getNom(),
            'etablissement' => $etablissement
        ]);
    }

    #[Route('/etablissement/update/{id}', name: 'app_etablissement_update')]
    public function update($id, ManagerRegistry $doctrine, Request $request): Response
    {
        $repository = $doctrine->getRepository(Etablissement::class);
        $etablissement = $repository->find($id);
        $form = $this->createForm(EtablissementType::class, $etablissement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $doctrine->getManager();
            $em->persist($etablissement);
            $em->flush();
            return $this->redirectToRoute("app_etablissement_list");

        }

        return $this->render('admin/etablissement/update.html.twig', [
            'pageName' => 'Modification d\'un etablissement',
            'etablissements' => $etablissement,
            "form" => $form->createView()
        ]);
    }

    #[Route('/etablissement/delete/{id}', name: 'app_etablissement_delete')]
    public function delete($id, ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Etablissement::class);
        $etablissement = $repository->find($id);
        $em = $doctrine->getManager();
        $em->remove($etablissement);
        $em->flush();
        return $this->redirectToRoute('app_etablissement_list');
    }
}