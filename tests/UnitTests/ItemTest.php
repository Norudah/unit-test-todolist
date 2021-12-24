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

    $this->

    $this->item = new Item();
    $this->item
    ->setName("Une tâche nulle")
    ->setContent("Description d'une tâche vraiment nulle.")
  }

   

}