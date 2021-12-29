<?php

namespace App\Tests\UnitTests;

require 'vendor/autoload.php';

use App\Entity\Item;
use App\Entity\ListToDo;
use PHPUnit\Framework\TestCase;

final class ItemTest extends TestCase
{
  private Item $item;
  private ListToDo $listToDo;

  protected function setUp(): void
  {

    $this->listToDo = new ListToDo();
    $this->item = new Item();
    $this->item
      ->setName("oneTask")
      ->setContent("oneTask description ")
      ->setListToDo($this->listToDo);

    $this->listToDo->addItem($this->item);
  }

  /**
   * Valid item
   */

  public function testItemCanBeCreate()
  {
    $this->assertTrue($this->item->isValid());
  }

  /**
   * Invalid item
   */

  public function testItemCannotBeCreateWithEmptyItemName()
  {
    $this->item->setName("");
    $this->assertFalse($this->item->isValid());
  }

  public function testItemCannotBeCreateWithEmptyList()
  {
    $item = new Item();
    $item
      ->setName("Une tâche nulle")
      ->setContent("Description d'une tâche vraiment nulle.");

    $this->assertFalse($item->isValid());
  }

  public function testItemCannotBeCreateWithContentMoreThan1000Characters()
  {
    $content = "";
    for ($i = 0; $i < 101; $i++) {
      $content .= "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus orci. ";
    }
    $this->item->setContent($content);
    $this->assertFalse($this->item->isValid());
  }

  /**
   * Unicité
   */

  public function testItemNameIsUniqueInList()
  {

    $newItem = new Item();
    $newItem->setName('pouet')
      ->setContent("oneTask description ")
      ->setListToDo($this->listToDo);

    foreach ($this->listToDo->getItems() as $item) {
      echo (' / ' . $item->getName());
    }

    $this->assertTrue($newItem->isUnique());
  }

  public function testItemNameIsNotUniqueInList()
  {

    $newItem = new Item();
    $newItem->setName('oneTask')
      ->setContent("oneTask description ")
      ->setListToDo($this->listToDo);

    $this->assertFalse(($newItem->isUnique()));
  }

  /* public function testItemNameIsUniqueInList()
  {
    $ListService = new ListUtilsService();


    // $check = $itemRepository->findOneBy(['name' => "Une tâche nulle"]);
    $itemController = new ItemController();
    dd($itemController->check_unicity());
  }

  public function testInvalidItemAlreadyPresentInList()
  {
  } */

  // }

}
