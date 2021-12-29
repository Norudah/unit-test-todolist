<?php

/* 
  TEST ENTITY USER
*/

namespace App\Tests\Entity;

use App\Entity\User;
use Carbon\Carbon;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\ConstraintViolation;
class UserTest extends KernelTestCase 
{

  public function getEntity() : User {

    $user = new User();

    $user->setEmail("toto@gmail.com")
    ->setFirstname("non")
    ->setLastname("oui")
    ->setPassword("12345678")
    ->setBirthdate(Carbon::now()->subYears(13));

    return $user;
  }

  public function assertHasErrors(User $user, int $number = 0) {
    self::bootKernel();
    $errors = self::$container->get('validator')->validate($user); // get validation based on entity's rules
    $messages = [];
    
    /** @var ConstraintViolation $error */
    // build messages error
    foreach($errors as $error) {
        $messages[] = $error->getPropertyPath() . ' => ' . $error->getMessage();
    }
    $this->assertCount($number, $errors, implode(', ', $messages));
  }

  public function testValidEntity() {
    $this->assertHasErrors($this->getEntity(), 0);
  }

  /* PASSWORD CHECK */

  public function testInvalidPasswordTooShort()
  {
      $this->assertHasErrors($this->getEntity()->setPassword("toto"), 1);
  }

  public function testInvalidPasswordTooLong()
  {
    $this->assertHasErrors($this->getEntity()->setPassword("On sait depuis longtemps que travailler avec du texte lisible et contenant du sens est source de distractions, et empêche de se concentrer sur la mise en page elle-même. L'avantage du Lorem Ipsum sur un texte générique comme 'Du texte. Du texte. Du texte.' est qu'il possède une distribution de lettres plus ou moins normale, et en tout cas comparable avec celle du français standard. De nombreuses suites logicielles de mise en page ou éditeurs de sites Web ont fait du Lorem Ipsum leur faux texte par défaut, et une recherche pour 'Lorem Ipsum' vous conduira vers de nombreux sites qui n'en sont encore qu'à leur phase de construction. Plusieurs versions sont apparues avec le temps, parfois par accident, souvent intentionnellement (histoire d'y rajouter de petits clins d'oeil, voire des phrases embarassantes)."), 1);
  }

  /* EMAIL CHECK */

  public function testInvalidEmail()
  {
    $this->assertHasErrors($this->getEntity()->setEmail("toto"), 1);
  }

}