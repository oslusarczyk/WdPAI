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
        return $this->render("carAdmin",['reservations' => $reservationsToManage]);
    }

    function handleReservation(){
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
        if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
            header('Content-type: application/json');
            http_response_code(200);
            $this->reservationRepository->updateReservationStatus($decoded['action'],$decoded['reservation_id']);

        }
    }


}
?>
