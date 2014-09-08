Nokaut.pl Search API KIT (PHP)
==============================

[![Build Status](https://travis-ci.org/nokaut/api-kit.svg?branch=master)](https://travis-ci.org/nokaut/api-kit)

Biblioteka umożliwia komunikację z Search API oraz mapuje odpowiedzi na określone obiekty.

Status
------

Bibioteka jest w trakcie tworzenia, obecnie pokrywa funkcjonalność pobierania produktów i ofert. Nie umożliwia pobierania metadanych, filtrów.

Wymagania
---------

* PHP 5.3+
* dostęp do Search API (klucz OAuth)

Instalacja
----------
Rekomendowaną formą instalacji jest skorzystanie z [Composer'a](http://getcomposer.org/).
Najpierw należy zainstalować Composer'a:

    curl -sS https://getcomposer.org/installer | php

Następnie trzeba utworzyć lub zaktualizować plik composer.json w Twoim projekcie, przykładowy plik composer.json:

    # Dodanie źródła repozytorium, w sekcji "repositories" i wymaganie instalacji API KIT
    {
        "minimum-stability": "dev",
        "prefer-stable": true,
        "repositories": [
            {
                "type": "vcs",
                "url": "https://github.com/nokaut/api-kit"
            }
        ],
        "require": {
            "nokaut/api-kit": "dev-master"
        }
    }

Instalujemy pakiety Composer'em:

    php composer.phar install

Po zainstalowaniu, należy dołączyć do projektu autoloader Composer'a:

    require 'vendor/autoload.php'

Szybki start
------------

Skonfigurowanie obiektu ApiKit:

    use Nokaut\ApiKit\ApiKit;
    use Nokaut\ApiKit\Config;
    use Nokaut\ApiKit\Repository\ProductsRepository;
    use Nokaut\ApiKit\Repository\OffersRepository;

    $oauthToken = 'xxxxxxxxxxxx';
    $apiUrl = 'http://xxxxxxxxxxxx';

    $config = new Config();
    $config->setApiAccessToken($oauthToken);
    $config->setApiUrl($apiUrl);

    $apiKit = new ApiKit($config);

Pobranie kategorii podrzędnych danej kategorii (jeden poziom):

    $categoriesRepository = $apiKit->getCategoriesRepository();
    $parentId = 0; // 0 - główny węzeł w drzewie kategorii
    $category = $categoriesRepository->fetchByParentId($parentId);

Pobranie kategorii na podstawie jej ID:

    $categoriesRepository = $apiKit->getCategoriesRepository();
    $categoryId = 127;
    $category = $categoriesRepository->fetchById($categoryId);

Pobranie kategorii na podstawie jej URL:

    $categoriesRepository = $apiKit->getCategoriesRepository();
    $categoryUrl = 'laptopy';
    $category = $categoriesRepository->fetchByUrl($categoryUrl);

Pobranie kategorii wraz z jej podkategoriami (będzie uzupełnione pole $category->getChildren()):

    $categoriesRepository = $apiKit->getCategoriesRepository();
    $depth = 2; // głębokość pobrania podkategorii (max 2)
    $categories = $categoriesRepo->fetchByParentIdWithChildren($categoryParentId, $depth);

Pobranie produktów kategorii:

    $productsRepository = $apiKit->getProductsRepository();
    $categoryIds = array(127);
    $limit = 20;
    $products = $productsRepository->fetchProductsByCategory($categoryIds, $limit, ProductsRepository::$fieldsForProductPage);

Pobranie produktów na podstawie własnego zapytania:

    $apiUrl = 'http://xxxxxxxxxxxx';
    $query = new ProductsQuery($apiUrl);
    $query->setFields(ProductsRepository::$fieldsForList);
    ...
    $products = $productsRepo->fetchProductsByQuery($query);

Pobranie produktu na podstawie jego URL:

    $productsRepository = $apiKit->getProductsRepository();
    $productUrl = 'telefony/apple-iphone-5s-16gb';
    $product = $productsRepository->fetchProductByUrl($productUrl, ProductsRepository::$fieldsForProductPage);

Pobranie ofert produktu na podstawie jego ID:

    # mamy już pobrany produkt
    $offersRepository = $apiKit->getOffersRepository();
    $offers = $offersRepository->getOffersByProductId($product->getId(), OffersRepository::$fieldsForProductPage);

### Asynchroniczne odpytywanie się API (od wersji v1.1.0)

Dzięki asynchronicznym zapytania do API zwiększysz szybkość strony.
**Jak to działa?** Rozważmy przypadek strony produktu na której będzie produkt, jego oferty oraz 10 produktów z tej samej kategorii. Jeśli będziemy odpytywać API po kolei to łączny czas wyniesie sumę 3 zapytań:

- zapytanie od produkt – czas 100ms
- zapytanie o oferty produktu – czas 230ms
- zapytanie o 10 produktów z tej samej kategorii co produkt – czas 300 ms

Łączny czas wyniesie 100 + 230 + 300 = 630ms

Jak możemy to przyspieszyć? Asynchroniczne zapytania wykonywane są jednocześnie czyli łączny czas wszystkich zapytań będzie równy najdłuższemu zapytaniu. W praktyce wygląda to tak:

- odpytujemy się o produkt – czas 100ms
- następnie jednocześnie odpytujemy się o oferty i 10 produktów z tej samej kategorii co produkt – czas wyniesie 300ms gdyż pobieranie 10 produktów trwało dłużej (300ms) niż pobieranie ofert (230ms).

Łączny czas pobierania wszystkich danych wyniesie 400ms zamiast 630ms.

Dlaczego nie pobraliśmy produkt jednocześnie z pozostałymi dwoma zapytaniami? Musieliśmy tak zrobić gdyż do pozostałych dwóch pobrań potrzebne są dane: ID produktu oraz ID kategorii.

Poniżej przykład kodu opisanego wyżej przypadku:

        //pobieramy produkt
        $productUrl = 'jakis/url_do_produktu';
        $productsRepo = $apiKit->getProductsRepository();
        $product = $productsRepo->fetchProductByUrl($productUrl, ProductsRepository::$fieldsForProductPage);

        //inicjalizujemy zapytanie o oferty
        $offersRepo = $apiKit->getOffersAsyncRepository();
        $offersFetch = $offersRepo->fetchOffersByProductId($product->getId(), OffersRepository::$fieldsForProductPage);

        //inicjalizujemy zapytanie o produkty z tej samej kategorii
        $productsRepo = $apiKit->getOffersAsyncRepository();
        $limitProducts = 10;
        $productsFromCategoryFetch = $productsRepo->fetchProductsByCategory(array($categoryId), $limitProducts, ProductsRepository::$fieldsForProductBox);

        //pobieranie jednocześnie oferty i produkty z kategorii
        $categoriesRepo->fetchAllAsync();

        //wyniki możemy dostać metodą getResult() z obiektu zwracanego przez metody $repository->fetch....();
        //lista ofert
        $offers = $offersFetch->getResult();
        //lista produktów z tej samej kategorii
        $productsFromCategory = $productsFromCategoryFetch->getResult();

FAQ
---

**Czy możliwe jest cache'owanie odpowiedzi z Search API?**

Tak, podczas budowania obiektu konfiguracji należy ustawić obiekt odpowiedzialny za cache'owanie danych, obiekt ten musi implementować interfejs *Nokaut\ApiKit\Cache\CacheInterface*.
Nie jest zalecane cache'owanie odpowiedzi z Search API na okresy dłuższe niż kilka minut.

    $config->setCache($cache);

**Czy możliwe jest logowanie zapytań i odpowiedzi z Search API?**

Tak, podczas budowania obiektu konfiguracji należy ustawić obiekt odpowiedzialny za logowanie danych, obiekt ten musi implementować ineterfejs *Psr\Log\LoggerInterface*.

    $config->setLogger($logger);
