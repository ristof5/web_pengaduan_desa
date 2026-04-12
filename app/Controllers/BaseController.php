<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * BaseController
 *
 * Kelas dasar semua controller.
 * Menyediakan helper method untuk session & autentikasi.
 *
 * Key session yang digunakan (konsisten dengan UserModel::setSession):
 *   user_id    → int
 *   user_nama  → string  (dipakai di Views versi progress)
 *   user_name  → string  (alias, dipakai di Views versi repo)
 *   user_email → string
 *   user_role  → string  ('masyarakat' | 'operator')
 *   role_id    → int
 *   logged_in  → bool
 */
abstract class BaseController extends Controller
{
    /** @var CLIRequest|IncomingRequest */
    protected $request;

    /** @var \CodeIgniter\Session\Session */
    protected $session;

    protected $helpers = ['form', 'url'];

    public function initController(
        RequestInterface  $request,
        ResponseInterface $response,
        LoggerInterface   $logger
    ): void {
        parent::initController($request, $response, $logger);
        $this->session = service('session');
    }

    // ----------------------------------------------------------------
    // Helper: cek status login
    // ----------------------------------------------------------------

    /** Apakah user sudah login? */
    protected function isLoggedIn(): bool
    {
        return session()->has('user_id');
    }

    // ----------------------------------------------------------------
    // Helper: ambil data user dari session
    // ----------------------------------------------------------------

    /**
     * Kembalikan data user aktif dari session.
     * Mendukung kedua alias key (user_nama & user_name).
     */
    protected function getCurrentUser(): array
    {
        return [
            'id'      => session('user_id'),
            'name'    => session('user_nama') ?? session('user_name'),
            'nama'    => session('user_nama') ?? session('user_name'),
            'email'   => session('user_email'),
            'role'    => session('user_role'),
            'role_id' => session('role_id'),
        ];
    }

    /** Shortcut: role user yang sedang login. */
    protected function userRole(): ?string
    {
        return session('user_role');
    }

    /** Shortcut: ID user yang sedang login. */
    protected function userId(): ?int
    {
        $id = session('user_id');
        return $id ? (int) $id : null;
    }

    /** Shortcut: nama user yang sedang login. */
    protected function userName(): ?string
    {
        return session('user_nama') ?? session('user_name');
    }
}