<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Solr extends CI_Controller
{
    public function __construct() {
        parent::__construct();
    }

	public function index()
	{
        $options = [];
        $client = new Solarium\Client($options);
        $query = $client->createSelect();
        // to do how it works??
        // $query->setQuery('your_search_query_here');
        // $resultset = $client->select($query);
        // foreach ($resultset as $document) {
        //     echo '<p>' . $document->title . '</p>';
        // }
	}
}