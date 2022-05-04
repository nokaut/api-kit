ChangeLog
=========

v1.8.0
------
- Aktualizacja guzzle do wersji 7
- Poprawki i testy dla PHP 8.1
- Kompatibilność z PHP 7.2.5+ (kompatybilność z PHP 5.5, 5.6, 7.0, 7.1 nie jest zapewniana od tej wersji)

v1.7.2
------
- aktualizacja README
- FIX: testy dla PHP 5.5, 7.2
- dodanie dodatkowych pól dla sklepów
- opcjonalne dodawanie pola _metadata w ProductsQuery
- dodanie OpineoRating do Entity/Shop
- dodanie pola complementary w Entity\Category

v1.7.1
------
- konfiguracja proxy dla RestClientApi
- fix FetchMenuCategories
- dodanie pola prefix w Entity/Category

v1.7.0
------
- Dodanie filtra Mutiple dla klienta Api
- Poprawka sortowania zakresów wartości cech produktów z facetingu
- Dodanie adresu pierwszej strony do products meta paging
- Dodanie atrybutu is_label do cechy produktu
- zmiana interface \Nokaut\ApiKit\Cache\CacheInterface oraz dodanie Nokaut\ApiKit\Cache\AbstractCache - jeśli implementowaliście interface CacheInterface wystarczy, że rozszerzycie swoją klasę abstrkcyjną klasą Nokaut\ApiKit\Cache\AbstractCache
- Pobieranie ShopsRepository i ProducersRepository z klasy ApiKit
- Dodanie repozytoriów: ShopsAsyncRepository i ProducersAsyncRepository
- Entity/Shop dodanie url_logo
- wymuszanie określenia pól dla method ShopsAsyncRepository i ShopsRepository
- Entity/Producer - nowe pola: url_logo, url, description
- Nokaut\ApiKit\Entity\OfferOffer\Shop - dodanie pola url adresu www do sklepu
- FIX: Nokaut\ApiKit\Helper\PhotoUrl - ustawienie domyślnej wartości $additionalUrlPart
- FIX: Nokaut\ApiKit\Ext\Data\Converter\Filters\PriceRangesConverter - nazwa filtru gdy jest tylko cena minimalna
- Dodanie timeout dla połączenia oraz request-u

v1.6.0
------
- Dodanie obsługi pobierania, dodawania, aktualizacji opinii i ocen produktów
- Dodanie obsługi ShopsApi, ProducersApi
- Ext PriceRanges - jeśli jawnie pytamy api o url_in_template dla zakresów, cen zmienia się format url_in_template z 'cena:%s~%s' na 'cena:%s', do którego przekazyjemy zakres lub kwotę
- Dodanie do facetingu pól ułatwiających budowanie adresów z filtrami
- Dodanie description_html do encji Category
- Umożliwienie pobierania produktów z limitem 0 (tylko faceting)
- Dodanie pól do porównań dla cech produktu
- Dodanie standalone query filter
- Dodanie oceny sklepu w produkcie
- Aktualizacja guzzle do wersji 6
- Kompatibilność z PHP 5.5+ (kompatybilność z PHP 5.3. i 5.4 nie jest wspierana od tej wersji)
- RestClientApi: obsługa tokena albo jako string albo jako obiekt implementujący interface \Nokaut\ApiKit\ClientApi\Rest\Auth\AuthHeader

v1.5.2
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