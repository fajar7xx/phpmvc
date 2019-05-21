<?php

class App{

	public function __construct(){
		$url = $this->parseUrl();
		var_dump($url);
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