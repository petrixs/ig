<?php

   namespace IG;

   use IG\interfaces\DataProviderInterface;
   use IG\exceptions\InvalidDataException;

   class ProviderFactory {

       const TYPE_ARRAY = 'array';
       const TYPE_JSON  = 'json';
       const TYPE_XML   = 'xml';

       public static function factory($type): DataProviderInterface {

            if($type == self::TYPE_JSON) {
                return new JsonDataProvider();
            }

            if($type == self::TYPE_XML) {
                return new XmlDataProvider();
            }

           if($type == self::TYPE_ARRAY) {
               return new ArrayDataProvider();
           }

           throw new InvalidDataException('Type not found');

       }

   }