# Instalacja na twoim komputerze composer'a

- Zainstaluj [getcomposer.org](https://getcomposer.org) na swoim komputerze.
- Przejdź do projektu, i wejdź do terminala, i wpisz następującą komende.
```
composer install
```
- **PHP 8.1** jest wymagany w XAMPP.
- Powinno Ci się zainstalować folder **vendor** na podstawie **composer.json**
- Stwórz plik **.env**
- I skopiuj wszystko co się znajduje w **.env.example** to jest plik konfiguracyjny za pomocą który komunikuje się PHP Laravel z bazą danych.
Najwazeniejszy kod jest ten
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=twoja_baza_danych
DB_USERNAME=root
DB_PASSWORD=
```

Baza danych znajduje się [tutaj](resources/DB).

# api-school-replacement
Aplikacja jest stworzona dla szkoły wyświetlanie na dashboard'zie zastępstwa.
Aplikacja była tworzona z kolegą [@PanDamax01](https://github.com/PanDamax01).
