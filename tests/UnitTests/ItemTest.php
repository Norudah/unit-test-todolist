<?php
namespace App\Tests\UnitTests;

require 'vendor/autoload.php';

use App\Entity\Item;
use App\Entity\ListToDo;
use App\Repository\ItemRepository;
use PHPUnit\Framework\TestCase;

final class ItemTest extends TestCase 
{
  private Item $item;
  private ListToDo $listToDo;

  protected function setUp(): void {

    echo "yo";
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

  public function testCanCreateItem() {
    $this->assertTrue($this->item->isValid());
  } 

  public function testCanNotCreateItemNameEmpty() {
    $this->item->setName("");
    $this->assertFalse($this->item->isValid());
  }

  public function testCanNotCreateItemListToDoEmpty()
  {
    $item = new Item();
    $item
    ->setName("Une tâche nulle")
    ->setContent("Description d'une tâche vraiment nulle.");

    $this->assertFalse($item->isValid());
  }

  public function testCanNotCreateItemContentOver1000Character()
  {
    $content = "";
    for($i = 0; $i < 101; $i++)
    {
      $content .= "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus orci. ";
    }
    $this->item->setContent($content);
    $this->assertFalse($this->item->isValid());
  } 

  /**
   * Unicité
   */

  public function testValidItemNotPresentInList() {

    // $check = $itemRepository->findOneBy(['name' => "Une tâche nulle"]);
    
    
  }

  public function testInvalidItemAlreadyPresentInList() {

  }

}