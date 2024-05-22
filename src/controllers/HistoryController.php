<?php
require_once 'AppController.php';

require_once __DIR__.'/../repository/ReservationRepository.php';
require_once __DIR__.'/../models/Reservation.php';

class HistoryController extends AppController

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


}
?>
