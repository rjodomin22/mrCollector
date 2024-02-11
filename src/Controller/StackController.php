<?php

namespace App\Controller;

use App\Entity\Item;
use App\Entity\Stack;
use App\Form\StackType;
use App\Form\ChooseStackType;
use App\Repository\StackRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\DBAL\Logging\DebugStack;

#[Route('/stack')]
class StackController extends AbstractController
{
    #[Route('/', name: 'app_stack_index', methods: ['GET'])]
    public function index(StackRepository $stackRepository): Response
    {
        return $this->render('stack/index.html.twig', [
            'stacks' => $stackRepository->findAll(),
        ]);
    }

    #[Route('/chooseStack/{id}', name: 'app_stack_chose', methods: ['GET, POST'])]
    public function chooseItemStack(Item $item, Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $stack = new Stack();
        $form = $this->createForm(ChooseStackType::class, $stack, [
            'stacks' => $user->getSubscribedStacks(),
        ]);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $stack->addItem($item);
            $entityManager->persist($stack);
            $entityManager->flush();

            return $this->redirectToRoute('app_stack_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('stack/chooseStackType.html.twig', [
            'stack' => $stack,
            'form' => $form,
        ]);
    }

    #[Route('/new', name: 'app_stack_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $stack = new Stack();
        $form = $this->createForm(StackType::class, $stack);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($stack);
            $entityManager->flush();

            

            return $this->redirectToRoute('app_stack_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('stack/new.html.twig', [
            'stack' => $stack,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_stack_show', methods: ['GET'])]
    public function show(Stack $stack): Response
    {
        return $this->render('stack/show.html.twig', [
            'stack' => $stack,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_stack_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Stack $stack, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(StackType::class, $stack);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_stack_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('stack/edit.html.twig', [
            'stack' => $stack,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_stack_delete', methods: ['POST'])]
    public function delete(Request $request, Stack $stack, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$stack->getId(), $request->request->get('_token'))) {
            $entityManager->remove($stack);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_stack_index', [], Response::HTTP_SEE_OTHER);
    }
}
