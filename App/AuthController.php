<?php

namespace App;

use Ez\Database as DB;
use Ez\View;


class AuthController
{
	public function getLogin()
	{
		sessionDestroy();
	
		View::render('App.view.auth.login', [
			'layout' => 'App.view.layout.auth'
		]);
	}

	public function getRegister()
	{
		sessionDestroy();

		View::render('App.view.auth.register', [
			'layout' => 'App.view.layout.auth'
		]);
	}

	public function ajaxPostLogin()
	{

		$post = postRules([
			'username' => 'string|required|min:5|max:16',
			'password' => 'string|required|min:6|max:50'
		]);

		if(isset($post['errors'])){
			
			return [
				'status' => 'error',
				'errors' => $post['errors']
			];
		}

		$pengguna = (new DB)->table('pengguna')->select()->where([
			'username' => $post['data']['username'],
			'password' => md5($post['data']['password'])
		])->one();


		if (false == $pengguna) {
			return [
				'status' => 'error',
				'flash' => 'username dan password tidak cocok',
				'reset_fields' => [
					'password'
				],
				'error_fields' => [
					'username',
					'password'
				]
			];
		}

		session('userid', $pengguna['id']);
		session('usertoken', generateToken());
		
		return [
			'status' => 'success',
			'flash' => 'Selamat datang kembali ' . $pengguna['nama'],
			'redirect' => url(),
			'reset_fields' => [
				'password'
			]
		];
	}

	public function ajaxPostRegister()
	{

		$post = postRules([
			'username' => 'string|required|min:5|max:16|uniq:username,pengguna',
			'nama' => 'string|required|max:225',
			'email' => 'string|required|max:100|uniq:email,pengguna',
			'notelepon' => 'string|required|max:15',
			'password' => 'string|required|min:6|max:50',
			're_password' =>
				'string|required|confirmation:password|min:6|max:50'
		]);


		if(isset($post['errors'])){
			
			return [
				'status' => 'error',
				'errors' => $post['errors']
			];
		}

		$pengguna_insert = (new DB)->table('pengguna')->insert([
			'username' => $post['data']['username'],
			'nama' => $post['data']['nama'],
			'email' => $post['data']['email'],
			'notelepon' => $post['data']['notelepon'],
			'level' => 2,
			'password' => md5($post['data']['password'])
		]);

		if ($id_pengguna = $pengguna_insert->lastInsertId()) {

			session('userid', $id_pengguna);
			session('usertoken', generateToken());
		

			$pengguna = (new DB)->table('pengguna')
				->select('nama')
				->where('id', $id_pengguna)
				->one();

			return [
				'status' => 'success',
				'flash' => 'Selamat datang ' . $pengguna['nama'],
				'redirect' => url(),
				'reset_fields' => [
					'password',
					're_password'
				]
			];

		} else {

			return [
				'status' => 'error',
				'flash' => 'Register gagal, silahkan hubungi administrator',
				'reset_fields' => [
					'password',
					're_password'
				],
				'error_fields' => [
					'username',
					'nama',
					'email',
					'notelepon',
					'password',
					're_password'
				]
			];
		}
	}

	public function getLogout()
	{

		redirect('app/auth/login');
	}
}