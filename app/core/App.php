<?php

class App{

	// porperti untuk class App
	protected $controller = 'Home';
	protected $method = 'index';

	// array kosong
	protected $params = [];

	public function __construct(){
		$url = $this->parseUrl();
		// var_dump($url);
		
		// controller
		// cek apakah ada file yang ada sesuai dengan url
		if(file_exists('../app/controllers/' . $url[0] . '.php')){
			$this->controller = $url[0];
			// var_dump($url);
			unset($url[0]);
			// var_dump($url);
		}

		require_once '../app/controllers/' . $this->controller . '.php';
		$this->controller = new $this->controller;

		// method
		if(isset($url[1])){
			if(method_exists($this->controller, $url[1])){
				$this->method = $url[1];
				unset($url[1]);
			}
		}

		// params
		if(!empty($url)){
			// var_dump($url);
			$this->params = array_values($url);
		}

		// jalankan controller dan methods
		// serta kirimkan params jika ada
		
		call_user_func_array([$this->controller, $this->method], $this->params);
	}

	public function parseUrl(){
		if(isset($_GET['url'])){
			// memebrsihkan url dari karakter terakhir "/"
			$url = rtrim($_GET['url'], '/');

			// mmebersihkan url dari karakter aneh 
			// agar tidak mudah di hack
			$url = filter_var($url, FILTER_SANITIZE_URL);

			// memecah url berdasarkan tanda "/"
			$url = explode('/' , $url);
			return $url;
		}
	}
}


?>