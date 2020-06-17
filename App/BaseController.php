<?php

namespace App;

use Ez\Database as DB;
use Ez\View;
use Ez\Request;


class BaseController
{

	protected $breadcrumb = [];
	protected $level = [
		1 => 'admin',
		2 => 'user'
	];


	public function __construct()
	{

		$this->auth();

		$this->activPage('home');
		
		$this->breadcrumb([
			'' => 'Halaman Awal'
		], config('app.appname'));

	}

	protected function activPage($page)
	{

		View::share(compact('page'));
	}

	protected function breadcrumb($breadcrumb, $pagename = false)
	{
		

		$this->breadcrumb = array_merge($this->breadcrumb, $breadcrumb);

		$share = ['breadcrumb' => $this->breadcrumb];

		if ($pagename != false) {
			$share['pagename'] = $pagename;
		}

		View::share($share);
	}

	protected function auth($level = false)
	{

		if (is_null(session('userid'))) {
			
			redirect('app/auth/register');
		
		} else {


			if (false != $level and in_array($level, ['admin', 'user'])) {

				$level = $level == 'admin' ? 1 : 2;

				$pengguna = (new DB)->table('pengguna')
					->where('id', session('userid'))
					->where('level', $level)
					->select()
					->one();

			} else {

				$pengguna = (new DB)->table('pengguna')
					->where('id', session('userid'))
					->select()
					->one();
			}

			if (false == $pengguna) {
				redirect('app/auth/login');
			}


			$pengguna['level'] =
				isset($this->level[$pengguna['level']]) ?
				$this->level[$pengguna['level']] :
				null;

			session('pengguna', $pengguna);
		}
	}

	public function getIndex()
	{

		View::render('App.view.home.index');
	}

	public function ajaxPostUpdateProfil()
	{

		$rules = [
			'nama' => 'string|required|max:225',
			'email' => 'string|required|max:100',
			'notelepon' => 'string|required|max:15',
		];

		if (Request::data('password')) {

			$rules['password'] = 'string|required|min:6|max:50';
			$rules['re_password'] =
				'string|required|confirmation:password|min:6|max:50';
		}

		$post = postRules($rules);

		if(isset($post['errors'])){
			
			return [
				'status' => 'error',
				'errors' => $post['errors']
			];
		}

		$update = [
			'nama' => $post['data']['nama'],
			'email' => $post['data']['email'],
			'notelepon' => $post['data']['notelepon']
		];


		if ($post['data']['password']) {
			$update['password'] = md5($post['data']['password']);
		}

		$pengguna_update = (new DB)
			->table('pengguna')
			->update($update)
			->where('id', session('userid'));

		if ($pengguna_update->run()) {

			return [
				'status' => 'success',
				'flash' => 'Profil anda berhasil diperbarui',
				'redirect' => url()
			];

		} else {

			return [
				'status' => 'error',
				'flash' => 'Profil anda gagal diperbarui',
				'error_fields' => [
					'nama',
					'email',
					'notelepon',
					'password'
				]
			];
		}
	}

	public function ajaxPostUpdateAplikasi()
	{

		$this->auth('admin');
		$post = postRules([
			'appname' => 'required|string|max:50',
			'appfullname' => 'required|string|max:100',
			'appinfo' => 'required|string|max:100',
			'appdesc' => 'required|string|max:100',
			'developer' => 'required|string|max:100'
		]);

		if(isset($post['errors'])){
			
			return [
				'status' => 'error',
				'errors' => $post['errors']
			];
		}

		$pengaturan_update = (new DB)
			->table('pengaturan')
			->update([
				'appname' => $post['data']['appname'],
				'appfullname' => $post['data']['appfullname'],
				'appinfo' => $post['data']['appinfo'],
				'appdesc' => $post['data']['appdesc'],
				'developer' => $post['data']['developer']
			]);

		if ($pengaturan_update->run()) {

			return [
				'status' => 'success',
				'flash' => 'Aplikasi berhasil diperbarui',
				'redirect' => url()
			];

		} else {

			return [
				'status' => 'error',
				'flash' => 'Aplikasi gagal diperbarui',
				'error_fields' => [
					'appname',
					'appfullname',
					'appinfo',
					'appdesc',
					'developer'
				]
			];
		}
	}

	public function ajaxGetReadLogo()
	{
		$file_list = [];

		$uploaddir = baseDir('assets/img/logo');
		$uploadurl = url('assets/img/logo');

		if (is_dir($uploaddir)){

			if ($dh = opendir($uploaddir)){

				while (($file = readdir($dh)) !== false){

					if($file != '' and
						$file != '.' and
						$file != '..' and
						$file != 'default.png'){

						$file_path = $uploaddir . '/' . $file;

						if(!is_dir($file_path)){

							$size = filesize($file_path);

							$file_list[] = [
								'name' => $file,
								'size' => $size,
								'url' => $uploadurl . '/' . $file
							];

						}
					}

				}

				closedir($dh);
			}
		}

		return $file_list;
	}

	public function ajaxPostUploadLogo()
	{

		$logo = Request::file('logo');
		if (!$logo->tmp_name) {
			$max_size = ini_get('upload_max_filesize');
			
			die('oversize');
		}

		$uploaddir = baseDir('assets/img/logo');

		if (!is_dir($uploaddir)) {
			mkdir( $uploaddir, 0777, true);
		}

		$uploaded = $uploaddir . '/' . $logo->name;

		if (!file_exists($uploaded)) {
		
			if (move_uploaded_file($logo->tmp_name, $uploaded)) {

				$typeallowed = [
					'image/jpeg',
					'image/png'
				];

				if (!in_array(mime_content_type($uploaded), $typeallowed)) {
					unlink($uploaded);
					die('notallowed');
				}

				foreach( scandir($uploaddir)  as $old_logo) {
				 	
				 	if (!in_array($old_logo, [
				 		$logo->name,
				 		'.',
				 		'..',
				 		'default.png'
				 	])) {

				 		unlink($uploaddir . '/' . $old_logo);
				 	}
				}

				die('uploaded');
			}
		
		} else {

			die('alreadyuploaded');
		}

		die('error');
	}

	public function ajaxPostDeleteLogo()
	{

		$filename = Request::data('name');

		if ($filename) {
		
			$uploaded = baseDir("assets/img/logo/$filename");

			if (file_exists($uploaded)) {
			
				if (unlink($uploaded)) {
					die('deleted');
				}
			}
		}
	}

	public function getDownloadLogo()
	{

		$filename = Request::query('file');
		$uploaded = baseDir("assets/img/logo/$filename");

		if (file_exists($uploaded)) {
		  	
		  	header($_SERVER['SERVER_PROTOCOL'] . ' 200 OK');
            header('cache-control: public');
            header('content-type: ' . mime_content_type($uploaded));
            header('content-transfer-encoding: binary');
            header('content-length:' . filesize($uploaded));
            header("content-disposition: attachment; filename=$filename");
            readfile($uploaded);
            exit();
		}
	}
}