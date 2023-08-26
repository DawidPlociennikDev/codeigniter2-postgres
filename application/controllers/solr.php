<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

define("VIEW_DIR", "front/");

class Solr extends CI_Controller
{

    public function __construct() {
        parent::__construct();
		$this->load->library('solr_service');
        $this->config->load('solarium');
    }

	public function index()
	{
        $solrConfig = $this->config->item('solarium_endpoint');
        $test = $this->solr_service->getData($solrConfig);
		$this->load->view(VIEW_DIR.'service.php');
        print_r($test);
	}
}