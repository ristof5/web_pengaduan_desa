<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * Filter Auth
 * Digunakan untuk melindungi route agar hanya bisa diakses
 * oleh pengguna yang sudah login dan memiliki role yang sesuai.
 *
 * Penggunaan di Routes.php:
 *   ['filter' => 'auth']           -> cek login saja
 *   ['filter' => 'auth:operator']  -> cek login + role operator
 *   ['filter' => 'auth:masyarakat']-> cek login + role masyarakat
 */
class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        // Cek apakah user sudah login
        if (! $session->has('user_id')) {
            return redirect()->to('/auth/login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        // Cek role jika ada argument
        if ($arguments && count($arguments) > 0) {
            $requiredRole = $arguments[0];
            $userRole     = $session->get('user_role'); // 'masyarakat' atau 'operator'

            if ($userRole !== $requiredRole) {
                // Arahkan ke halaman sesuai role masing-masing
                if ($userRole === 'operator') {
                    return redirect()->to('/operator')
                        ->with('error', 'Akses tidak diizinkan.');
                }
                return redirect()->to('/pengaduan')
                    ->with('error', 'Akses tidak diizinkan.');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak ada aksi setelah response
    }
}