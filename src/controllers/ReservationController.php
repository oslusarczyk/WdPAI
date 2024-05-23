<?php
require_once 'AppController.php';

require_once __DIR__.'/../repository/ReservationRepository.php';
require_once __DIR__.'/../models/Reservation.php';

class ReservationController extends AppController

{

    private $reservationRepository;

    public function __construct(){
        parent::__construct();
        $this->reservationRepository = new ReservationRepository();
    }



    public function history()
    {
        if(!$this->isGet()){
            return $this->render('history');
        }
        if(!isset($_SESSION['user'])){
            return $this->render('login');
        }

        $emailUser = unserialize($_SESSION['user'])->getEmail();
        $confirmedReservations = $this->reservationRepository->getRepositoryByEmail($emailUser, 'confirmed');
        $pendingReservations = $this->reservationRepository->getRepositoryByEmail($emailUser, 'pending');
        return $this->render('history', ['confirmed' => $confirmedReservations, 'pending' => $pendingReservations]);
    }

    public function makeReservation(){
        if(!$this->isPost()){
            return $this->render('carDetails');
        }
        $reservation_end_date = $_POST['reservation_end_date'];
        $reservation_start_date = $_POST['reservation_start_date'];
        $location_id = intval($_POST['location_id']);
        $car_id = intval($_POST['car_id']);
        $user_id = intval($_POST['user_id']);
        $this->reservationRepository->addReservation($reservation_end_date, $reservation_start_date, $location_id, $car_id,$user_id);

        return header('Location: ' . $_SERVER["HTTP_REFERER"] );
    }



}
?>
