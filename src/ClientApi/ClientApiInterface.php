<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 04.07.2014
 * Time: 08:52
 */

namespace Nokaut\ApiKit\ClientApi;


use Nokaut\ApiKit\ClientApi\Rest\Fetch\Fetch;
use Nokaut\ApiKit\ClientApi\Rest\Fetch\Fetches;

interface ClientApiInterface {

    /**
     * @param Fetch $fetch
     */
    public function send(Fetch $fetch);

    /**
     * @param Fetches $fetches
     */
    public function sendMulti(Fetches $fetches);

}