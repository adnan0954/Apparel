<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

//define("FBKEY", "1234567890123456");
//define("FBIV",  "1234567890123456");

//VIEWS
function Head($param)
{
	$data['CSS'] = $param;
	$CI = & get_instance();
	$CI->load->view('common/head', $data);
}

function GetHeader()
{
	$data['IsLogged'] = IsLoggedIn();
	$CI = & get_instance();
	$CI->load->view('common/header', $data);
}

function GetBlogHeader()
{
	$CI = & get_instance();
	$CI->load->view('common/headerblog');
}

function Foot($param)
{
	$data['JS'] = $param;
	$CI = & get_instance();
	$CI->load->view('common/foot', $data);
}

function Footer()
{
	$CI = & get_instance();
	$CI->load->view('common/footer');
}



//ENDVIEWS



//USER
function IsLoggedIn()
{
	//return TRUE;
	$CI = & get_instance();
	if($CI->session->userdata('loggedin')){
		return TRUE;
	}else return FALSE;
}

function Email()
{
	$CI = & get_instance();
	return $CI->session->userdata('email');
}

function FirstName()
{
	$CI = & get_instance();
	return $CI->session->userdata('firstname');
}

function LastName()
{
	$CI = & get_instance();
	return $CI->session->userdata('lastname');
}

function IsVerified()
{
	$CI = & get_instance();
	return $CI->session->userdata('verified');
}

function IsPremium()
{
	$CI = & get_instance();
	return $CI->session->userdata('ispremium');
}

function GetHash()
{
	$hash = substr(hash('ripemd256', Email()), 5, -5).substr(hash('sha256', microtime()), 5, -5);
	$CI = & get_instance();
	$CI->session->set_flashdata('fbtk', $hash);
	return $hash;
}

//END USER




//UTILITY

function Clean($var)
{
	return htmlspecialchars(stripslashes($var));
}

function time_elapsed_string($ptime)
{
	$etime = time() - $ptime;

	if ($etime < 1)
	{
		return '0 seconds';
	}

	$a = array( 12 * 30 * 24 * 60 * 60  =>  'year',
		30 * 24 * 60 * 60       =>  'month',
		24 * 60 * 60            =>  'day',
		60 * 60                 =>  'hour',
		60                      =>  'minute',
		1                       =>  'second'
		);

	foreach ($a as $secs => $str)
	{
		$d = $etime / $secs;
		if ($d >= 1)
		{
			$r = round($d);
			return $r . ' ' . $str . ($r > 1 ? 's' : '') . ' ago';
		}
	}
}

function ENCRYPTME($plain)
{
	$blockSize = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
	$pad = $blockSize - (strlen($plain) % $blockSize);
	
	return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_128 , FBKEY, $plain . str_repeat(chr($pad), $pad), MCRYPT_MODE_CBC, FBIV));
}
// END UTILITY

//LOGS
function LogAccess($status = '0x801')
{
	$CI = & get_instance();
	$data = array(
		'email' => Email(),
		'source' => 'WEB',
		'status' => $status,
		'ip' => $_SERVER['REMOTE_ADDR'],
		'datecreated' => date('Y-m-d H:i:s'),
		'useragent' => $_SERVER['HTTP_USER_AGENT']
		);

	$CI->db->insert('log_access', $data);
}

function LogActivity($status, $message = "")
{
	$CI = & get_instance();
	$data = array(
		'email' => Email(),
		'source' => 'WEB',
		'status' => $status,
		'ip' => $_SERVER['REMOTE_ADDR'],
		'datecreated' => date('Y-m-d H:i:s'),
		'useragent' => $_SERVER['HTTP_USER_AGENT'],
		'message' => $message
		);

	$CI->db->insert('log_activity', $data);
}

function LogAttempt()
{
	$CI = & get_instance();
	$data = array(
		'email' => strtolower($CI->input->post('Email')),
		'source' => 'WEB',
		'status' => '0x909',
		'ip' => $_SERVER['REMOTE_ADDR'],
		'datecreated' => date('Y-m-d H:i:s'),
		'useragent' => $_SERVER['HTTP_USER_AGENT']
		);

	$CI->db->insert('log_attempt', $data);
}

function LogError($message, $status = "0x903")
{
	$CI = & get_instance();
	$data = array(
		'email' => strtolower($to),
		'source' => 'WEB',
		'status' => $status,
		'message' => $message,
		'ip' => $_SERVER['REMOTE_ADDR'],
		'datecreated' => date('Y-m-d H:i:s')
		);

	$CI->db->insert('log_error', $data);
}

//END LOGS