<?php

namespace App\Controllers\Operator;

use App\Controllers\BaseController;

class DashboardController extends BaseController
{
    public function index()
    {
        // Hanya operator yang bisa akses
        if ($this->userRole() !== 'operator') {
            return redirect()->to('/')->with('error', 'Akses ditolak');
        }

        $data = [
            'title' => 'Dashboard Operator',
            'user'  => $this->getCurrentUser(),
        ];

        return view('operator/dashboard/index', $data);
    }
}