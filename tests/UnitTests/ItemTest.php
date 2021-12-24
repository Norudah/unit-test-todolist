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

  protected function setUp(): void {

    $this->listToDo = new ListToDo();
    $this->item = new Item();
    $this->item
    ->setName("Une tâche nulle")
    ->setContent("Description d'une tâche vraiment nulle.")
    ->setListToDo($this->listToDo);
  }

  public function testCanCreateItem() {
    $this->assertTrue($this->item->isValid());
  } 

  public function testCanNotCreateItem() {
    $item2 = new Item();
    $item2->setName("Une tâche nulle")
      ->setContent("Description d'une tâche vraiment nulle.")
      ->setListToDo($this->listToDo);

    $this->assertFalse($item2->isValid());
  } 

}