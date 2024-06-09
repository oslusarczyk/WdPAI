<?php

use PHPUnit\Framework\TestCase;

require_once 'src/repository/UserRepository.php';
require_once 'src/models/User.php';

class UserRepositoryTest extends TestCase
{
    private $mockDatabase;
    private $mockConnection;
    private $mockStatement;
    private $userRepository;

    protected function setUp(): void
    {
        $this->mockDatabase = $this->getMockBuilder(Database::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->mockConnection = $this->getMockBuilder(PDO::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->mockStatement = $this->getMockBuilder(PDOStatement::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->mockDatabase->method('getConnection')
            ->willReturn($this->mockConnection);

        $this->userRepository = new UserRepository($this->mockDatabase);
        $this->setProtectedProperty($this->userRepository, 'database', $this->mockDatabase);
    }

    private function setProtectedProperty($object, $property, $value)
    {
        $reflection = new ReflectionClass($object);
        $property = $reflection->getProperty($property);
        $property->setAccessible(true);
        $property->setValue($object, $value);
    }

    public function testAddUser()
    {
        $user = new User('test@example.com', 'password123');

        $this->mockDatabase->expects($this->once())
            ->method('connect');

        $this->mockConnection->expects($this->once())
            ->method('prepare')
            ->with($this->stringContains('INSERT INTO users'))
            ->willReturn($this->mockStatement);

        $this->mockStatement->expects($this->once())
            ->method('execute')
            ->with($this->equalTo(['test@example.com', 'password123']));

        $this->mockDatabase->expects($this->once())
            ->method('disconnect');

        $this->userRepository->addUser($user);
    }

    public function testGetUser()
    {
        $email = 'test@example.com';
        $userData = [
            'email' => 'test@example.com',
            'password' => 'password123',
            'has_admin_privileges' => 1,
            'id' => 1
        ];

        $this->mockDatabase->expects($this->once())
            ->method('connect');

        $this->mockConnection->expects($this->once())
            ->method('prepare')
            ->with($this->stringContains('SELECT * FROM users WHERE email = :email'))
            ->willReturn($this->mockStatement);

        $this->mockStatement->expects($this->once())
            ->method('bindParam')
            ->with(':email', $email, PDO::PARAM_STR);

        $this->mockStatement->expects($this->once())
            ->method('execute');

        $this->mockStatement->expects($this->once())
            ->method('fetch')
            ->willReturn($userData);

        $this->mockDatabase->expects($this->once())
            ->method('disconnect');

        $user = $this->userRepository->getUser($email);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals($userData['email'], $user->getEmail());
        $this->assertEquals($userData['password'], $user->getPassword());
        $this->assertEquals($userData['has_admin_privileges'], $user->getHasAdminPrivileges());
        $this->assertEquals($userData['id'], $user->getId());
    }

    public function testDoesEmailExists()
    {
        $email = 'test@example.com';

        $this->mockDatabase->expects($this->once())
            ->method('connect');

        $this->mockConnection->expects($this->once())
            ->method('prepare')
            ->with($this->stringContains('SELECT * FROM users WHERE email = :email'))
            ->willReturn($this->mockStatement);

        $this->mockStatement->expects($this->once())
            ->method('bindParam')
            ->with(':email', $email, PDO::PARAM_STR);

        $this->mockStatement->expects($this->once())
            ->method('execute');

        $this->mockStatement->expects($this->once())
            ->method('fetch')
            ->willReturn(true);

        $this->mockDatabase->expects($this->once())
            ->method('disconnect');

        $result = $this->userRepository->doesEmailExists($email);

        $this->assertTrue($result);
    }
}

?>
