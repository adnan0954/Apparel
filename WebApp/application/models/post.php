<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Post extends CI_Model 
{
	public function SendPost()
	{

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