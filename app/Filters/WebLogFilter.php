<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Models\WebLogModel;

class WebLogFilter implements FilterInterface
{
    /**
     * Do whatever processing this filter needs to do.
     * By default it should not return anything during normal execution.
     * However, when an abnormal state is found, it should return an instance of
     * CodeIgniter\HTTP\Response. If it does, script execution will end and that
     * Response will be sent back to the client, allowing for error pages,
     * redirects, etc.
     *
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return mixed
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        // Don't log if it's an AJAX request for some specific things or DEBUG toolbar
        if ($request->isAJAX() && strpos($request->getUri()->getPath(), 'debugbar') !== false) {
            return;
        }

        // We only want to log Page Views and interesting actions, not every small request if possible.
        // But for legal compliance, we log everything that hits a controller.
        
        $session = session();
        $agent = $request->getUserAgent();

        $logData = [
            'log_user_id'    => $session->get('AdminID') ?? null,
            'log_user_name'  => $session->get('AdminFullname') ?? 'Guest',
            'log_ip_address' => $request->getIPAddress(),
            'log_method'     => $request->getMethod(),
            'log_url'        => (string)$request->getUri(),
            'log_agent'      => $agent->getAgentString(),
            'log_session_id' => $session->session_id ?? session_id(),
        ];

        try {
            $logModel = new WebLogModel();
            $logModel->insert($logData);

            // Automatic Cleanup: 1% chance to delete logs older than 90 days
            if (mt_rand(1, 100) === 1) {
                $days = 90;
                $date = date('Y-m-d H:i:s', strtotime("-$days days"));
                $logModel->where('log_created_at <', $date)->delete();
            }
        } catch (\Exception $e) {
            // Fail silently to not break the app if logging fails
            log_message('error', 'WebLogFilter Error: ' . $e->getMessage());
        }
    }

    /**
     * Allows After filters to inspect and modify the response
     * object as needed. This method does not allow any way
     * to stop execution of other after filters, short of
     * throwing an Exception or Error.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     *
     * @return mixed
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
}
