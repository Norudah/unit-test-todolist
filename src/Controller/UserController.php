<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Item;
use App\Entity\ListToDo;
use App\Form\ItemType;
use App\Form\ListToDoType;
use App\Form\UserType;
use App\Repository\ItemRepository;
use App\Repository\UserRepository;
use App\Service\EmailSenderService;
use App\Service\ListUtilsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user')]
class UserController extends AbstractController
{

    #[Route('/{id}/new-toDolist', name: 'new_toDoList')]
    public function new_toDoList(User $user, Request $request): Response
    {
        /*  
            1. Instancier l'user
            2. $user->getList
            3. IF (null ou something)
                3.1 null : On créer la liste
                3.2 something : On créer pas la liste
            4. render
        */

        if ($user->getList()) {
            dd("T'as déjà une liste");
        } else {
            $listToDo = new ListToDo();
            $form = $this->createForm(ListToDoType::class, $listToDo);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user->setList($listToDo));
                $entityManager->persist($listToDo);
                $entityManager->flush();

                return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->renderForm('list_to_do/new.html.twig', [
                'list_to_do' => $listToDo,
                'form' => $form,
            ]);
        }
    }

    #[Route('/{id}/new-item', name: 'new_item')]
    public function new_item(User $user, ItemRepository $itemRepository, Request $request, ListUtilsService $listService): Response
    {

        $em = $this->getDoctrine()->getManager();
        if ($user->getList()) {                             // if user have list
            if ($user->getList()->canAddItem()) {           // if user have < 10 items
                if (empty($itemRepository->findLastItemIfGreaterThan30Minutes($user->getList()->getId()))) {  // last user.item > 30 min
                    $item = new Item();
                    $form = $this->createForm(ItemType::class, $item);
                    $form->handleRequest($request);
                    $item->setListToDo($user->getList());

                    if (

                        $form->isSubmitted()
                        && $form->isValid()
                        && $item->isValid()
                        && $item->isUnique()
                    ) {
                        $entityManager = $this->getDoctrine()->getManager();
                        $entityManager->persist($item);
                        $entityManager->flush();

                        // if($user->getList()->hasToPreventUserByEMail())
                        // {
                        //     $serviceMail = new EmailSenderService();
                        //     $serviceMail->sendMail($user, "Tu ne peux plus que rajouter 2 items.");
                        // }


                        $listService->preventUserFromReaching8Items($user, $user->getList());
                        return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
                    }
                    return $this->renderForm('item/new.html.twig', [
                        'item' => $item,
                        'form' => $form,
                    ]);
                } else {
                    dd("Erreur : dernier item créé il y a moins de 30min");
                }
            } else {
                dd("T'as deja 10 items");
            }
        } else {
            dd("Erreur : pas de liste");
        }
    }
    #[Route('/', name: 'user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'user_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {

        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && $user->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}/edit', name: 'user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/check-user', name: 'check_user', methods: ['GET'])]
    public function check_user(): bool
    {
        return true;
    }
}
