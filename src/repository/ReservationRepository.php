<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/Reservation.php';

class ReservationRepository extends Repository{
    public function getRepositoryByEmail(string $email, string $status) :array{
        $this->database->connect();
            $stmt = $this->database->getConnection()->prepare('
            SELECT * FROM reservation_view
            WHERE email=:email AND reservation_status=:status
        ');
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        $stmt->execute();
        $this->database->disconnect();
        $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $result = [];
        foreach ($reservations as $reservation) {
            $result[] = new Reservation($reservation['car_name'],$reservation['location_name'],$reservation['photo'],$reservation['reservation_start_date'],$reservation['reservation_end_date'],$reservation['reservation_price'],$reservation['reservation_status'],$reservation['email'],$reservation['reservation_id']);
        }

        return $result;
        }

        public function getPendingReservations() :array{
            $this->database->connect();
                $stmt = $this->database->getConnection()->prepare("
                SELECT * FROM reservation_view
                WHERE reservation_status='pending'
            ");
            $stmt->execute();
            $this->database->disconnect();
            $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $result = [];
            foreach ($reservations as $reservation) {
                $result[] = new Reservation($reservation['car_name'],$reservation['location_name'],$reservation['photo'],$reservation['reservation_start_date'],$reservation['reservation_end_date'],$reservation['reservation_price'],$reservation['reservation_status'],$reservation['email'],$reservation['reservation_id']);
            }
    
            return $result;
            }



            public function addReservation(string $reservation_end_date, string $reservation_start_date, int $location_id, int $car_id, int $user_id) : void{
                $this->database->connect();
                $stmt = $this->database->getConnection()->prepare("
               INSERT INTO reservations(user_id, car_id, location_id, reservation_start_date, reservation_end_date)
	                VALUES (?,?,?,?,?);
            ");
                $stmt->execute([$user_id, $car_id, $location_id, $reservation_start_date, $reservation_end_date]);
                $this->database->disconnect();
            }
}
?>