<?php

namespace App\Tests\Entity;

use App\Entity\User;
use Carbon\Carbon;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserTest extends KernelTestCase 
{

  public function getEntity() : User {

    $user = new User();

    $user->setEmail("tamerlatchouin@gmail.com")
    ->setFirstname("tamer")
    ->setLastname("Latchouing")
    ->setPassword("12345678")
    ->setBirthdate(Carbon::now()->subYears(13));

    return $user;
  }

  public function assertHasErrors(User $user, int $number = 0) {
    self::bootKernel();
    $errors = self::getContainer()->get('validator')->validate($user);
    $messages = [];
    
    /** @var ConstraintViolation $error */
    foreach($errors as $error) {
        $messages[] = $error->getPropertyPath() . ' => ' . $error->getMessage();
    }
    $this->assertCount($number, $errors, implode(', ', $messages));
  }

  public function testValidEntity() {
    $this->assertHasErrors($this->getEntity(), 0);
  }

  // public function testInvalidEntity() {

  // }


}