<?php

namespace App\Controller;

use App\Entity\Livreur;
use App\Form\LivreurType;
use App\Repository\LivreurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/Livreur')]
class LivreurController extends AbstractController
{
    #[Route('/', name: 'app_Livreur_index', methods: ['GET'])]
    public function index(LivreurRepository $LivreurRepository): Response
    {
        return $this->render('Livreur/index.html.twig', [
            'Livreurs' => $LivreurRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_Livreur_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $Livreur = new Livreur();
        $form = $this->createForm(LivreurType::class, $Livreur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($Livreur);
            $entityManager->flush();

            return $this->redirectToRoute('app_Livreur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Livreur/new.html.twig', [
            'Livreur' => $Livreur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_Livreur_show', methods: ['GET'])]
    public function show(Livreur $id): Response
    {
        return $this->render('Livreur/show.html.twig', [
            'Livreur' => $id,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_Livreur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Livreur $id, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LivreurType::class, $id);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_Livreur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Livreur/edit.html.twig', [
            'Livreur' => $id,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_Livreur_delete', methods: ['POST'])]
    public function delete(Request $request, Livreur $id, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$id->getId(), $request->request->get('_token'))) {
            $entityManager->remove($id);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_Livreur_index', [], Response::HTTP_SEE_OTHER);
    }
}
