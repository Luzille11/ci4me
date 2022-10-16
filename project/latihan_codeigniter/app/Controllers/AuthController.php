<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class AuthController extends BaseController
{
    public function __construct()
    {
        $this->model = new \App\Models\User();
    }
    
    public function registrasi()
    {
        return view('registrasi');
    }

    public function login()
    {
        return view('login');
    }
    
    public function simpanRegistrasi()
    {
    //1. mengambil data ari input form
    $data = [
                'nama'             => $this->request->getPost('nama'),
        'email'                    => $this->request->getPost('email'),
        'password'                 => $this->request->getPost('password'),
        'konfirmasi_password'      => $this->request->getPost('kofirm_pass'),
    ];
    //2. validasi input form
    $validation = \Config\Services::validation();

    $validation->setRules([
        'nama'                 => 'required',
        'email'                => 'required|valid_email|is_unique[users.email]',
        'password'             => 'required|min_length[8]',
        'konfirmasi_password'  => 'required|matches[password]',
    ]);
    //3. cek validasi
    if ($validation->run($data)){
        //jika berhasil, simpan data dan beri pesan berhasil
        $this->model->save([
            'nama'                 => $data['nama'],
            'email'                => $data['email'],
            'password'             => password_hash($data['password'], PASSWORD_BCRYPT),
            'role'                 => 'siswa'
        ]);

        return redirect()->to(base_url('registrasi'))->with('sukses','Registrasi berhasil !');
    } else {
        //jika gagal beri pesan gagal
        $errorMessages = $validation->getErrors();
        return redirect()->to(base_url('registrasi'))->with('gagal', $errorMessages);
    }
    }
}