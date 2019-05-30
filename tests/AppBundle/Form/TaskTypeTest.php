<?php


namespace Tests\AppBundle\Form;

use AppBundle\Form\TaskType;
use AppBundle\Entity\Task;
use Symfony\Component\Form\Test\TypeTestCase;

class TaskTypeTest extends TypeTestCase
{
    public function testSubmitValidData()
    {
        $task = new Task;

        $formData = array(
            'title' => 'Tâche 1',
            'content' => 'Faire les courses.',
        );

        $form = $this->factory->create(TaskType::class, $task);
        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($task->getTitle(), $form->get('title')->getData());
        $this->assertEquals($task->getContent(), $form->get('content')->getData());

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }
}
