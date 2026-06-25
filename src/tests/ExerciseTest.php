<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Models\Exercise;

class ExerciseTest extends TestCase
{
    private function injectMockDb(Exercise $exercise, $pdoMock): void
    {
        $reflector = new \ReflectionClass(Exercise::class);
        $property = $reflector->getProperty('db');
        $property->setAccessible(true);
        $property->setValue($exercise, $pdoMock);
    }

    public function testExistsReturnsTrueWhenExerciseExists(): void
    {
        // 1. Stworzenie Mocka Statement
        $stmtMock = $this->createMock(\PDOStatement::class);
        $stmtMock->expects($this->once())
            ->method('execute')
            ->with([':name' => 'Bench Press'])
            ->willReturn(true);
        
        $stmtMock->expects($this->once())
            ->method('fetchColumn')
            ->willReturn(1);

        // 2. Stworzenie Mocka PDO
        $pdoMock = $this->createMock(\PDO::class);
        $pdoMock->expects($this->once())
            ->method('prepare')
            ->with($this->stringContains('SELECT 1 FROM exercises'))
            ->willReturn($stmtMock);

        $exercise = new Exercise();
        $this->injectMockDb($exercise, $pdoMock);

        $result = $exercise->exists('Bench Press');
        $this->assertTrue($result);
    }

    public function testExistsReturnsFalseWhenExerciseDoesNotExist(): void
    {
        // 1. Stworzenie Mocka Statement
        $stmtMock = $this->createMock(\PDOStatement::class);
        $stmtMock->expects($this->once())
            ->method('execute')
            ->with([':name' => 'Non Existent'])
            ->willReturn(true);
        
        $stmtMock->expects($this->once())
            ->method('fetchColumn')
            ->willReturn(false);

        // 2. Stworzenie Mocka PDO
        $pdoMock = $this->createMock(\PDO::class);
        $pdoMock->expects($this->once())
            ->method('prepare')
            ->with($this->stringContains('SELECT 1 FROM exercises'))
            ->willReturn($stmtMock);

        $exercise = new Exercise();
        $this->injectMockDb($exercise, $pdoMock);

        $result = $exercise->exists('Non Existent');
        $this->assertFalse($result);
    }
}
