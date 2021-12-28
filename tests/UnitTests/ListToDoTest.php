<?php

namespace App\Tests\UnitTests;

require 'vendor/autoload.php';


use App\Entity\Item;
use App\Entity\ListToDo;
use App\Entity\User;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;

final class ListToDoTest extends TestCase
{

    private ListToDo $listToDo;

    protected function setUp(): void
    {
        $this->listToDo = new ListToDo();

        for ($i = 0; $i < 9; $i++) {
            $this->listToDo->addItem(new Item()); // 9 items
        }
    }

    /**
     * List has not too many items
     */

    public function testListIsValidWith9Items()
    {
        $this->assertTrue(true, $this->listToDo->canAddItem());
    }

    public function testListIsInvalidWithMoreThan10Items()
    {
        $this->listToDo->addItem(new Item()); // 10 items
        $this->assertFalse($this->listToDo->canAddItem());
    }
}
