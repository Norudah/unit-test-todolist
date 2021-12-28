<?php

namespace App\Tests\UnitTests;

require 'vendor/autoload.php';


use App\Entity\Item;
use App\Entity\ListToDo;
use App\Entity\User;
use App\Service\EmailSenderService;
use App\Service\ListUtilsService;
use Carbon\Carbon;
use Exception;
use PHPUnit\Framework\TestCase;

final class ListToDoTest extends TestCase
{

    private ListToDo $listToDo;
    private $emailService;
    private $listService;

    protected function setUp(): void
    {
        $this->listToDo = new ListToDo();

        for ($i = 0; $i < 9; $i++) {
            $this->listToDo->addItem(new Item()); // 9 items
        }

        $this->emailService = $this->getMockBuilder(EmailSenderService::class)
        ->onlyMethods(["sendMail"])
        ->getMock();

        $this->listService = new ListUtilsService(new EmailSenderService());
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

    /**
     * List has 7 items (+ 1 for the current item being added)
     * sendMail
     */


    // public function testEmailListDidNotReached8Items() {

    //     // Une liste avec < 6 items

    //     $this->emailService->expects($this->any())
    //         ->method('sendMail')
    //         ->willReturn(true);
            

    //     echo $this->emailService->sendMail(new User(), "bonjour je suis un contenu ?");

    //     // listHass8items()
    //     // true -> envoie un mail
    //     // false -> avoie pas de mail
    // }

     public function testEmailListDidNotReached8Items() {

        $user = new User();
        $user->setEmail("blabla@bla.com");

        $this->listToDo = new ListToDo();

        for ($i = 0; $i < 7; $i++) {
            $this->listToDo->addItem(new Item());
        }

        $this->assertFalse($this->listService->preventUserFromReaching8Items($user, $this->listToDo));
        
     }

     public function testEmailListDidReached8ItemsAndSuccessfulSent() {

        $user = new User();
        $user->setEmail("blabla@bla.com");

        $this->listToDo = new ListToDo();

        for ($i = 0; $i < 8; $i++) {
            $this->listToDo->addItem(new Item());
        }

        $this->emailService->expects($this->any())
        ->method('sendMail')
        ->willReturn(true);

        $this->listService = new ListUtilsService($this->emailService);

        // TODO : Faire le mock pour forcer le sendMail() à retourner true
        $this->assertTrue($this->listService->preventUserFromReaching8Items($user, $this->listToDo));
        
     }

     public function testEmailListDidReached8ItemsAndUnsuccessfulSent() {

        $user = new User();
        $user->setEmail("blabla@bla.com");

        $this->listToDo = new ListToDo();

        for ($i = 0; $i < 8; $i++) {
            $this->listToDo->addItem(new Item());
        }

        $this->emailService->expects($this->any())
        ->method('sendMail')
        ->willThrowException(new Exception("A problem has been performed while attempting to send an email."));

        $this->expectException(Exception::class);
        $this->listService->preventUserFromReaching8Items($user, $this->listToDo);
     }
}
