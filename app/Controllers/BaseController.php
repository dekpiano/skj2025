<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Models\UserHistoryModel;
use App\Models\VisitorModel; // เพิ่ม Model ที่เราสร้าง
use App\Models\AboutModel;

abstract class BaseController extends Controller
{
    public function __construct(){
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

        // Pass the uri object to the view as well, as it's used in the footer
        $this->data['uri'] = $this->request->uri;
        
        // Pass AboutSchool data to all views
        $this->data['AboutSchool'] = $aboutModel->get()->getResult();
    }
}
