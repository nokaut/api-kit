ChangeLog
=========
master
------
- SortAbstract: otworzenie metody sortującej
- ProductsMetadata: Dodanie pola Canonical dla listy produktów

v1.4.1
------
- Ustawienie domyślnych wartości dla atrybutów klas \Entity\Metadata\Facet
- ProductsRepository - dodanie pól 'click_value', 'shop', 'shop.url_logo', 'shop.name' do 'fieldsForProductBox'
- Dodanie obsługi zakresów cech (properties ranges)
- FIX: CollectionAbstract klucze encji

v1.4.0
------
 - PhotoUrl - gdy puste photoId zwraca link do zaślepiki noimg<size>.png
 - ProductsRepository - dodanie pola 'click_url' do 'fieldsForProductBox'
 - OffersRepository - funkcja pobierania oferty po id
 - OffersRepository - funkcja pobierania ofert po shopId
 - OffersRepository - funkcja pobierania oferty po OffersQuery
 - FIX: poprawka do async repository na różne konfiguracje

**UWAGA: zmiana konstruktora w repozytoriach z:**

    public function __construct($apiBaseUrl, ClientApiInterface $clientApi)

**na:**

    public function __construct(Config $config, ClientApiInterface $clientApi)

v1.3.1
------
 - PhotoUrl::prepare - dodanie znaku / na początku adresu do zdjęcia
 - fix w pobieraniu produktu po URL-u

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