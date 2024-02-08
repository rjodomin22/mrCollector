<?php

namespace App\Controller;

use App\Entity\Maker;
use App\Form\MakerType;
use App\Repository\MakerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/maker')]
class MakerController extends AbstractController
{
    #[Route('/', name: 'app_maker_index', methods: ['GET'])]
    public function index(MakerRepository $makerRepository): Response
    {
        return $this->render('maker/index.html.twig', [
            'makers' => $makerRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_maker_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $maker = new Maker();
        $form = $this->createForm(MakerType::class, $maker);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($maker);
            $entityManager->flush();

            return $this->redirectToRoute('app_maker_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('maker/new.html.twig', [
            'maker' => $maker,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_maker_show', methods: ['GET'])]
    public function show(Maker $maker): Response
    {
        return $this->render('maker/show.html.twig', [
            'maker' => $maker,
            'items' => $maker->getCreatedItems(),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_maker_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Maker $maker, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MakerType::class, $maker);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_maker_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('maker/edit.html.twig', [
            'maker' => $maker,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_maker_delete', methods: ['POST'])]
    public function delete(Request $request, Maker $maker, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$maker->getId(), $request->request->get('_token'))) {
            $entityManager->remove($maker);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_maker_index', [], Response::HTTP_SEE_OTHER);
    }
}
