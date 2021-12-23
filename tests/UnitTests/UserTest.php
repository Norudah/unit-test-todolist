<?php

namespace App\Tests\UnitTests;

use App\Entity\ListToDo;
use App\Entity\User;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;

final class UserTest extends TestCase 
{

  private User $user;

  protected function setUp(): void {

    $this->user = new User();

    $this->user
    ->setEmail("tatifouette@gmail.com")
    ->setFirstname("Sylvain")
    ->setLastname("Boudacher")
    ->setPassword("12345678")
    ->setBirthdate(Carbon::now()->subYears(13));
  }

  /*
  *
  *
  * IS VALID
  *
  */

  /* Global validation */

  public function testEverythingIsOkaaaaaaaaay() {
    $this->assertTrue($this->user->isValid());
  }

  /* AGE CHECK */  

  public function testInvalidAgeTooYoung() {
    $this->user->setBirthdate(Carbon::now()->subYears(10));
    $this->assertFalse($this->user->isValid());
  }

  public function testValidAgeOld() {
    $this->user->setBirthdate(Carbon::now()->subYears(90));
    $this->assertTrue($this->user->isValid());
  }


  /* PASSWORD CHECK */

  public function testValidPasswordCharacters() {
    $this->user->setPassword("1234567890");
    $this->assertTrue($this->user->isValid());
  }

  public function testValidPassword40Characters() {
    $this->user->setPassword("1234567890123456789012345678901234567890");
    $this->assertTrue($this->user->isValid());
  }

  public function testInvalidPasswordTooLowCharacter() {
      $this->user->setPassword("toto");
      $this->assertFalse($this->user->isValid());
  }

  public function testInvalidPasswordTooMuchCharacter() {
      $this->user->setEmail("Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam convallis aliquam lorem quis sodales. Suspendisse potenti. Praesent odio magna, aliquet ut elit id, accumsan venenatis nisl. Donec id aliquam enim. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam convallis interdum.");
      $this->assertFalse($this->user->isValid());
  }
  

  /* EMAIL CHECK */
 
  public function testInvalidEmailType() {
    $this->user->setEmail("toto");
    $this->assertFalse($this->user->isValid());
  }

  public function testInvalidEmailWithOneSpecialCharacter() {
    $this->user->setEmail("hello@to)to.com");
    $this->assertFalse($this->user->isValid());
  }

  public function testInvalidEmailWithoutExtension() {
    $this->user->setEmail("toto@toto");
    $this->assertFalse($this->user->isValid());
  }

  public function testInvalidEmailWithoutDomainName() {
    $this->user->setEmail("toto@.com");
    $this->assertFalse($this->user->isValid());
  }

  
  /* FIRSTNAME CHECK */
  
  public function testInvalidFirstnameEmpty() {
    $this->user->setFirstname("");
    $this->assertFalse($this->user->isValid());
  }


  /* LASTNAME CHECK */
  
  public function testInvalidLastnameEmpty() {
    $this->user->setLastname("");
    $this->assertFalse($this->user->isValid());
  }




  /*
  *
  *
  * CAN CREATE A LIST
  *
  */

  public function testCanCreateList() {
    $this->assertTrue($this->user->canCreateList());
  }
  
  public function testCannotCreateList() {
    $this->user->setList(new ListToDo());
    $this->assertFalse($this->user->canCreateList());
  }



}