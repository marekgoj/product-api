# Product API

## Instalacja i uruchomienie

Wykonaj komendę

```sh
$ make dev
```

Sprawdź plik Makefile aby w celu poznania innych komend.

## Testy

Testy składają się z 2 test suit: `unit` i `functional`.
Testy funkcjonalne używają bazy developerskiej (nie ma osobnej bazy do testów)

Aby uruchomić testy jednostkowe:

```sh
$ make test-unit
```

Aby uruchomić testy funkcjonalne:

```sh
$ make test-functional
```

Aby uruchomić wszystkie testy:

```sh
$ make test
```

## Informacje

Użyta architektura to Clean Architecture z Portami i Adapterami

Można jeszcze dodać:
- dokumentację w Swagger z NelmioApiDocBundle
- analiza kodu (np. phpstan) + cs fixer
