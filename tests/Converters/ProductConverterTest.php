<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 20.06.2014
 * Time: 08:46
 */

namespace Nokaut\ApiKit\Converter;


use Nokaut\ApiKit\Entity\Product;
use Nokaut\ApiKit\Entity\Product\Prices;
use Nokaut\ApiKit\Entity\Product\Property;
use Nokaut\ApiKit\Converter\Product\PropertyConverter;
use PHPUnit_Framework_TestCase;

class ProductConverterTest extends PHPUnit_Framework_TestCase
{

    public function testConverter()
    {
        $cut = new ProductConverter();
        $correctObject = $this->getCorrectObject();
        /** @var Product $product */
        $product = $cut->convert($correctObject);

        foreach ($correctObject as $field => $value) {
            if (!is_object($value) && !is_array($value)) {
                $this->assertEquals($value, $product->get($field));
            } else {
                $this->assertSubObject($field, $correctObject, $product);
            }
        }
    }

    /**
     * @param string $field
     * @param \stdClass $correctObject
     * @param Product $product
     */
    private function assertSubObject($field, $correctObject, Product $product)
    {
        switch ($field) {
            case 'properties':
                $this->assertProperties($correctObject->$field, $product->get($field));
                break;
            case 'photo_ids':
                $this->assertPhotoIds($correctObject->$field, $product->get($field));
                break;
            case 'prices':
                $this->assertPrices($correctObject->$field, $product->get($field));
                break;
            case 'shop':
                $this->assertShop($correctObject->$field, $product->get($field));
                break;
            case 'rating':
                $this->assertRating($correctObject->$field, $product->get($field));
                break;
            default:
                $this->assertTrue(false, "not supported assert for field : " . $field);
        }
    }

    /**
     * @param array $correctObjectProperties
     * @param Property[] $productProperties
     */
    private function assertProperties(array $correctObjectProperties, array $productProperties)
    {
        $this->assertCount(count($correctObjectProperties), $productProperties);
        foreach ($correctObjectProperties as $index => $correctProperty) {
            foreach ($correctProperty as $field => $value) {
                if (is_array($productProperties[$index]->get($field))) {
                    $this->assertEquals(
                        $value,
                        join(PropertyConverter::SEPARATOR_PROPERTIES, $productProperties[$index]->get($field))
                    );
                } else {
                    $this->assertEquals($value, $productProperties[$index]->get($field));
                }
            }
        }
    }

    private function assertPhotoIds(array $correctPhotoIds, array $photoIds)
    {
        foreach ($correctPhotoIds as $index => $correctPhotoId) {
            $this->assertEquals($correctPhotoId, $photoIds[$index]);
        }
    }

    private function assertPrices($correctPrices, Prices $prices)
    {
        $this->assertEquals($correctPrices->min, $prices->getMin());
        $this->assertEquals($correctPrices->max, $prices->getMax());
    }

    private function assertShop($correctShop, Product\Shop $shop)
    {
        foreach ($correctShop as $field => $value) {
            $this->assertEquals($value, $shop->get($field));
        }
    }

    private function assertRating($correctRating, Product\Rating $rating)
    {
        foreach ($correctRating as $field => $value) {
            $this->assertEquals($value, $rating->get($field));
        }
    }

    private function getCorrectObject()
    {
        return json_decode('{
                    "id": "529c845a82fff03c050002d1",
                    "title": "Hop-Sport HS-2080",
                    "offer_count": 26,
                    "properties": [
                        {
                            "id": 0,
                            "name": "Producent",
                            "value": "Hop-Sport"
                        },
                        {
                            "id": 1951,
                            "name": "Maksymalna waga użytkownika",
                            "value": "100",
                            "unit": "kg"
                        },
                        {
                            "id": 2336,
                            "name": "System hamowania",
                            "value": "magnetyczny"
                        },
                        {
                            "id": 1089,
                            "name": "Waga urządzenia",
                            "value": "34",
                            "unit": "kg"
                        },
                        {
                            "id": 2527,
                            "name": "Waga koła zamachowego",
                            "value": "5",
                            "unit": "kg"
                        },
                        {
                            "id": 948,
                            "name": "EAN",
                            "value": "5907640255218||5906190233097||5906190233080||5906190233073||HS-2080||24942||"
                        }
                    ],
                    "producer_name": "Hop-Sport",
                    "shop_count": 11,
                    "description_html": "<div><a><strong>Prezentacja 3D</strong><br />Zobacz produkt z każdej strony w najwyższej jakości.</a></div>\n<ul></ul>\n<div><a><strong>Prezentacja 3D</strong><br />Zobacz produkt z każdej strony w najwyższej jakości.</a></div>\n<div><a><strong>Prezentacja 3D</strong><br />Zobacz produkt z każdej strony w najwyższej jakości.</a></div>\n<p></p>\n<p> </p>\n<p> </p>\n<p><strong>Rower magnetyczny HS-2080 Spark</strong><br /></p>\n<p><br /></p>\n<p>Szukasz solidnego i funkcjonalnego rowerka stacjonarnego dla całej rodziny? Rower magnetyczny SPARK to idealny sprzęt dla wymagającego amatora.<br />Prezentowany model roweru magnetycznego został zaprojektowany z myślą zarówno o użytkownikach, którzy stawiają na trening rekreacyjny, ale też o osobach, których celem jest wzmocnienie mięśni i spalenie tkanki tłuszczowej.<br />Decydując się na ćwiczenia na tym rowerku zyskasz smukłą sylwetkę, lepsza kondycję, zaoszczędzisz czas i pieniądze wydane na siłowni.</p>\n<p><strong><br /></strong></p>\n<p><strong>Najważniejsze zalety roweru magnetycznego Spark:</strong></p>\n<ul><li>Posiada wielofunkcyjny komputer, dzięki któremu można na bieżąco śledzić postępy treningu: czas ćwiczeń, przebyty dystans, spalone kalorie, prędkość, tętno.</li><li>Czujniki pulsu (zlokalizowane na kierownicy) umożliwiają pomiar tętna, co jest ważne w przypadku treningu tlenowego nastawionego na spalanie tłuszczu.</li><li>Regulowana kierownica pokryta pianką, regulowane siodełko wypełnione żelem oraz wzmocniona stalowa konstrukcja gwarantują nie tylko komfort, ale i bezpieczeństwo każdego treningu.</li><li>8-stopniowa regulacja oporu, pozwalająca na wybór odpowiedniego obciążenia w zależności od formy użytkownika.</li><li>Bardzo cicha praca sprzętu, którą zapewniają całkowicie osłonięte koło zamachowe oraz hamulce magnetyczne.</li><li>Funkcjonalne rolki transportowe ułatwiające przemieszczanie rowerka.</li><li>Tylne nóżki regulacyjne pozwalające łatwo wypoziomować sprzęt.</li><li>Nowoczesny design.</li><li>Antypoślizgowe pedały z paskami zabezpieczającymi.</li></ul>\n<p><br /></p>\n<p><strong>Dodatkowe informacje techniczne:</strong></p>\n<ul><li>Wymiary: 84  x 48 x 123 cm (dł./szer./wys.)</li><li>Waga koła zamachowego: 5 kg</li><li>Waga urządzenia: 23 kg</li><li>Maksymalna waga osoby ćwiczącej: 120kg</li><li>Odległość od pedała do siodełka w pozycji najwyższej: 78 cm</li><li>Średnica rur podstawy 60 mm</li><li>Średnica kolumny 50 mm</li></ul>\n<p> </p>\n<p></p>\n<p> </p>\n<p> </p>\n<p></p>\n<p> </p>\n<p>\n\n</p>\n<ul></ul>\n<div>\n<p><strong>OPIS PRODUKTU:</strong> </p>\n<ul><li>\n<div>Zestaw hantli ze stojakiem BODY SCULPTURE to idealny komplet dla całej rodziny do aerobiku, ćwiczeń kulturystycznych, ćwiczeń usprawniających jak i różnych sztuk walki i rehabilitacji.</div>\n</li><li>\n<div>Nadają się do ćwiczenia w domu jak również w klubach fitness i siłowni.</div>\n</li><li>\n<div>Hantle wykonane są z masy betonowej pokrytej kolorowym winylem.</div>\n</li><li>\n<div>Powłoka winylowa nadaje estetyczny wygląd oraz gwarantuje długą żywotność hantli.</div>\n</li><li>\n<div>Posiadają podłużne żłobienia, dzięki którym hantle nie toczą się po podłożu.</div>\n</li><li>\n<div>Hantle przechowywane są na estetycznym, poręcznym stojaku, który ułatwia przechowywanie hantli w jednym miejscu.</div>\n</li><li>\n<div>Hantle można czyścić miękką zwilżoną szmatką z niewielka ilością mydła.</div>\n</li></ul>\n \n<hr />\n<p><strong>DANE TECHNICZNE:</strong></p>\n<p>W zestawie znajduja się:</p>\n<ul><li>2 sztuki hantli o wadze 1,5 kg</li><li>2 sztuki hantli o wadze 3 kg</li><li>2 sztuki hantli o wadze 5 kg</li><li>Waga zestawu 19 kg</li></ul>\n</div>",
                    "description_html_generated": "<p>Chcesz zrzucić kilka kilogramów? Jeśli tak jest, pomyśl nad zakupem <b>roweru stacjonarnego</b>, który Ci w tym pomoże. Sprawdź sprzęt <b>Hop-Sport HS-2080</b>. </p><h3>Wprowadzenie</h3><p>Rower treningowy to specyficzne urządzenie do ćwiczeń, które symuluje jazdę na rowerze - w domu - pod dachem. Od lat, miliony ludzi ćwiczą w swoich domach, pedałując na rowerach stacjonarnych. Zaletą tego urządzenia jest ruch jaki wykonujemy, który powoduje aktywizację i obciążenie mięśni, tak jakbyśmy jeździli na normalnym rowerze w terenie. Warto dodać, że pedałowanie na rowerze stacjonarnym daje bardzo dobre efekty, nie tylko pod względem poprawienia kondycji, ale także w przypadku zrzucania wagi czy podniesienia wytrzymałości i wydajności organizmu. Rowery treningowe umożliwiają realizowanie optymalnego dla nas programu ćwiczeń, niezależnie od pogody, ukształtowania terenu czy pory roku. Bogata gama modeli o różnej konstrukcji pozwala na zakup sprzętu, który będzie idealnie dopasowany do naszych potrzeb. </p><h3>Porady i specyfikacja </h3><p>Na rynku dostępne są trzy rodzaje takich urządzeń. Mamy więc rowery <b>pionowe</b>, na których jeździ się podobnie jak na klasycznych rowerach, z sylwetką wyprostowaną. Drugim typem jest rower <b>poziomy</b>, zajmujący względnie dużo miejsca, jednak będący bardzo wygodny podczas intensywnych treningów. Cechuje się półleżącą sylwetką ćwiczącego. Ostatnie, najdroższe, są przystosowane do ciężkich treningów, zarówno dla amatorów jak i sportowców dbających o sylwetkę. Oferują możliwość pełnej regulacji i programowania treningów - to rowery <b>spinningowe</b>. Na rynku dostępne są także trzy kategorie oporu zastosowanego w danym urządzeniu. <b>Mechaniczne, magnetyczne i elektromagnetyczne</b>. W rowerach mechanicznych, opór koła zamachowego generowany jest w momencie tarcia o paski i szczęki. Rowery magnetyczne, stawiają ćwiczącemu opór dzięki magnesowi, który w zależności od stopnia zaangażowania w ćwiczenie zbliża lub oddala się od koła zamachowego. Ostatnią grupę tworzą rowery elektromagnetyczne, w których zastosowano hamulec elektromagnetyczny. Urządzenia te są najdroższe w zakupie, ale też przystosowane do ciężkich treningów, zarówno dla amatorów jak i sportowców dbających o sylwetkę. Waga koła zamachowego, mechanicznej podstawy tego urządzenia również jest istotna. Im większe i cięższe koło zamachowe, tym płynniejszy ruch i większa regulacja oporu. To zastosowane w modelu HS-2080 waży <b>5 kg</b>. Przekłada się to na płynną i przyjemną pracę. Regulacja oporów może być mechaniczna, w postaci pokrętła lub z poziomu komputera. Ważne są też pedały, szerokie i chropowate, aby dawać stopom solidne podparcie i chronić przed zsuwaniem się nóg z urządzenia. Nieodłącznym elementem są też regulowane rękojeści, które służą do treningu górnych partii mięśni. Dodatkowe opcje uchwytu, aktywują kolejne partie mięśni. Istotna i obecna w rowerze HS-2080 jest też regulacja wysokości siodełka. Maksymalna wytrzymałość dla urządzenia, określająca wagę osoby ćwiczącej to w przypadku HS-2080, 100 kg. W urządzeniu zastosowano magnetyczny system hamowania. Całość waży niespełna 34 kg. </p><h3>Użytkowanie</h3><p>W rowerach treningowych standardem jest <b>pomiar pulsu</b>. Dzieje się to przez dotykowe sensory, które przekazują pomiary do komputera urządzenia. W niektórych modelach możemy znaleźć pas telemetryczny lub klips na ucho, których działanie jest podobne. Sercem każdego nowego roweru stacjonarnego jest komputer. Na jego ekranie wyświetlane są najważniejsze funkcje i wartości przebiegu naszego treningu, takie jak: czas, prędkość, pokonany dystans, spalone kalorie, czy wysokość pulsu. Bardziej zaawansowane rowery posiadają komputery, które oferują większy zestaw programów treningowych. Im więcej programów, tym większe możliwości aranżacji urozmaiconego i ciekawego treningu. </p><h3>Podsumowanie</h3><p>Rower treningowy Hop-Sport HS-2080 przeznaczony jest do ćwiczeń głównie w domu. Czytelny komputer z intuicyjną obsługą pozwala na łatwą kontrolę funkcji. Urządzenie polecane jest szczególnie osobom odchudzającym się. Pozwala na jednoczesne wzmocnienie i rzeźbienie dolnych partii ciała, poprawiając krążenie i dotleniając organizm. Zastanów się, czy właśnie to jest sprzęt do Twojego domu. </p>",
                    "description": "Prezentacja 3DZobacz produkt z każdej strony w najwyższej jakości.\n\nPrezentacja 3DZobacz produkt z każdej strony w najwyższej jakości.\nPrezentacja 3DZobacz produkt z każdej strony w najwyższej jakości.\n\n \n \nRower magnetyczny HS-2080 Spark\n\nSzukasz solidnego i funkcjonalnego rowerka stacjonarnego dla całej rodziny? Rower magnetyczny SPARK to idealny sprzęt dla wymagającego amatora.Prezentowany model roweru magnetycznego został zaprojektowany z myślą zarówno o użytkownikach, którzy stawiają na trening rekreacyjny, ale też o osobach, których celem jest wzmocnienie mięśni i spalenie tkanki tłuszczowej.Decydując się na ćwiczenia na tym rowerku zyskasz smukłą sylwetkę, lepsza kondycję, zaoszczędzisz czas i pieniądze wydane na siłowni.\n\nNajważniejsze zalety roweru magnetycznego Spark:\nPosiada wielofunkcyjny komputer, dzięki któremu można na bieżąco śledzić postępy treningu: czas ćwiczeń, przebyty dystans, spalone kalorie, prędkość, tętno.Czujniki pulsu (zlokalizowane na kierownicy) umożliwiają pomiar tętna, co jest ważne w przypadku treningu tlenowego nastawionego na spalanie tłuszczu.Regulowana kierownica pokryta pianką, regulowane siodełko wypełnione żelem oraz wzmocniona stalowa konstrukcja gwarantują nie tylko komfort, ale i bezpieczeństwo każdego treningu.8-stopniowa regulacja oporu, pozwalająca na wybór odpowiedniego obciążenia w zależności od formy użytkownika.Bardzo cicha praca sprzętu, którą zapewniają całkowicie osłonięte koło zamachowe oraz hamulce magnetyczne.Funkcjonalne rolki transportowe ułatwiające przemieszczanie rowerka.Tylne nóżki regulacyjne pozwalające łatwo wypoziomować sprzęt.Nowoczesny design.Antypoślizgowe pedały z paskami zabezpieczającymi.\n\nDodatkowe informacje techniczne:\nWymiary: 84  x 48 x 123 cm (dł./szer./wys.)Waga koła zamachowego: 5 kgWaga urządzenia: 23 kgMaksymalna waga osoby ćwiczącej: 120kgOdległość od pedała do siodełka w pozycji najwyższej: 78 cmŚrednica rur podstawy 60 mmŚrednica kolumny 50 mm\n \n\n \n \n\n \n\n\n\n\n\nOPIS PRODUKTU: \n\nZestaw hantli ze stojakiem BODY SCULPTURE to idealny komplet dla całej rodziny do aerobiku, ćwiczeń kulturystycznych, ćwiczeń usprawniających jak i różnych sztuk walki i rehabilitacji.\n\nNadają się do ćwiczenia w domu jak również w klubach fitness i siłowni.\n\nHantle wykonane są z masy betonowej pokrytej kolorowym winylem.\n\nPowłoka winylowa nadaje estetyczny wygląd oraz gwarantuje długą żywotność hantli.\n\nPosiadają podłużne żłobienia, dzięki którym hantle nie toczą się po podłożu.\n\nHantle przechowywane są na estetycznym, poręcznym stojaku, który ułatwia przechowywanie hantli w jednym miejscu.\n\nHantle można czyścić miękką zwilżoną szmatką z niewielka ilością mydła.\n\n \n\nDANE TECHNICZNE:\nW zestawie znajduja się:\n2 sztuki hantli o wadze 1,5 kg2 sztuki hantli o wadze 3 kg2 sztuki hantli o wadze 5 kgWaga zestawu 19 kg\n",
                    "photo_ids": [
                        "30d317d62d6059ff567ccf66d1cfc3c6",
                        "e3c7359c451ad4c7c0a3c5a7db5c423a",
                        "01ddb3f1cc93c1143b8ffa817851dad4",
                        "3b7275f26e4594b18f3689f018053fdb",
                        "66490478e171db35094afe66e582dd53",
                        "59437b292084fc2106d912f8600de73c",
                        "f9cdabb24e8c132de48f228b319083f2"
                    ],
                    "photo_id": "30d317d62d6059ff567ccf66d1cfc3c6",
                    "url": "rowery-treningowe/hop-sport-hs-2080",
                    "prices": {
                        "min": 494,
                        "max": 494
                    },
                    "shop": {
                        "id": 854,
                        "name": "Mall.pl",
                        "url_logo": "/s/854.jpg",
                        "high_quality": false
                    },
                    "category_id": 9162,
                    "click_url": null,
                    "block_adsense": false,
                    "movie": "youtube",
                    "rating": {
                        "rating": 3

                    }
                }');
    }
}