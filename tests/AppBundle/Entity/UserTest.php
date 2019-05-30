<?php


namespace Tests\AppBundle\Entity;

use AppBundle\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    private $user;

    protected function setUp()
    {
        $this->user = new User();
    }

    public function testId()
    {
        static::assertNull($this->user->getId());

        $user = $this->createMock(User::class);
        $user->method('getId')->willReturn(1);

        static::assertInternalType('integer', $user->getId());
        static::assertEquals(1, $user->getId());
    }

    public function testUsername()
    {
        $username = 'John-Doe';
        $this->user->setUsername($username);

        static::assertNotEmpty($username, $this->user->getUsername());
        static::assertInternalType('string', $this->user->getUsername());
        static::assertGreaterThanOrEqual(2, strlen($this->user->getUsername()));
        static::assertLessThanOrEqual(25, strlen($this->user->getUsername()));
        static::assertEquals($username, $this->user->getUsername());
    }

    public function testSalt()
    {
        static::assertNull($this->user->getSalt());
    }

    public function testPassword()
    {
        $password = '$2y$13$bgZrKW.muM/oqfs7vRD0OeT46/6oWroDlTVojW2yyQS4MYcajqwWW';
        $this->user->setPassword($password);

        static::assertNotEmpty($password, $this->user->getPassword());
        static::assertInternalType('string', $this->user->getPassword());
        static::assertGreaterThanOrEqual(2, strlen($this->user->getPassword()));
        static::assertLessThanOrEqual(64, strlen($this->user->getPassword()));
        static::assertEquals($password, $this->user->getPassword());
    }

    public function testEmail()
    {
        $email = 'user@gmail.com';
        $this->user->setEmail($email);

        static::assertNotEmpty($email, $this->user->getEmail());
        static::assertInternalType('string', $this->user->getEmail());
        static::assertRegExp('/^.+\@\S+\.\S+$/', $this->user->getEmail());
        static::assertLessThanOrEqual(255, strlen($this->user->getEmail()));
        static::assertEquals($email, $this->user->getEmail());
    }

    public function testRoles()
    {
        $roles = array('ROLE_USER');
        $this->user->setRoles($roles);

        static::assertInternalType('array', $this->user->getRoles());
        static::assertEquals($roles, $this->user->getRoles());
    }
}
