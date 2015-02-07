<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PostModel extends CI_Model 
{
	private function UploadImage($image)
	{
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '100';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';
		$config['file_name']  = $image;
		$config['overwrite']  = 'TRUE';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('Image'))
		{
			$error = array('error' => $this->upload->display_errors());
			print_r($error);
			//$this->load->view('upload_form', $error);
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());
			echo '<h1>Success!</h1>';
			print_r($data);
			return $image.$data['upload_data']['file_ext'];
			//$this->load->view('upload_success', $data);
		}
	}

	public function SendPost()
	{
		$data = array('caption' => $this->input->post('Caption'),
					  'tags'=> $this->input->post('Tags'),
					  'datecreated' => date('Y-m-d H:i:s'),
					  'useragent' => $_SERVER['HTTP_USER_AGENT'],
					  'handle' => Handle()
			);

		$temp_id = Handle().substr(Name(), 0, 2);
		$data['ID'] = strtoupper($temp_id.'-'.substr(uniqid(), -4).'-'.substr(md5(microtime()), -4));
		$data['Image'] = $this->UploadImage($data['ID']);
		if($this->db->insert('post', $data))
		{
			return TRUE;
		}
		else return FALSE;
	}

	public function GetTimelineByUser($limit)
	{
		$posts = array();
		$email = Email();
		$query = $this->db->query("SELECT * FROM posts WHERE email in ( SELECT follower from follow WHERE email = '$email')");
		
		if($query->num_rows() != 0)
		{
			foreach ($query->result_array() as $row)
			{
			   array_push($posts, $row);
			}

			return json_encode($posts);
		}

		return FALSE;
	}
}