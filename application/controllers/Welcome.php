<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	public function index() {
		$this->load->view('welcome_message');
	}

	public function submitForm() {
		$this->load->model('Task_model');
		$this->load->library('upload');
		$this->load->library('session');
		$config['upload_path'] = FCPATH . 'uploads/';
		$config['allowed_types'] = 'jpeg|jpg|png';
		$config['encrypt_name'] = TRUE;
		$this->upload->initialize($config);
		$fileName = '';
		if (!$this->upload->do_upload('image_link')) {
			$error = array('error' => $this->upload->display_errors());
			echo json_encode(array(
				'status' => 501
			));
		} else {
			$image_metadata = $this->upload->data();
			$fileName = $image_metadata['file_name'];
			$result = $this->Task_model->addData(array(
				'name' => $this->input->post('name'),
				'phone' => $this->input->post('phone'),
				'email' => $this->input->post('email'),
				'image_link' => $fileName,
				'added_on' => time()
			));
			$this->db->error();
			if ($result) {
				echo json_encode(array(
					'status' => 200
				));
			} else {
				echo json_encode(array(
					'status' => 500
				));
			}
		}
	}

	public function refresh() {
		$this->load->model('Task_model');
		$data['table'] = '';
		$i = 0;
		foreach ($this->Task_model->getData() as $key) {
			$data['table'] .= '
				<tr>
					<td>' . ++$i . '</td>
					<td>' . $key->name . '</td>
					<td>' . $key->email . '</td>
					<td>' . $key->phone . '</td>
					<td><img src="' . base_url('uploads/' . $key->image_link) . '" alt="image" height="50" width="50" /></td>
				</tr>
			';
		}
		echo json_encode($data);
	}
}
