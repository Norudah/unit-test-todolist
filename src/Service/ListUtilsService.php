<?php

namespace App\Service;

use App\Entity\User;
use App\Entity\ListToDo;
use App\Service\EmailSenderService;

class ListUtilsService
{
    private $doctrine;
    private $itemRepository;
    private $emailService;

    public function __construct(EmailSenderService $emailService)
    {
        // $this->doctrine = $doctrine;
        $this->emailService = $emailService;
    }

    // public function isItemUnique(Item $item)
    // {
    //     $em = $this->doctrine->getManager();
    //     return empty($em->getRepository(Item::class)->findOneBy(['name' => $item->getName(), 'listToDo' =>  $item->getListToDo()->getId()]));
    // }

    public function preventUserFromReaching8Items(User $user, ListToDo $list) {

        if ($list->hasToPreventUserByEMail()) {
            return $this->emailService->sendMail($user->getEmail(), "Tu as déjà 8 items dans ta liste. Attention !");
        }
        return false;
    }
}
