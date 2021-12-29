<?php

namespace App\Tests\UnitTests;

use App\Entity\ListToDo;
use App\Entity\User;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;

final class UserTest extends TestCase
{

  private User $user;

  protected function setUp(): void
  {
    $this->user = new User();

    $this->user
      ->setEmail("test@gmail.com")
      ->setFirstname("prenom")
      ->setLastname("nom")
      ->setPassword("12345678")
      ->setBirthdate(Carbon::now()->subYears(13));
  }

  /*  
  * IS VALID
  */

  /* Global validation */

  public function testUserIsValid()
  {
    $this->assertTrue($this->user->isValid());
  }

  /* AGE CHECK */

  public function testUserIsTooYoungThan13yeasOld()
  {
    $this->user->setBirthdate(Carbon::now()->subYears(10));
    $this->assertFalse($this->user->isValid());
  }

  public function testUserHaveMoreThan13YearsOld()
  {
    $this->user->setBirthdate(Carbon::now()->subYears(90));
    $this->assertTrue($this->user->isValid());
  }


  /* PASSWORD CHECK */

  public function testUserHaveValidPasswordWith9Characters()
  {
    $this->user->setPassword("123456789");
    $this->assertTrue($this->user->isValid());
  }

  public function testUserHaveValidPasswordWith40Characters()
  {
    $this->user->setPassword("1234567890123456789012345678901234567890");
    $this->assertTrue($this->user->isValid());
  }

  public function testUserHaveInvalidPasswordWithLessThan8Characters()
  {
    $this->user->setPassword("toto");
    $this->assertFalse($this->user->isValid());
  }

  public function testUserHaveInvalidPasswordWithMoreThan40Characters()
  {
    $this->user->setEmail("Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam convallis aliquam lorem quis sodales. Suspendisse potenti. Praesent odio magna, aliquet ut elit id, accumsan venenatis nisl. Donec id aliquam enim. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam convallis interdum.");
    $this->assertFalse($this->user->isValid());
  }


  /* EMAIL CHECK */

  public function testUserHaveInvalidEmailType()
  {
    $this->user->setEmail("toto");
    $this->assertFalse($this->user->isValid());
  }

  public function testUserHaveInvalidEmailWithOneSpecialCharacter()
  {
    $this->user->setEmail("hello@to)to.com");
    $this->assertFalse($this->user->isValid());
  }

  public function testUserHaveInvalidEmailWithoutExtension()
  {
    $this->user->setEmail("toto@toto");
    $this->assertFalse($this->user->isValid());
  }

  public function testUserHaveInvalidEmailWithoutDomainName()
  {
    $this->user->setEmail("toto@.com");
    $this->assertFalse($this->user->isValid());
  }


  /* FIRSTNAME CHECK */

  public function testUserHaveEmptyFirstname()
  {
    $this->user->setFirstname("");
    $this->assertFalse($this->user->isValid());
  }

  public function testUserHaveNotEmptyFirstname()
  {
    $this->user->setFirstname("firstname");
    $this->assertTrue($this->user->isValid());
  }


  /* LASTNAME CHECK */

  public function testUserHaveEmptyLastname()
  {
    $this->user->setLastname("");
    $this->assertFalse($this->user->isValid());
  }

  public function testUserHaveNotEmptyLastname()
  {
    $this->user->setLastname("lastname");
    $this->assertTrue($this->user->isValid());
  }


  /*
  * TEST CREATION LIST
  */

  public function testUserHaveNotListSoCanCreateList()
  {
    $this->assertTrue($this->user->getList() ? false : true);
  }

  public function testUserHaveListSoCannotCreateList()
  {
    $this->user->setList(new ListToDo());
    $this->assertFalse($this->user->getList() ? false : true);
  }
}
