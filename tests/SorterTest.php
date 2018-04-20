<?php


use IG\Agregator;
use IG\ProviderFactory;

class SorterTest extends PHPUnit_Framework_TestCase {

     protected $JSON_LOADER;
     protected $XML_LOADER;
     protected $ARRAY_LOADER;

     const GROUP_TYPE_EUROPE = 'europe';
     const GROUP_TYPE_WORLD  = 'world';

     protected function setUp()
     {
         $this->ARRAY_LOADER = new \IG\loaders\ArrayLoader('data/data.php');
         $this->XML_LOADER = new \IG\loaders\FileLoader('data/data.xml');
         $this->JSON_LOADER = new \IG\loaders\FileLoader('data/data.json');

         parent::setUp();
     }

     public function testJsonLoaders() {
         $this->assertJson($this->JSON_LOADER->load());
     }

     public function testXMLLoaders() {
         $this->assertXmlStringEqualsXmlFile('data/data.xml', $this->XML_LOADER->load());
     }

     public function testARRAYLoaders() {
         $this->assertTrue(is_array($this->ARRAY_LOADER->load()));
     }

     public function testProviderFactory() {

         $provider_json = ProviderFactory::factory('json', $this->JSON_LOADER);

         $this->assertTrue($provider_json instanceof \IG\JsonDataProvider);

         $provider_xml = ProviderFactory::factory('xml', $this->XML_LOADER);

         $this->assertTrue($provider_xml instanceof \IG\XmlDataProvider);

         $provider_array = ProviderFactory::factory('array', $this->ARRAY_LOADER);

         $this->assertTrue($provider_array instanceof \IG\ArrayDataProvider);

     }

     public function testGroup() {

         $aggregator = new Agregator(
             ProviderFactory::factory('array', $this->ARRAY_LOADER),
             [
                 'group' => self::GROUP_TYPE_EUROPE
             ]
         );

         $this->assertArrayHasKey(self::GROUP_TYPE_EUROPE, $aggregator->execute());
         $this->assertArrayNotHasKey(self::GROUP_TYPE_WORLD, $aggregator->execute());

     }

     public function testSort() {

         $aggregator = new Agregator(
             ProviderFactory::factory('array', $this->ARRAY_LOADER),
             [
                 'group' => self::GROUP_TYPE_EUROPE,
                 'sort' => 'price',
                 'sort_type' => 'asc'
             ]
         );


         $this->assertEquals([
             'europe' => [
                 ['name' => 'zloty polski', 'code'=> 'PLN', 'price' => 1],
                 ['name' => 'frank szwajcarski', 'code' => 'CHF', 'price' => 3.36],
                 ['name' => 'euro', 'code' => 'EUR', 'price' => 4.15]
             ]
         ], $aggregator->execute());

     }

     public function testFilterNumberGreater() {

         $aggregator = new Agregator(
             ProviderFactory::factory('array', $this->ARRAY_LOADER),
             [
                 'group' => self::GROUP_TYPE_EUROPE,
                 'sort' => 'price',
                 'sort_type' => 'asc',
                 'filter' => 'price',
                 'filter_type' => '>',
                 'filter_value' => 4
             ]
         );

         $this->assertEquals([
             'europe' => [
                 ['name' => 'euro', 'code' => 'EUR', 'price' => 4.15]
             ]
         ], $aggregator->execute());

     }

    public function testFilterNumberLess() {

        $aggregator = new Agregator(
            ProviderFactory::factory('array', $this->ARRAY_LOADER),
            [
                'group' => self::GROUP_TYPE_EUROPE,
                'sort' => 'price',
                'sort_type' => 'asc',
                'filter' => 'price',
                'filter_type' => '<',
                'filter_value' => 2
            ]
        );

        $this->assertEquals([
            'europe' => [
                ['name' => 'zloty polski', 'code'=> 'PLN', 'price' => 1],
            ]
        ], $aggregator->execute());

    }


    public function testFilterStringLike() {

        $aggregator = new Agregator(
            ProviderFactory::factory('array', $this->ARRAY_LOADER),
            [
                'group' => self::GROUP_TYPE_EUROPE,
                'sort' => 'price',
                'sort_type' => 'asc',
                'filter' => 'code',
                'filter_type' => 'like',
                'filter_value' => 'H'
            ]
        );

        $this->assertEquals([
            'europe' => [
                ['name' => 'frank szwajcarski', 'code' => 'CHF', 'price' => 3.36],
            ]
        ], $aggregator->execute());

    }

 }