<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Models\UserModel;

class AuthController extends BaseController
{
    protected $userModel;
    protected $helpers = ['form', 'url'];

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    // ============================================================
    // LOGIN
    // ============================================================

    /**
     * Tampilkan form login
     */
    public function login()
    {
        // Jika sudah login, redirect ke dashboard
        if (session()->has('user_id')) {
            return redirect()->to(session('user_role') === 'operator' ? '/operator' : '/pengaduan');
        }

        return view('auth/login');
    }

    /**
     * Proses login
     */
    public function loginProcess()
    {
        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $this->userModel->getUserByEmail($email);

        // Validasi email dan password
        if (!$user) {
            return redirect()->back()
                ->with('error', '❌ Email tidak ditemukan')
                ->withInput();
        }

        if (!$this->userModel->validatePassword($password, $user['password'])) {
            return redirect()->back()
                ->with('error', '❌ Password salah')
                ->withInput();
        }

        // Cek status user
        if ($user['status'] !== 'aktif') {
            return redirect()->back()
                ->with('error', '⚠️ Akun Anda tidak aktif. Hubungi admin.')
                ->withInput();
        }

        // Ambil data user dengan role
        $userWithRole = $this->userModel->getUserWithRole($user['id']);

        // Set session
        session()->set([
            'user_id'    => $user['id'],
            'user_email' => $user['email'],
            'user_name'  => $user['nama_lengkap'],
            'user_role'  => $userWithRole['role_slug'],
            'role_id'    => $user['role_id'],
        ]);

        // Redirect sesuai role
        if ($userWithRole['role_slug'] === 'operator') {
            return redirect()->to('/operator')
                ->with('success', '✅ Selamat datang, ' . $user['nama_lengkap']);
        }

        return redirect()->to('/pengaduan')
            ->with('success', '✅ Selamat datang, ' . $user['nama_lengkap']);
    }

    // ============================================================
    // REGISTER
    // ============================================================

    /**
     * Tampilkan form register
     */
    public function register()
    {
        // Jika sudah login, redirect
        if (session()->has('user_id')) {
            return redirect()->to(session('user_role') === 'operator' ? '/operator' : '/pengaduan');
        }

        return view('auth/register');
    }

    /**
     * Proses register
     */
    public function registerProcess()
    {
        $data = [
            'nama_lengkap' => trim($this->request->getPost('nama_lengkap')),
            'email'        => trim($this->request->getPost('email')),
            'password'     => $this->request->getPost('password'),
            'nik'          => trim($this->request->getPost('nik')),
            'no_hp'        => trim($this->request->getPost('no_hp')),
            'alamat'       => trim($this->request->getPost('alamat')),
        ];

        // Validasi
        if (!$this->userModel->validate($data)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->userModel->errors());
        }

        // Register user
        if ($this->userModel->registerUser($data)) {
            return redirect()->to('/auth/login')
                ->with('success', '✅ Registrasi berhasil! Silakan login dengan akun Anda.');
        }

        return redirect()->back()
            ->withInput()
            ->with('error', '❌ Registrasi gagal. Coba lagi.');
    }

    // ============================================================
    // LOGOUT
    // ============================================================

    /**
     * Proses logout
     */
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/')
            ->with('success', '✅ Anda telah logout');
    }
}