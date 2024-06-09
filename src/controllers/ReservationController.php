<?php
require_once 'AppController.php';
require_once __DIR__.'/../repository/IReservationRepository.php';
require_once __DIR__.'/../models/Reservation.php';
require_once __DIR__.'/../services/Validator.php';

class ReservationController extends AppController
{
    private IReservationRepository $reservationRepository;
    private IValidator $validator;

    public function __construct(IReservationRepository $reservationRepository,IValidator $validator)
    {
        parent::__construct();
        $this->reservationRepository = $reservationRepository;
        $this->validator = $validator;
    }

    public function history(): void
    {
        $emailUser = $this->getUserEmailFromSession();
        if (!$emailUser) {
            $this->render('login');
            return;
        }
        $confirmedReservations = $this->reservationRepository->getRepositoryByEmail($emailUser, 'confirmed');
        $pendingReservations = $this->reservationRepository->getRepositoryByEmail($emailUser, 'pending');
        $this->render('history', ['confirmed' => $confirmedReservations, 'pending' => $pendingReservations]);
    }

    public function makeReservation(): void
    {
        if (!$this->isPost()) {
            $this->redirectToReferer();
            return;
        }

        $reservation_start_date = $_POST['reservation_start_date'] ?? null;
        $reservation_end_date = $_POST['reservation_end_date'] ?? null;
        $location_id = $_POST['location_id'] ?? null;
        $car_id = $_POST['car_id'] ?? null;
        $user_id = $_POST['user_id'] ?? null;

        $message = $this->validator->validateReservation($reservation_start_date, $reservation_end_date, $location_id);

        if ($message) {
            $_SESSION['message'] = $message;
            $this->redirectToReferer();
            return;
        }

        $this->reservationRepository->addReservation($reservation_end_date, $reservation_start_date, $location_id, $car_id, $user_id);
        $_SESSION['message'] = "Rezerwacja została złożona.";
        $this->redirectToReferer();
        return;
    }

    protected function getUserEmailFromSession(): ?string
    {
        if (!isset($_SESSION['user'])) {
            return null;
        }
        return unserialize($_SESSION['user'])->getEmail();
    }
}
?>
