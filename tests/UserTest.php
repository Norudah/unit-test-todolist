<?php

/* declare(strict_types=1);

require("User.php"); */

use Carbon\Carbon;
use PHPUnit\Framework\TestCase;

final class UserTest extends TestCase
{

    protected function setUp(): void
    {
    }
    public function test(): void
    {
        $this->assertFalse(false);
    }

    /* AGE CHECK */

    /*
    public function testInvalidAgeTooYoung()
    {
        $this->user->setBirthdate();
        $this->assertEquals(false, $this->user->isValid());
    }

    */

     /* PASSWORD CHECK */

    /*
    public function testInvalidPasswordTooLowCharacter()
    {
        $this->user->setPassword("toto");
        $this->assertEquals(false, $this->user->isValid());
    }

    public function testInvalidPasswordTooMuchCharacter()
    {
        $this->user->setEmail("Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam convallis aliquam lorem quis sodales. Suspendisse potenti. Praesent odio magna, aliquet ut elit id, accumsan venenatis nisl. Donec id aliquam enim. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam convallis interdum.");
        $this->assertEquals(false, $this->user->isValid());
    }

    */

    /* EMAIL CHECK */

    /*
    public function testInvalidEmailType()
    {
        $this->user->setEmail("toto");
        $this->assertEquals(false, $this->user->isValid());
    }

    public function testInvalidEmailWithOneSpecialCharacter()
    {
        $this->user->setEmail("hello@to)to.com");
        $this->assertEquals(false, $this->user->isValid());
    }

    public function testInvalidEmailWithoutExtension()
    {
        $this->user->setEmail("toto@toto");
        $this->assertEquals(false, $this->user->isValid());
    }

      public function testInvalidEmailWithoutDomainName()
    {
        $this->user->setEmail("toto@.com");
        $this->assertEquals(false, $this->user->isValid());
    }

    */


    /* FIRSTNAME CHECK */
    /*
    public function testInvalidFirstnameEmpty()
    {
        $this->user->setFirstname("");
        $this->assertEquals(false, $this->user->isValid());
    }

    /* LASTNAME CHECK */
    /*
    public function testInvalidLastnameEmpty()
    {
        $this->user->setLastname("");
        $this->assertEquals(false, $this->user->isValid());
    }

    public function testEverythingGoesWell()
    {
        $this->assertEquals(true, $this->user->isValid());
    } */

    
}