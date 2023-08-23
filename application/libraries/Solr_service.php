<?php

use GuzzleHttp\Client;

class Solr_service
{
    protected $ci;
    protected $httpClient;
    private $apiUrl;
    private $collection;

    public function __construct()
    {
        $this->ci = &get_instance();
        $this->httpClient = new Client();
        $this->apiUrl = 'http://localhost:8983/solr/';
        $this->collection = 'search_twitter';
    }

    public function getData()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->apiUrl . $this->collection . '/select?q=*:*');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPGET, true);
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            return 'Error cURL: ' . curl_error($ch);
        }
        curl_close($ch);
        return $result;
    }
}
