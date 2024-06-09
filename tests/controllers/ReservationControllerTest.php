<?php

use PHPUnit\Framework\TestCase;

require_once 'src/controllers/ReservationController.php';
require_once 'src/repository/IReservationRepository.php';
require_once 'src/services/Validator.php';
require_once 'src/models/ReservationBuilder.php';

class ReservationControllerTest extends TestCase
{
    private $reservationRepositoryMock;
    private $validatorMock;
    private $reservationController;

    protected function setUp(): void
    {
        $this->reservationRepositoryMock = $this->createMock(IReservationRepository::class);
        $this->validatorMock = $this->createMock(Validator::class);

        $this->reservationController = $this->getMockBuilder(ReservationController::class)
            ->setConstructorArgs([$this->reservationRepositoryMock, $this->validatorMock])
            ->onlyMethods(['render', 'isGet', 'isPost', 'redirectToReferer','getUserEmailFromSession'])
            ->getMock();
    }



    public function testHistoryRendersLoginPageWhenUserNotLoggedIn()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $this->reservationController->expects($this->once())
            ->method('getUserEmailFromSession')
            ->willReturn(null);

        $this->reservationController->expects($this->once())
            ->method('render')
            ->with('login');

        $this->reservationController->history();
    }

    public function testHistoryRendersHistoryPageWhenUserLoggedIn()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $email = 'test@example.com';

        $reservation = new ReservationBuilder();
        $buildReservation = $reservation->build();
        $confirmedReservations = [$buildReservation, $buildReservation];
        $pendingReservations = [$buildReservation];

        $this->reservationController->expects($this->once())
            ->method('getUserEmailFromSession')
            ->willReturn($email);


        $this->reservationRepositoryMock->expects($this->any())
            ->method('getRepositoryByEmail')
            ->with($email, $this->anything())
            ->willReturnCallback(function($email, $status) use ($confirmedReservations, $pendingReservations) {
                if ($status === 'confirmed') {
                    return $confirmedReservations;
                } elseif ($status === 'pending') {
                    return $pendingReservations;
                }
                return [];
            });


        $this->reservationController->expects($this->once())
            ->method('render')
            ->with('history', ['confirmed' => $confirmedReservations, 'pending' => $pendingReservations]);

        $this->reservationController->history();
        $this->assertTrue(true);
    }

    public function testMakeReservationRedirectsWhenNotPost()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $this->reservationController->expects($this->once())
            ->method('isPost')
            ->willReturn(false);

        $this->reservationController->makeReservation();
    }

    public function testMakeReservationValidatesAndAddsReservation()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST = [
            'reservation_start_date' => '2022-01-01',
            'reservation_end_date' => '2022-01-10',
            'location_id' => 1,
            'car_id' => 1,
            'user_id' => 1
        ];

        $this->reservationController->expects($this->once())
            ->method('isPost')
            ->willReturn(true);

        $this->validatorMock->expects($this->once())
            ->method('validateReservation')
            ->with('2022-01-01', '2022-01-10', 1)
            ->willReturn(null);

        $this->reservationRepositoryMock->expects($this->once())
            ->method('addReservation')
            ->with('2022-01-10', '2022-01-01', 1, 1, 1);

        $this->reservationController->makeReservation();

        $this->assertEquals('Rezerwacja została złożona.', $_SESSION['message']);
    }

    public function testMakeReservationFailsValidation()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST = [
            'reservation_start_date' => '2022-01-01',
            'reservation_end_date' => '2022-01-10',
            'location_id' => 1,
            'car_id' => 1,
            'user_id' => 1
        ];

        $this->reservationController->expects($this->once())
            ->method('isPost')
            ->willReturn(true);

        $this->validatorMock->expects($this->once())
            ->method('validateReservation')
            ->with('2022-01-01', '2022-01-10', 1)
            ->willReturn('Validation failed.');

        $this->reservationRepositoryMock->expects($this->never())
            ->method('addReservation');


        $this->reservationController->makeReservation();

        $this->assertEquals('Validation failed.', $_SESSION['message']);
    }
}

?>
