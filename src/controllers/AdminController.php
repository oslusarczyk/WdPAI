<?php
require_once 'AppController.php';

require_once __DIR__.'/../repository/ReservationRepository.php';
require_once __DIR__.'/../models/Reservation.php';

class AdminController extends AppController

{

    private $reservationRepository;

    public function __construct(){
        parent::__construct();
        $this->reservationRepository = new ReservationRepository();
    }



    public function carAdmin()
    {
        if(!$this->isGet()){
            return $this->render('carAdmin');
        }

        $reservationsToManage = $this->reservationRepository->getPendingReservations();
        $this->render("carAdmin",['reservations' => $reservationsToManage]);
    }


}
?>
