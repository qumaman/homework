<?php namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;

class UploadController extends Controller {

	public function upload(){

		if(Input::hasFile('file')){

			echo 'Файл загружен <br>';
			$file = Input::file('file');
			$file->move('uploads/avatars', $file->getClientOriginalName());
            echo '<img src="uploads/avatars/' . $file->getClientOriginalName() . '">';
            echo '<br> <a href="/home">Вернутся назад </a> ';
		}

	}
}
