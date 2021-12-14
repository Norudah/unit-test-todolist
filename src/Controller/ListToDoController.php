<?php

namespace App\Controller;

use App\Entity\ListToDo;
use App\Form\ListToDoType;
use App\Repository\ListToDoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/list/to/do')]
class ListToDoController extends AbstractController
{
    #[Route('/', name: 'list_to_do_index', methods: ['GET'])]
    public function index(ListToDoRepository $listToDoRepository): Response
    {
        return $this->render('list_to_do/index.html.twig', [
            'list_to_dos' => $listToDoRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'list_to_do_new', methods: ['GET','POST'])]
    public function new(Request $request): Response
    {
        $listToDo = new ListToDo();
        $form = $this->createForm(ListToDoType::class, $listToDo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($listToDo);
            $entityManager->flush();

            return $this->redirectToRoute('list_to_do_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('list_to_do/new.html.twig', [
            'list_to_do' => $listToDo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'list_to_do_show', methods: ['GET'])]
    public function show(ListToDo $listToDo): Response
    {
        return $this->render('list_to_do/show.html.twig', [
            'list_to_do' => $listToDo,
        ]);
    }

    #[Route('/{id}/edit', name: 'list_to_do_edit', methods: ['GET','POST'])]
    public function edit(Request $request, ListToDo $listToDo): Response
    {
        $form = $this->createForm(ListToDoType::class, $listToDo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('list_to_do_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('list_to_do/edit.html.twig', [
            'list_to_do' => $listToDo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'list_to_do_delete', methods: ['POST'])]
    public function delete(Request $request, ListToDo $listToDo): Response
    {
        if ($this->isCsrfTokenValid('delete'.$listToDo->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($listToDo);
            $entityManager->flush();
        }

        return $this->redirectToRoute('list_to_do_index', [], Response::HTTP_SEE_OTHER);
    }
}
