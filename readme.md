# Komentarz


Na wstępie chciałbym zaznaczyć, że jest to rozwiązanie pośrednie, co oznacza że jest dobrą bazą do dalszego rozwoju, jednak zawiera jeszcze wiele braków.
To samo tyczy się mojego opisu, starałem się zawrzeć w nim wszystkie najważniejsze infromacje, jednak mogło się zdarzyć że o czymś zapomniałem.

Pozwoliłem sobie nie zmieniać istniejącego kodu, a po prostu utworzyć nową implementację zadania, zachowując wszystkie wytyczne.
W uwagach było zaznaczone czego być nie musi, co oznacza, że może :)
Wolę rozwiązanie bardziej kompletne i działające, aczkolwiek jeśli chodzi o frontend to pominąłem go całkowicie i użyty został `print_r`.

- Na potrzeby utrzymania jakości i czytelności kodu utworzyłem prosty routing oparty na atrybutach użytych w kontrolerze.
- Użyte DI nie jest w żaden sposób zarządzane, więc po prostu wszystkie zależności są inicjowane i przekazywane prosto w `index.php`.

- Ze względu na potrzebę zachowania precyzyjności cena jest przechowywana jako `integer` w skali grosza (cent).
- Formatowanie ceny zostało zaimplementowane wg wytycznych w fabryce (`ProductFactory`)
- Kod jest zgodny z **PHP 8.1** (dodano np. typowanie, atrybuty) i sformatowany w oparciu o **PSR-12** (takiego używam w swoich projektach).
- Zaktualizowany został także `composer.json` i wygenerowany odpowiedni autoload wg. przyjętej struktury.

Więcej informacji udzielę podczas rozmowy

# Architektura rozwiązania

Przemodelowałem strukturę tak, aby jak najlepiej oddać ideę warstwową i zachować spójność rozwiązania.

```
project-root/
├── src/
│   ├── Attributes/
│   │   └── Route.php
│   ├── Controller/
│   │   └── ProductController.php
│   ├── Core/
│   │   └── Attributes/
│   │   │   ├── Route.php
│   │   └── Interfaces/
│   │   │   ├── BasicFactoryInterface.php
│   │   │   ├── ValidatorInterface.php
│   │   ├── Request.php
│   │   ├── Response.php
│   │   ├── Router.php
│   │   ├── RouteRegistrar.php
│   ├── Entity/
│   │   └── Product.php
│   ├── Repository/
│   │   └── ProductRepository.php
│   └── Service/
│       ├── Product/
│       │   ├── ProductService.php
│       │   ├── ProductValidator.php
│       │   └── ProductFactory.php
├── vendor/
│   └── autoload.php
└── index.php
```

### Warstwy wprowadzonej architektury:
1. **Presentation Layer**:
    - Kontrolery (`ProductController`) odpowiedzialne za przetwarzanie żądań i generowanie odpowiedzi.
    - Plik `index.php` jako punkt wejścia.

2. **Service Layer**:
    - Logika biznesowa.
    - Service/Product/ProductService.php
    - Service/Product/ProductValidator.php
    - Service/Product/ProductFactory.php

3. **Data Access Layer**:
    - Interakcja z bazą danych (w naszym przypadku użyłem po prostu arraya)
    - Repository/ProductRepository.php

4. **Model Layer**:
    - Reprezentacja danych domenowych.
    - Entity/Product.php

5. **Core Layer**:
   - Podstawowe mechanizmy i infrastruktura aplikacji.
   - Attributes/Route.php
   - Interfaces/BasicFactoryInterface.php
   - Interfaces/ValidatorInterface.php
   - Core/Response.php
   - Core/Request.php
   - Core/Router.php
   - Core/RouteRegistrar.php

### Przyjęte praktyki i zasady

#### Clean Code:
   - Kod jest czytelny, metody i klasy mają zrozumiałe nazwy.
   - Metody są w miarę krótkie i skupione na jednej akcji.

#### DRY
   - Dodano stałe (np. `Product.php`) do przechowywania wartości walidacji i komunikatów błędów

#### SOLID
   - Klasy mają jedną odpowiedzialność. `Product`, `ProductRepository`, `ProductService` i `ProductController` są dobrze rozdzielone. 
   - Klasy są otwarte na rozszerzenie, ale zamknięte na modyfikacje. Można dodawać nowe metody do repozytorium, nie zmieniając istniejących klas. 
   - Klasy pochodne mogą być używane zamiennie z klasami bazowymi. W obecnym kodzie nie ma dziedziczenia, więc nie jest to bezpośrednio stosowane, ale struktura wspiera tę zasadę. 
   - Nie ma niepotrzebnych interfejsów. Klasy są dobrze rozdzielone, a ich interfejsy są użyteczne i nie obciążają innych klas. 
   - Klasy wyższe (np. `ProductController`) zależą od abstrakcji (np. `ProductService`), co pozwala na łatwe testowanie i zamienianie implementacji.

#### CQS
   - Metody, które zmieniają stan obiektu (np. `createProduct`, `updateProduct`, `deleteProduct`), są oddzielone od metod, które zwracają dane (np. `getProduct`, `getAllProducts`). 

      Oczywiście tylko tak podstawowo, można by jeszcze bardziej rozdzielić logikę, np. poprzez utworzenie osobnych klas dla komend i zapytań.

## Endpointy

- **GET** /products

   Pobiera wszystkie produkty.


- **POST** /product

   Tworzy nowy produkt.


- **PUT** /product/{id}
 
   Edytuje produkt o danym ID.


- **DELETE** /product/{id}
 
   Usuwa produkt o danym ID.

## Uruchomienie
Aplikację można uruchomić na wbudowanym serwerze php

`php -S localhost:8000 index.php`

## Testy
Utworzyłem przykładowe testy jednostkowe w katalogu `/tests`

Uruchomienie: ` php vendor/bin/phpunit tests`

## PhpStan
Kod został poddany analizie statycznej

Uruchomienie: `php vendor/bin/phpstan analyze src/ --level 5`