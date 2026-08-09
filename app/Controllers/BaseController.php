<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Models\UserHistoryModel;
use App\Models\VisitorModel;
use App\Models\AboutModel;
use App\Models\LearningModel;
use App\Models\PositionModel;
use App\Libraries\Datethai;
use AllowDynamicProperties;

#[AllowDynamicProperties]
abstract class BaseController extends Controller
{
    /**
     * @var UserHistoryModel
     */
    protected $UserHistoryModel;

    public function __construct()
    {
        $this->UserHistoryModel = new UserHistoryModel();
    }

    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = ['form', 'url'];

    /**
     * A property to hold shared data for views.
     * @var array
     */
    protected $data = [];

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.
        $aboutModel = new AboutModel();

        // --- Visitor Counter Logic ---
        $visitorModel = new VisitorModel();
        $ipAddress = $this->request->getIPAddress();
        $userAgent = $this->request->getUserAgent()->getAgentString();

        // 1. Log the current visitor
        $visitorModel->addVisitor($ipAddress, $userAgent);

        // 2. Get stats and prepare them for the view
        // The footer view expects a variable named '$v'
        $this->data['v'] = $visitorModel->getStats();

// App/Models/WebSettingsModel.php
        $webSettingsModel = new \App\Models\WebSettingsModel();
        
        // Pass the uri object to the view as well, as it's used in the footer
        $this->data['uri'] = $this->request->getUri();
        
        // Pass AboutSchool data to all views
        $this->data['AboutSchool'] = $aboutModel->get()->getResult();

        // Pass Festival Theme Status and Welcome Modal Status
        // Check if table exists first to avoid error if not initialized
        $db = \Config\Database::connect();
        if ($db->tableExists('tb_web_settings')) {
            $this->data['festival_status'] = $webSettingsModel->getStatus('festival_theme');
            
            $modalStatus = $webSettingsModel->getStatus('welcome_modal_status'); // 'on', 'off'
            $rawItems = $webSettingsModel->getStatus('welcome_modal_items');
            $items = json_decode($rawItems ?: '[]', true);

            // Backward compatibility fallback
            if (empty($items)) {
                $rawImages = $webSettingsModel->getStatus('welcome_modal_images');
                $legacyImages = json_decode($rawImages ?: '[]', true);
                if (is_array($legacyImages)) {
                    $items = [];
                    foreach ($legacyImages as $img) {
                        if (is_string($img)) {
                            $items[] = ['file' => $img, 'title' => '', 'start_datetime' => '', 'end_datetime' => ''];
                        } elseif (is_array($img) && isset($img['file'])) {
                            $items[] = $img;
                        }
                    }
                }
            }
            
            $now = date('Y-m-d\TH:i');
            $activeImages = [];

            if ($modalStatus === 'on' && is_array($items)) {
                foreach ($items as $item) {
                    $file = is_array($item) ? ($item['file'] ?? '') : $item;
                    if (!$file) continue;

                    $startDt = is_array($item) ? ($item['start_datetime'] ?? '') : '';
                    $endDt = is_array($item) ? ($item['end_datetime'] ?? '') : '';

                    $afterStart = empty($startDt) || ($now >= $startDt);
                    $beforeEnd = empty($endDt) || ($now <= $endDt);

                    if ($afterStart && $beforeEnd) {
                        $activeImages[] = [
                            'file' => $file,
                            'title' => is_array($item) ? ($item['title'] ?? '') : ''
                        ];
                    }
                }
            }

            $this->data['welcome_modal_status'] = $modalStatus;
            $this->data['welcome_modal_is_active'] = !empty($activeImages);
            $this->data['welcome_modal_active_images'] = $activeImages;
            $this->data['welcome_modal_images'] = array_column($activeImages, 'file');
            $this->data['welcome_modal_items'] = $items;
        } else {
            $this->data['festival_status'] = 'off';
            $this->data['welcome_modal_status'] = 'off';
            $this->data['welcome_modal_is_active'] = false;
            $this->data['welcome_modal_active_images'] = [];
            $this->data['welcome_modal_images'] = [];
            $this->data['welcome_modal_items'] = [];
        }

        // --- Common Navbar Data ---
        $learModel = new LearningModel();
        $posiModel = new PositionModel();
        
        $this->data['Lear'] = $learModel->get()->getResult();
        $this->data['PosiOther'] = $posiModel->where([
            'posi_id >=' => 'posi_007',
            'posi_id <=' => 'posi_012'
        ])->get()->getResult();

        // --- Common Global Data ---
        $this->data['full_url'] = current_url();
        $this->data['dateThai'] = new Datethai();
        $this->data['uri'] = $this->request->getUri();
    }
}
