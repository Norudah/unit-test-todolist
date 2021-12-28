<?php

namespace App\Tests\UnitTests;

require 'vendor/autoload.php';

use App\Controller\ItemController;
use App\Entity\Item;
use App\Entity\ListToDo;
use App\Repository\ItemRepository;
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
      ->setName("Une tâche nulle")
      ->setContent("Description d'une tâche vraiment nulle.")
      ->setListToDo($this->listToDo);
  }

  /**
   * Valid item
   */

  public function testItemCanBeCreate()
  {
    $this->assertTrue($this->item->isValid());
  }

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

    // $check = $itemRepository->findOneBy(['name' => "Une tâche nulle"]);
    $itemController = new ItemController();
    dd($itemController->check_unicity());
  }

  public function testInvalidItemAlreadyPresentInList()
  {
  }
}
