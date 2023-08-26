<?php

use GuzzleHttp\Client;
use Solarium\Core\Client\Client as SolariumClient;
use Solarium\Core\Client\Adapter\Curl as CurlAdapter;
use Symfony\Component\EventDispatcher\EventDispatcher;

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

    public function getData(array $solrConfig)
    {
        $adapter = new CurlAdapter();
        $eventDispatcher = new EventDispatcher();
        $client = new SolariumClient($adapter, $eventDispatcher, $solrConfig);
        $query = $client->createSelect();
        //$query->setQuery('name:test'); - To perform search
        $resultset = $client->select($query);
        echo 'NumFound: ' . $resultset->getNumFound() . PHP_EOL;


        foreach ($resultset as $document) {
            echo '<hr/><table>';
            // the documents are also iterable, to get all fields
            foreach ($document as $field => $value) {
                // this converts multivalue fields to a comma-separated string
                if (is_array($value)) $value = implode(', ', $value);
                echo '<tr><th>' . $field . '</th><td>' . $value . '</td></tr>';
            }
            echo '</table>';
        }
        $file = file_get_contents($this->apiUrl . $this->collection . '/select?q=*:*');
        print_r($file);
    }

    // public function getData()
    // {
    //     $ch = curl_init();
    //     curl_setopt($ch, CURLOPT_URL, $this->apiUrl . $this->collection . '/select?q=*:*');
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     curl_setopt($ch, CURLOPT_HTTPGET, true);
    //     $result = curl_exec($ch);
    //     if (curl_errno($ch)) {
    //         return 'Error cURL: ' . curl_error($ch);
    //     }
    //     curl_close($ch);
    //     return $result;
    // }
}
