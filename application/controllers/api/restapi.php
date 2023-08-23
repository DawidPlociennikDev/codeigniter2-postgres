<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class RestApi extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('api_response');
		$this->authenticate();
		$this->load->model('api_model');
	}

	public function get()
	{
		$perPage = $this->input->get('per_page') > 0 ? $this->input->get('per_page') : 10;
		$page = $this->input->get('page') ?? 0;
		$allResults = $this->api_model->getComments();
		$totalRows = count($allResults);
		$config['base_url'] = '/api/get';
		$config['total_rows'] = $allResults;
		$config['per_page'] = $perPage;

		$this->pagination->initialize($config);

		$result = $this->db->get('comments', $perPage, $page)->result();

		$response = [
			'data' => $result,
			'pagination' => [
				'current_page' => $page,
				'per_page' => $perPage,
				'total_rows' => $totalRows,
				'total_pages' => ceil($totalRows / $perPage),
			]
		];

		if ($result) {
			$this->api_response->send($response);
		} else {
			$this->api_response->error('Resource not found', 404);
		}
	}

	public function getById(int $commentId)
	{
		if (empty($commentId)) {
			return $this->api_response->error('Data missing', 400);
		}

		$existingRecord = $this->api_model->checkExist($commentId);
		if (!$existingRecord) {
			return $this->api_response->error('Record not found', 404);
		} else {
			$response = array('data' => $existingRecord);
			return $this->api_response->send($response);
		}
	}

	public function put(int $commentId)
	{
		$putData = json_decode(file_get_contents('php://input'), true);
		if (empty($putData)) {
			return $this->api_response->error('Data missing', 400);
		}

		$existingRecord = $this->api_model->checkExist($commentId);
		if (!$existingRecord) {
			return $this->api_response->error('Record not found', 404);
		}

		if ($this->api_model->putComment($commentId, $putData)) {
			$response = array('message' => 'Resource updated successfully');
			return $this->api_response->send($response);
		}
		return $this->api_response->error('Something goes wrong', 500);
	}

	public function patch(int $commentId)
	{
		$patchData = file_get_contents('php://input');
		if (empty($patchData)) {
			return $this->api_response->error('Data missing', 400);
		}

		$existingRecord = $this->api_model->checkExist($commentId);
		if (!$existingRecord) {
			return $this->api_response->error('Record not found', 404);
		}

		$arrayPatchData = json_decode($patchData, true);

		if ($this->api_model->patchComment($commentId, $arrayPatchData)) {
			$response = array('message' => 'Resource updated successfully');
			return $this->api_response->send($response);
		}
		return $this->api_response->error('Something goes wrong', 500);
	}

	public function post()
	{
		$postData = $this->input->post();
		
		if (empty($postData)) {
			return $this->api_response->error('Data missing', 400);
		}

		$query = @$this->api_model->createComment($postData);
		if ($query) {
			$response = array('message' => 'Resource created successfully', 'id' => $query);
			return $this->api_response->send($response);
		}
		return $this->api_response->error('Something goes wrong', 500);
	}

	public function delete(int $commentId)
	{
		if ($this->api_model->deleteComment($commentId)) {
			$response = array('message' => 'Resource deleted successfully');
			return $this->api_response->send($response);
		}
		return $this->api_response->error('Something goes wrong', 500);
	}

	private function authenticate()
	{
		$token = $this->input->get_request_header('Authorization');
		if (!$token || $token != BEARER_TOKEN) {
            $this->output->set_status_header(401);
            echo json_encode(array('message' => 'Unauthorized'));
            exit;
		}
	}
}
