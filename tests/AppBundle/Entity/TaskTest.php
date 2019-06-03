<?php
/**
 * @author Sébastien Rochat <percevalseb@gmail.com>
 */

namespace Tests\AppBundle\Entity;

use AppBundle\Entity\Task;
use AppBundle\Entity\User;
use PHPUnit\Framework\TestCase;

/**
 * Class TaskTest
 * @package Tests\AppBundle\Entity
 */
class TaskTest extends TestCase
{
    /**
     * @var Task
     */
    private $task;

    protected function setUp()
    {
        $this->task = new Task();
    }

    public function testId()
    {
        static::assertNull($this->task->getId());

        $task = $this->createMock(Task::class);
        $task->method('getId')->willReturn(1);

        static::assertInternalType('integer', $task->getId());
        static::assertEquals(1, $task->getId());
    }

    public function testCreatedAt()
    {
        $createdAt = new \Datetime('NOW', new \DateTimeZone('Europe/Paris'));
        $this->task->setCreatedAt($createdAt);

        static::assertInstanceOf(\Datetime::class, $this->task->getCreatedAt());
        static::assertSame($createdAt, $this->task->getCreatedAt());
    }

    public function testTitle()
    {
        $title = 'Tâche 1';
        $this->task->setTitle($title);

        static::assertNotEmpty($title, $this->task->getTitle());
        static::assertGreaterThanOrEqual(2, strlen($this->task->getTitle()));
        static::assertLessThanOrEqual(255, strlen($this->task->getTitle()));
        static::assertInternalType('string', $this->task->getTitle());
        static::assertEquals($title, $this->task->getTitle());
    }

    public function testContent()
    {
        $content = "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Perspiciatis quo, dolorum obcaecati, maxime rem ratione, ";
        $content .= 'doloremque, eaque sint praesentium illum omnis cum cumque alias distinctio! Aspernatur nobis, vel labore iste.';
        $this->task->setContent($content);

        static::assertNotEmpty($content, $this->task->getTitle());
        static::assertInternalType('string', $this->task->getContent());
        static::assertEquals($content, $this->task->getContent());
    }

    public function testIsDone()
    {
        $this->task->toggle(true);

        static::assertInternalType('boolean', $this->task->isDone());
        static::assertEquals(true, $this->task->isDone());
    }

    public function testUser()
    {
        $user = new User();
        $this->task->setUser($user);

        static::assertInstanceOf(User::class, $this->task->getUser());
        static::assertSame($user, $this->task->getUser());
    }
}
