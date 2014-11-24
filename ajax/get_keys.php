<?php
if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])
	&& ! empty($_SERVER['HTTP_X_REQUESTED_WITH'])
	&& strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
{
	header('Content-Type: application/json');

	$response = array(
		'success' => FALSE,
	);

	if ( ! class_exists('\Redis'))
	{
		$response['error'] = 'The Redis PHP extention is required!';
		echo json_encode($response);
		exit;
	}

	$redis_pattern = $_POST['pattern'];
	$redis = new \Redis();
	$redis->pconnect('localhost');
	$response['result'] = $redis->keys("*{$redis_pattern}*");

	$response['success'] = TRUE;
	echo json_encode($response);
	exit;
}