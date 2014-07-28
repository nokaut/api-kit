<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 24.07.2014
 * Time: 13:57
 */

namespace Nokaut\ApiKit\Repository;


interface AsyncRepositoryInterface {

    public function clearAllFetches();
    public function fetchAllAsync();
}