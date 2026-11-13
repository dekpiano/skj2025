<?php

namespace App\Controllers\User;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\NewsModel;
use App\Libraries\Datethai;
use App\Models\BannerModel;
use App\Models\PositionModel;
use App\Models\LearningModel;
use App\Models\PersonnalModel;
use App\Models\AboutModel;

class ConNews extends BaseController
{
    protected $NewsModel;
    protected $PosiModel;
    protected $LearModel;
    protected $PersModel;
    protected $AboutModel;
    protected $BannerModel;
    protected $NewsImageModel;

    public function __construct()
    {
        parent::__construct();
        $this->NewsModel = new NewsModel();
        $this->PosiModel = new PositionModel();
        $this->LearModel = new LearningModel();
        $this->PersModel = new PersonnalModel();
        $this->AboutModel = new AboutModel();
        $this->BannerModel = new BannerModel();
        $this->NewsImageModel = new \App\Models\NewsImageModel();
    }

    public function DataMain(){
        $data['full_url'] = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $data['dateThai'] = new Datethai();
        $data['Lear'] = $this->LearModel->get()->getResult();
        $data['PosiOther'] = $this->PosiModel->where('posi_id >=', 'posi_007')->orderBy('posi_id', 'ASC')->get()->getResult();
        $data['uri'] = service('uri'); 
        $data['AboutSchool'] = $this->AboutModel->get()->getResult();
        $database = \Config\Database::connect();
        $data['DB'] = $database->table('tb_news');
        helper(['form', 'url']);
        // $data['v'] = $this->VisitorsUser(); // REMOVED
        return $data;
    }

    public function NewsMain(){
        
        $page_data = $this->DataMain();
        $page_data['title'] = "สกจ. ประชาสัมพันธ์";
        $page_data['description'] = "ข่าวและกิจกรรมภายในโรงเรียน";
        $page_data['banner'] = '';

        $request = service('request');
        $searchData = $request->getGet();

        $search = "";
        if(isset($searchData) && isset($searchData['search'])){
        $search = $searchData['search'];
        }

        if($search == ''){
            $paginateData = $this->NewsModel->orderBy('news_date', 'DESC')->paginate(20);
          }else{
            $paginateData = $this->NewsModel->select('*')
                ->orLike('news_topic', $search)
                ->orLike('news_category', $search)
                ->orLike('news_date', $search)
                ->orderBy('news_date', 'DESC')
                ->paginate(20);
          }

        $page_data['NewsAll' ] = $paginateData;
        $page_data['pager' ] = $this->NewsModel->pager;
        $page_data['search' ] = $search;
      
        $data = array_merge($this->data, $page_data);

        return  view('User/layout/header',$data)
                .view('User/layout/navbar', $data)
                .view('User/PageNews/PageNewsMain', $data)
                .view('User/layout/footer', $data);
        
    }

    public function loadMoreNews(){
        $perPage = 10; // จำนวนข้อมูลต่อหน้า
        $page = max(1, (int)($this->request->getVar('page') ?: 1));
        $search = trim((string)($this->request->getVar('search') ?? ''));

        // คำนวณ offset สำหรับ pagination
        $offset = ($page - 1) * $perPage;

        // Query ข้อมูล
        $builder = $this->NewsModel->orderBy('news_date', 'DESC');
        if ($search !== '') {
            $builder->groupStart()
                ->like('news_topic', $search)
                ->orLike('news_category', $search)
                ->orLike('news_content', $search)
                ->groupEnd();
        }

        // นับจำนวนทั้งหมดตามเงื่อนไขค้นหา
        $countBuilder = clone $builder;
        $totalItems = $countBuilder->countAllResults(false);

        $items = $builder->limit($perPage, $offset)->get()->getResultArray();
        
        $dateThai = new \App\Libraries\Datethai();
        foreach ($items as &$item) {
            $item['news_img_url'] = news_image_url($item['news_img'] ?? '', 'cover');
            $item['detail_url']   = base_url('News/Detail/' . $item['news_id']);
            $item['formatted_date'] = !empty($item['news_date']) ? $dateThai->thai_date_fullmonth(strtotime($item['news_date'])) : '';
        }
        unset($item);

        $data = [
            'items' => $items,
            'pager' => [
                'total' => $totalItems,
                'currentPage' => $page,
                'perPage' => $perPage,
                'lastPage' => ceil($totalItems / $perPage)
            ]
        ];

        return $this->response->setJSON($data); // ส่งข้อมูลในรูปแบบ JSON
    }

    public function loadMoreNews1(){
        $data['dateThai'] = new Datethai();
        $limit = 4; 
        $page = $limit * $this->request->getVar('page');
        $data['NewsAll'] = $this->fetchData($limit,$page);
        return view('User/PageNews/PageNewsLoadMore', $data);
        //print_r($data['NewsAll']);
    }

    function fetchData($limit,$offset = ''){
        $dbQuery = $this->NewsModel->select('*')->limit($limit,$offset)->orderBy('news_date', 'DESC')->get();
        return $dbQuery->getResult();
    }

    public function NewsDetail($KeyNews)
    {    
        $page_data = $this->DataMain();
       
        $page_data['news'] = $this->NewsModel->where('news_id',$KeyNews)->orderBy('news_date', 'DESC')->get()->getRow();
        
        if (! $page_data['news']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("ไม่พบข้อมูลข่าวที่ระบุ");
        }

        $page_data['NewsLatest'] = $this->NewsModel->where('news_id !=', $KeyNews)->limit(10)->orderBy('news_date', 'DESC')->get()->getResult();
        $page_data['NewsAlbum'] = $this->NewsImageModel->where('news_id', $KeyNews)->orderBy('news_img_id', 'ASC')->findAll();

        $page_data['title'] = $page_data['news']->news_topic ." | สกจ. ประชาสัมพันธ์";
        $page_data['description'] = mb_strimwidth(strip_tags($page_data['news']->news_content),0,100,'...');
        $page_data['banner'] = news_image_url($page_data['news']->news_img, 'cover');

        $dataUpdate = [
            'news_view' => ($page_data['news']->news_view + 1)
        ];
        $page_data['DB']->where('news_id',$KeyNews);
        $page_data['DB']->update($dataUpdate);

        $data = array_merge($this->data, $page_data);

        return  view('User/layout/header',$data)
                .view('User/layout/navbar', $data)
                .view('User/PageNews/PageNewsDetail', $data)
                .view('User/layout/footer', $data);
    }

    public function NewsCountRead(){
        $data = $this->DataMain();
       
        $dataUpdate = [
            'news_view' => ($this->request->getVar('Data_View') + 1)
        ];
        $data['DB']->where('news_id',$this->request->getVar('NewsID'));
        echo $data['DB']->update($dataUpdate);
        
    }

    public function newsSuggestions()
    {
        $searchTerm = $this->request->getGet('term');
        $suggestions = $this->NewsModel->getNewsSuggestions($searchTerm);
        if (!empty($suggestions)) {
            foreach ($suggestions as &$item) {
                $item['detail_url'] = base_url('News/Detail/' . $item['news_id']);
            }
            unset($item);
        }
        return $this->response->setJSON($suggestions);
    }

    public function pr(){
        $data = $this->DataMain();
        $data['title'] = "สกจ. ประชาสัมพันธ์";
        $data['description'] = "";
        $data['banner'] = "";

        $data['banner'] = $this->BannerModel->select('banner_id,banner_name,banner_img,banner_linkweb,banner_status,banner_end_date')
        ->where('banner_status','on')
        ->groupStart()
            ->where('banner_end_date', null)
            ->orWhere('banner_end_date >=', date('Y-m-d'))
        ->groupEnd()
        ->orderBy('banner_id', 'DESC')
        ->findAll();

        return  view('User/PagePr/PagePrMain',$data);
                
    }
}
