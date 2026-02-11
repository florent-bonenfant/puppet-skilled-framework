<?php
defined('BASEPATH') or exit('No direct script access allowed');

use App\Service\Language\Language;

class Miscellaneous extends \App\Core\Controller\Base
{
    protected $isPublic = true;

    /**
     * Change language
     *
     * @param  string $langue
     */
    public function changelanguage($langue = null)
    {
        $service = new Language();
        $service->change($langue);
        redirect_referrer();
    }

    /**
     * 404 Error
     */
    public function not_found()
    {
        if ($this->router->uri->segments[1] === 'webservice') {
            $this->output
            ->enable_profiler(false)
            ->set_header("Access-Control-Allow-Origin: *")
            ->set_header("Access-Control-Expose-Headers: Access-Control-Allow-Origin")
            ->set_content_type('application/json', 'utf-8')
            ->set_status_header(400)
            ->set_output(json_encode([], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
            ->_display();
        } else {
            // Display 404 only if user is logged in
            $this->mustLoggedIn();
            $this->layout = ($this->session->last_layout ?: 'default');
            $this->breadcrumb = [];
            $this->output->set_status_header(404);
            $this->render(['page_title' => 'lang:general_title_not_found'], 'error/404');
        }
    }

    private function mustLoggedIn()
    {
        if (!$this->authenticationService->isLoggedIn()) {
            redirect('authentication/login');
        }
    }

    public function generateAdminToken()
    {
        if (!$this->authenticationService->isLoggedIn()) {
            echo json_encode(['adminToken' => '']);
            exit(0);
        }

        $user = $this->authenticationService->user();

        $is_admin = false;
        foreach ($user->roles as $role) {
            if (in_array($role->slug, ['role_developer', 'role_admin'])) {
                $is_admin = true;
            }
        }

        if (!$is_admin) {
            echo json_encode(['adminToken' => '']);
            exit(0);
        }

        $admin_token = bin2hex(random_bytes(20));
        $user->admin_token = $admin_token;
        $user->admin_token_datetime = date('Y-m-d H:i:s', time());
        $user->save();

        echo json_encode(['adminToken' => $admin_token]);
        exit(0);
    }
}
