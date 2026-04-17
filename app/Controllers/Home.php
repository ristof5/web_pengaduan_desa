<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        // Jika user sudah login, redirect ke dashboard masing-masing
        if ($this->isLoggedIn()) {
            if ($this->userRole() === 'operator') {
                redirect()->to('/operator')->send();
            }
            redirect()->to('/pengaduan')->send();
        }   

        // Landing page publik
        return view('home/index');
    }

    /**
     * Dashboard redirect untuk user yang sudah login
     */
    public function dashboard()
    {
        if (!$this->isLoggedIn()) {
            return redirect()->to('/auth/login');
        }

        if ($this->userRole() === 'operator') {
            return redirect()->to('/operator');
        }

        return redirect()->to('/pengaduan');
    }
}