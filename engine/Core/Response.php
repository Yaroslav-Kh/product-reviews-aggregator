<?php


namespace Engine\Core;


class Response
{

	public static function json($json) {
		header('Content-Type: application/json');
		return json_encode($json);
	}

}