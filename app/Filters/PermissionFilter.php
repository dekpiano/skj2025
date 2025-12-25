<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class PermissionFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/Login/LoginAdmin');
        }

        // If no roles are required, allow access
        if (empty($arguments)) {
            return;
        }

        $userRoles = $session->get('roles') ?? [];

        // The first argument is always the main required role
        $requiredRoles = is_array($arguments) ? $arguments : [$arguments];

        $hasPermission = false;
        foreach ($requiredRoles as $role) {
            if (in_array($role, $userRoles)) {
                $hasPermission = true;
                break;
            }
        }

        // Always allow Super Admin
        if (in_array('Super Admin', $userRoles)) {
            $hasPermission = true;
        }

        if (!$hasPermission) {
            // You can show a custom "access denied" page
            return redirect()->to('/Admin/Dashboard')->with('error', 'คุณไม่มีสิทธิ์เข้าถึงหน้านี้');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
}