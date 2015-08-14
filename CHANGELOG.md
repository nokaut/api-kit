ChangeLog
=========

master
------
- Dodanie standalone query filter

v1.5.1
------
- Ext: zmiany w regułach analizy produktów dla noindex, nofollow
- Podbicie i zamrożenie Guzzle na wersji 3.9 i Guzzle OAuth2 Plugin na wersji 1.0 (composer)
- Dodanie description_short do Offer
- CategoryFacet: dodanie pola subcategory_count
- logi: zmiana poziomu logowania odpowiedzi z API z statusem 404 z ERROR na INFO
- OfferWithBestPrice: dodanie pola sklep
- CategoriesRepository, CategoriesAsyncRepository: możliwość podania pól kategorii w odpytaniach do API
- RestClientApi: obsługa http status 422 - rzucany jest wyjątek UnprocessableEntityException,
- FIX: błąd przy nadpisywaniu Config przy pobieraniu reposytoriów,
- Category: dodanie pola title_type_singular (liczba pojedyńcza od nazwy kategorii)

v1.5.0
------
- SortAbstract: otworzenie metody sortującej
- ProductsMetadata: Dodanie pola Canonical dla listy produktów
- ProductsRepository: dodanie funkcji fetchProductsByUrlWithQuality
- Dodanie url_base do facets kategorii, producenta, sklepu
- Dodanie description_short do Product
- Dodanie total do Category
- Dodanie shops do fetchProductsByUrl w repozytorium Products
- Dodanie Ext - rozszerzenie biblioteki, generujące struktury przystosowane do łatwego użycia w widokach
- Limit na Categories
- Oznaczenie fetchSimilarProductsWithHigherPrice, fetchSimilarProductsWithLowerPrice jako deprecated w repozytoriach produktowych
- Dodanie block_adsense do metadata produktów
- Dodanie offer id w Product->OfferWithBestPrice
- Ponawianie requestu gdy API odpowie statusem 502
- Dodanie węwnętrznego cache w konwerterach Ext
- Zdefiniowane klonowane kolekcji i entity
- Product: zmiana typu obiektu kategorii (Category zamiast CategoryFacet).
- ProductsConverter: koniec z ustawianiem kategorii (CategoryFacet) przez konwerter, w razie potrzeby należy uzupełnić produkty pobranymi oddzielnie obiektami Category.
- FIX: wyrzucenie starych pół price_min price_max
- ProductWithBestOffer: dodanie pola click_value w OfferWithBestPrice

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