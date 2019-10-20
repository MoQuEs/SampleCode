<?php

declare(strict_types = 1);

namespace App\Tests\Unit;


use App\Domain\Todo;
use PHPUnit\Framework\TestCase;


/**
 * Class TodoTest
 * @package App\Tests\Unit
 */
class TodoTest extends TestCase {
    /**
     * @throws \Exception
     */
    public function testSetAndGetData(): void {
        $subject = 'Todo 1';
        $description = 'Description';
        $completed = false;
        $todo = new Todo($subject, $description, $completed);

        self::assertEquals($subject, $todo->getSubject());
        self::assertEquals($description, $todo->getDescription());
        self::assertEquals($completed, $todo->getCompleted());
        self::assertNotEmpty($todo->getRegisteredAt());
    }
}
