# SmartCar

## Spis treści
- [Opis aplikacji](#opis)
- [Technologie](#technologie)
- [Wzorce projektowe/architektoniczne](#Wzorce-projektowe/architektoniczne)
- [Design bazy danych](#design-bazy-danych)
- [Instalacja](#instalacja)
- [Screeny](#screeny)

## Opis aplikacji
SmartCar to aplikacja dla wypożyczalni samochodów. Użytkownik może przeglądać dostępne samochody i je rezerwować. Admin serwisu zarządza rezerwacjami oraz może dodawać nowe samochody.

## Technologie
- Docker
- HTML, CSS, JS
- PHP, PostgreSQL, pgAdmin
- Nginx
- Git

## Wzorce projektowe/architektoniczne
- MVC
- Repozytorium
- Singleton

## Design bazy danych
- Diagram ERD bazy danych
    ![diagram ERD](database-ERD.png)
- Schemat bazy danych
    - [database.sql](database.sql)

## Instalacja
1. Sklonuj repozytium
```bash
git clone https://github.com/oslusarczyk/WdPAI.git
cd WdPAI
```
2. Zbuduj kontener docker
```bash
docker-compose build
docker-compose up -d
```
3. Skorzystaj z aplikcji pod adresem http://localhost:8080

## Screeny

#### Login
| Desktop       | Mobilnie     |
|:-------------:|:------------:|
|![login-desktop](public\screenshots\login-desktop.png) | ![login-main](public\screenshots\login-mobile.png)

#### Main
| Desktop       | Mobilnie     |
|:-------------:|:------------:|
|![main-desktop](public\screenshots\main-desktop.png) | ![main-mobile](public\screenshots\main-mobile.png)

#### Samochody
Przeglądanie dostępnych samochodów z możliwością ich filtrowania. 
| Desktop       | Mobilnie     |
|:-------------:|:------------:|
|![search-desktop](public\screenshots\search-desktop.png) | ![search-mobile](public\screenshots\search-mobile.png)


#### Historia rezerwacji

Widok poszczególnych rezerwacji i ich status dla zalogowanego użytkownika 
| Desktop       | Mobilnie     |
|:-------------:|:------------:|
|![history-desktop](public\screenshots\history-desktop.png) | ![history-mobile](public\screenshots\history-mobile.png)

#### Dodawanie samochodów przez admina
| Desktop       | Mobilnie     |
|:-------------:|:------------:|
|![admin-desktop](public\screenshots\admin-desktop.png) | ![admin-mobile](public\screenshots\admin-mobile.png)

