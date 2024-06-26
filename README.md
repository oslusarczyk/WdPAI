# SmartCar

## Spis treści
- [Opis aplikacji](#opis)
- [Technologie](#technologie)
- [Wzorce projektowe/architektoniczne](#Wzorce-projektowe/architektoniczne)
- [Design bazy danych](#design-bazy-danych)
- [Diagram UML](#diagram-uml)
- [Instalacja](#instalacja)
- [Testy](#testy)
- [Screeny](#screeny)

## Opis aplikacji
SmartCar to aplikacja dla wypożyczalni samochodów. Użytkownik może przeglądać dostępne samochody i je rezerwować. Admin serwisu zarządza rezerwacjami oraz może dodawać nowe samochody.

## Technologie
- Docker
- HTML, CSS, JS
- PHP, PostgreSQL, pgAdmin
- Nginx
- Git
- PHPUnit

## Wzorce projektowe/architektoniczne
- MVC
- Repozytorium
- Singleton
- Builder

## Design bazy danych
- Diagram ERD bazy danych
    ![diagram ERD](database-ERD.png)
- Schemat bazy danych
    - [database.sql](database.sql)


## Diagram UML
![Diagram UML](UMLDiagram.png)

## Instalacja
1. Zbuduj kontener docker
```bash
docker-compose build
docker-compose up -d
```
2. Skorzystaj z aplikcji pod adresem http://localhost:8080

## Testy
Aby uruchomić testy dla projektu, należy wykonać następujące kroki:

  ```bash
   docker exec -it smartcar-php-1 /bin/sh
   
   ./vendor/bin/phpunit tests
  ```

Za pierwszym razem może być wymagane użycie komendy do instalacji PHPUnit w projekcie:
```
composer require --dev phpunit/phpunit ^11
```
## Screeny

#### Login
| Desktop       | Mobilnie     |
|:-------------:|:------------:|
|![login-desktop](./public/screenshots/login-desktop.png) | ![login-mobile](./public/screenshots/login-mobile.png)

#### Main
| Desktop       | Mobilnie     |
|:-------------:|:------------:|
|![main-desktop](./public/screenshots/main-desktop.png) | ![main-mobile](./public/screenshots/main-mobile.png)

#### Samochody
Przeglądanie dostępnych samochodów z możliwością ich filtrowania. 
| Desktop       | Mobilnie     |
|:-------------:|:------------:|
|![search-desktop](./public/screenshots/search-desktop.png) | ![search-mobile](./public/screenshots/search-mobile.png)


#### Historia rezerwacji

Widok poszczególnych rezerwacji i ich status dla zalogowanego użytkownika 
| Desktop       | Mobilnie     |
|:-------------:|:------------:|
|![history-desktop](./public/screenshots/history-desktop.png) | ![history-mobile](./public/screenshots/history-mobile.png)

#### Dodawanie samochodów przez admina
| Desktop       | Mobilnie     |
|:-------------:|:------------:|
|![admin-desktop](./public/screenshots/admin-desktop.png) | ![admin-mobile](./public/screenshots/admin-mobile.png)

