<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

class Employees extends REST_Controller
{
	public function index_get($id = NULL) {
		$this->db->select("*");
		$this->db->from("employees");
		$query = $this->db->get();        
		$employees = $query->result();

        if ($id === NULL)
        {
            if ($employees)
            {
                $this->response($employees, 200);
            }
            else
            {
                $this->response([
                    'status' => false,
                    'message' => 'No employees were found'
                ], 404);
            }
        }
        else
        {
            if (array_key_exists($id, $employees))
            {
                $this->response($employees[$id], 200);
            }
            else
            {
                $this->response([
                    'status' => false,
                    'message' => 'No such employee found'
                ], 404);
            }
        }
	}

	public function index_post() {
		$employee = [
			'first_name' => $this->post('first_name'),
			'last_name' => $this->post('last_name'),
			'position_name' => $this->post('position_name'),
			'email' => $this->post('email'),
			'telephone_number' => $this->post('telephone_number'),
			'address' => $this->post('address'),
		];

		if($employee){
			$result = $this->db->insert('employees',$employee);
			$last_inserted_id = $this->db->insert_id();

			if($result){
				$this->response([
					'message' => 'OK',
					'rows_inserted' => $last_inserted_id
                ], 200);
			}else{
				$this->response([
                    'status' => false,
                    'message' => 'KO'
                ], 404);
			}
		}
	}
}
