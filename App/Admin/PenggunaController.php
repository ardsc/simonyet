<?php

namespace App\Admin;

use Ez\View;
use Ez\Request;
use Ez\Database as DB;
use App\BaseController;

class PenggunaController extends BaseController
{

	protected $pagename = 'Pengguna';
	public function __construct()
	{

		parent::__construct();
		
		$this->auth('admin');

		$this->breadcrumb([
			'app/admin/pengguna/index' => $this->pagename
		]);

		$this->activPage('pengguna');
	}

	public function getIndex()
	{

		$pengguna = (new DB)->table('pengguna')->select(
			'id',
			'username',
			'nama',
			'email',
			'notelepon',
			'level'
		)->get();

		View::render('App.Admin.view.pengguna.index', [
			'pengguna' => $pengguna,
			'level' => $this->level
		]);
	}

	public function getDestroy()
	{
		$pengguna_destroy = (new DB)
			->table('pengguna')
			->where('id', Request::query('id'))
			->delete()
			->run();

		redirect('app/admin/pengguna/index');
	}

	public function getCreate()
	{

		$this->breadcrumb([
			'app/admin/pengguna/create' => 'Tambah',
		], $this->pagename);

		View::render('App.Admin.view.pengguna.create', [
			'level' => $this->level
		]);
	}


	public function getEdit()
	{
		$id = Request::query('id');
		
		$this->breadcrumb([
			'app/admin/pengguna/edit?id=' . $id => 'Ubah',
		], $this->pagename);

		$pengguna = (new DB)->table('pengguna')->select(
			'id',
			'username',
			'nama',
			'email',
			'notelepon',
			'level'
		)->where('id', $id)->one();

		View::render('App.Admin.view.pengguna.edit', [
			'pengguna' => $pengguna,
			'level' => $this->level
		]);
	}

	public function ajaxPostStore()
	{

		$post = postRules([
			'username' => 'string|required|min:5|max:16|uniq:username,pengguna',
			'level' => 'numeric|in:1,2',
			'nama' => 'string|required|max:225',
			'email' => 'string|required|max:100|uniq:email,pengguna',
			'notelepon' => 'string|required|max:15',
			'password' => 'string|required|min:6|max:50'
		]);

		if(isset($post['errors'])){
			
			return [
				'status' => 'error',
				'errors' => $post['errors']
			];
		}
		$pengguna_insert = (new DB)->table('pengguna')->insert([
			'username' => $post['data']['username'],
			'level' => $post['data']['level'],
			'nama' => $post['data']['nama'],
			'email' => $post['data']['email'],
			'notelepon' => $post['data']['notelepon'],
			'password' => md5($post['data']['password'])
		]);

		if ($pengguna_insert->run()) {

			return [
				'status' => 'success',
				'flash' => 'Data berhasil disimpan',
				'redirect' => url('app/admin/pengguna/index'),
				'reset_fields' => [
					'username',
					'nama',
					'email',
					'notelepon',
					'password'
				]
			];

		} else {

			return [
				'status' => 'error',
				'flash' => 'Data gagal disimpan',
				'error_fields' => [
					'username',
					'nama',
					'email',
					'notelepon',
					'password'
				]
			];
		}
	}


	public function ajaxPostUpdate()
	{

		$rules = [
			'level' => 'numeric|in:1,2',
			'nama' => 'string|required|max:225',
			'email' => 'string|required|max:100',
			'notelepon' => 'string|required|max:15',
		];

		if (Request::data('password')) {
			$rules['password'] = 'string|min:6|max:50';
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
			'notelepon' => $post['data']['notelepon'],
			'level' => $post['data']['level']
		];




		if ($post['data']['password']) {
			$update['password'] = md5($post['data']['password']);
		}

		$pengguna_update = (new DB)
			->table('pengguna')
			->update($update)
			->where('id', $post['data']['id']);

		if ($pengguna_update->run()) {

			return [
				'status' => 'success',
				'flash' => 'Data berhasil diperbarui',
				'redirect' => url('app/admin/pengguna/index')
			];


		} else {

			return [
				'status' => 'error',
				'flash' => 'Data gagal diperbarui',
				'error_fields' => [
					'level',
					'nama',
					'email',
					'notelepon',
					'password'
				]
			];
		}
	}
}