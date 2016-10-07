<?php

namespace App\Controllers;

class ApiController extends Controller
{
	private $command_list = [
		"fac" => [
			"name" => "Expressões",
			"commands" => [
				"10" => 'Rosto Feliz',
				"20" => 'Rosto Feliz 2'
			]
		],

		"mov" => [
			"name" => "Braços",
			"commands" => [
				"10" => 'Levantar braço Esquerdo',
				"20" => 'Levantar braço Direito'
			]
		],
	];


	public function index($request, $response, $args)
	{
		$data = $request->getQueryParams();

		$this->response_type = (isset($data['type'])) ? $data['type'] : "html";
		$param = $this->checkCommand($data);

		if ( $param["param"] ) {

			return $this->response($request, $response, $param);
		}

		//echo "<pre>";
		//echo $this->response_type;
		//print_r($param);
		//die();

		$this->ci->renderer->render($response, "index.phtml", [
			"command_list"=>$this->command_list,
			"request"=>$request
		]);
	}

	private function checkCommand($data)
	{
		$command = null;
		$param = null;

		if ( isset($data['fac']) ) {
			$param = "fac";
			$command = $data['fac'];
		}

		if ( isset($data['mov']) ) {
			$param = "mov";
			$command = $data['mov'];
		}

		return ["param" =>$param, "command"=>$command];
	}




	public function commandList($request, $response, $args)
	{
		$this->response_type = (isset($args['type'])) ? $args['type'] : "json";

		$this->response($request, $response, $args, $this->command_list);
	}


	public function command($request, $response, $args)
	{
		$this->response_type = (isset($args['type'])) ? $args['type'] : "json";
		$command = (isset($args['command'])) ? $args['command'] : "";

		$this->response($request, $response, $this->command_list[$command]);
	}
}