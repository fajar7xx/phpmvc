<?php

class App{

	// property uuntuk kelas app
	// controller dengan nilai default
	protected $controller = 'Home';

	// method dengan nilai ddefaulkt
	protected $method = 'index';

	// paramater dengan array karena akan lebih dari satu
	protected $params = [];

	public function __construct(){
		// var_dump($_GET);
		$url = $this->parseUrl();
		// var_dump($url);
		
		// controlle
		// cek apakah file tersebut terdapat
		// dalam controller
		// status file ini berada di index.php
		if(file_exists('../app/controllers/' . ucfirst($url[0]) . '.php')){
			// jika ada kita timpa contreoller default 
			// dengan controller yang baru
			$this->controller = $url[0];
			unset($url[0]);
			// var_dump($url);
			// kita hilangkan controller dari elemen array
			
			// panggil controllernyya
			require_once '../app/controllers/' . ucfirst($this->controller) . '.php';
			// kita instansiasi classnya
			// agar ktia dapat memanggil methodnya
			$this->controller = new $this->controller;


			// method
			// kalau kosong pakai method default
			// kalau ada kita cek dulu methodnya 
			// apakah ada di dalam controller atau tidak
			if(isset($url[1])){
				if(method_exists($this->controller, $url[1])){
					// kalau ada kita timpa method defaultnya
					$this->method = $url[1];
					unset($url[1]);
				}
			}

			// kelola paramater
			if(!empty($url)){
				// var_dump($url);
				// masukkan ke property parameter
				$this->params = array_values($url);
			}

			// jalankan controller dan method
			// serta kirimkan params jika ada
			call_user_func_array([$this->controller, $this->method], $this->params);
		}
	}
	
	// method membaut url untuk memecah url sesuai keingainan
	public function parseUrl(){
		if(isset($_GET['url'])){

			 // membersihkan karakter "/" pada string 
			 // sehingga hanya stringnya saja yang di ambil
			 // dengan rtrim
			$url = rtrim($_GET['url'], '/');

			// membersihkan url dari karakter
			// biar tidak mudah d hack
			$url = filter_var($url, FILTER_SANITIZE_URL);

			// pecah urlnya dengan tanda "/"
			$url = explode('/', $url);
			return $url;
		}
	}
}


?>