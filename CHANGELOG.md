ChangeLog
=========

master
------
 - PhotoUrl::prepare - dodanie znaku / na początku adresu do zdjęcia

v1.3.0
------
 - Query: Refaktoring obsługi filtrów, ujednolicenie mechanizmu dodawania filtrów do Query
 - Query: metodę Nokaut\ApiKit\ClientApi\Rest\Query\ProductsQuery::addFilter($filter, $searchValue) zastąpiła metoda Nokaut\ApiKit\ClientApi\Rest\Query\QueryBuilderAbstract::addFilter(Filter\FilterInterface $filter)
 - Dodanie metody toHash() do Nokaut\ApiKit\ClientApi\ClientApiInterface
 - Pokrycie testami repozytoriów

v1.2.0
------
 - Product: Usunięcie pola description_html_generated

v1.1.4
------
 - ProductsAsyncRepository i ProductsRepository: pobieranie produktów z najlepszą ofertą po URL

v1.1.3
------
 - Dokumentacja: informacje na temat asynchronicznych zapytań do API

v1.1.1
------
 - Dodanie ChangeLog
 - Dodanie licencji

v1.1.0
------
 - Dodanie repozytoria z asynchronicznymi zapytaniami do API
 - Zmieniona Metadata z \stdClass na obiekty do łatwego użycia w klasie Collection\Products – brak kompatybilności z wersją Metadata z v1.0.0