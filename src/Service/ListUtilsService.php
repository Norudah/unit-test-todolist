<?php

namespace App\Service;

use App\Entity\Item;
use App\Repository\ItemRepository;
use Doctrine\Persistence\ManagerRegistry;
use Exception;

class ListUtilsService
{


    private $doctrine;
    private $itemRepository;

    public function __construct(ManagerRegistry $doctrine, ItemRepository $itemRepository)
    {
        $this->doctrine = $doctrine;
        $this->itemRepository = $itemRepository;
    }

    // TODO : Make a mock for testing this method in order to not crash the app.
    public function isItemUnique(Item $item)
    {
        $em = $this->doctrine->getManager();
        return empty($em->getRepository(Item::class)->findOneBy(['name' => $item->getName(), 'listToDo' =>  $item->getListToDo()->getId()]));
    }
}
