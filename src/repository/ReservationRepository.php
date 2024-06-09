<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/ReservationBuilder.php';
require_once 'IReservationRepository.php';

class ReservationRepository extends Repository implements IReservationRepository {
    public function __construct(IDatabase $database)
    {
        parent::__construct($database);
    }
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
            $result[] = (new ReservationBuilder())
                ->setCarName($reservation['car_name'])
                ->setLocationName($reservation['location_name'])
                ->setPhoto($reservation['photo'])
                ->setReservationStartDate($reservation['reservation_start_date'])
                ->setReservationEndDate($reservation['reservation_end_date'])
                ->setReservationPrice($reservation['reservation_price'])
                ->setReservationStatus($reservation['reservation_status'])
                ->setEmail($reservation['email'])
                ->setReservationId($reservation['reservation_id'])
                ->build();
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
                $result[] = (new ReservationBuilder())
                    ->setCarName($reservation['car_name'])
                    ->setLocationName($reservation['location_name'])
                    ->setPhoto($reservation['photo'])
                    ->setReservationStartDate($reservation['reservation_start_date'])
                    ->setReservationEndDate($reservation['reservation_end_date'])
                    ->setReservationPrice($reservation['reservation_price'])
                    ->setReservationStatus($reservation['reservation_status'])
                    ->setEmail($reservation['email'])
                    ->setReservationId($reservation['reservation_id'])
                    ->build();
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

    public function updateReservationStatus(string $action, int $reservation_id) : void
    {
        $this->database->connect();
        $stmt = $this->database->getConnection()->prepare("
               UPDATE reservations
               SET reservation_status=:action
               WHERE reservation_id=:id;
            ");
        $stmt->bindParam(':action', $action, PDO::PARAM_STR);
        $stmt->bindParam(':id', $reservation_id, PDO::PARAM_INT);
        $stmt->execute();
        $this->database->disconnect();
    }
}
?>