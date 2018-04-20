<?php

   namespace IG;

   use IG\interfaces\DataProviderInterface;
   use IG\exceptions\InvalidDataException;
   use IG\interfaces\LoaderInterface;

   class ProviderFactory {

       const TYPE_ARRAY = 'array';
       const TYPE_JSON  = 'json';
       const TYPE_XML   = 'xml';

       public static function factory($type, LoaderInterface $loader): DataProviderInterface {

            if($type == self::TYPE_JSON) {
                return new JsonDataProvider($loader);
            }

            if($type == self::TYPE_XML) {
                return new XmlDataProvider($loader);
            }

           if($type == self::TYPE_ARRAY) {
               return new ArrayDataProvider($loader);
           }

           throw new InvalidDataException('Type not found');

       }

   }