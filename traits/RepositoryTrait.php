<?php

  namespace Application\traits;


  trait RepositoryTrait {

      protected $_RepositoryData = [];

      /**
       * @param $key
       * @return null|mixed
       */
      public function __get($key)  {
          if(isset($this->_RepositoryData[$key])) {
            return $this->_RepositoryData[$key];
          } else {
              return null;
          }
      }

      /**
       * @param $key
       * @param $value
       */
      public function __set($key, $value): void {
          $this->_RepositoryData[$key] = $value;
      }

  }