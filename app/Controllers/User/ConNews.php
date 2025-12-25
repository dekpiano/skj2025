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
    public function __construct(){
        parent::__construct();
        $this->NewsModel = new NewsModel();
        $this->PosiModel = new PositionModel();
        $this->LearModel = new LearningModel();
        $this->PersModel = new PersonnalModel();
        $this->AboutModel = new AboutModel();
        $this->BannerModel = new BannerModel();
       
    }

    public function DataMain(){
        $data['full_url'] = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $data['dateThai'] = new Datethai();
        $data['Lear'] = $this->LearModel->get()->getResult();
        $data['PosiOther'] = $this->PosiModel->where(array('posi_id >='=>'posi_007','posi_id <='=>'posi_012'))->get()->getResult();
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
        $page = $this->request->getVar('page') ? $this->request->getVar('page') : 1;

        // คำนวณ offset สำหรับ pagination
        $offset = ($page - 1) * $perPage;

        // ดึงข้อมูลจากฐานข้อมูล
       
        $items = $this->NewsModel->limit($perPage, $offset)->orderBy('news_date', 'DESC')->get()->getResultArray();
        
        // นับจำนวนทั้งหมดในตาราง
        $totalItems =$this->NewsModel->countAllResults();

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
        $page_data['NewsLatest'] = $this->NewsModel->limit(3)->orderBy('news_date', 'DESC')->get()->getResult();

        $page_data['title'] = $page_data['news']->news_topic ." | สกจ. ประชาสัมพันธ์";
        $page_data['description'] = mb_strimwidth(strip_tags($page_data['news']->news_content),0,100,'...');
        $page_data['banner'] = base_url('uploads/news/'.$page_data['news']->news_img);

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
        return $this->response->setJSON($suggestions);
    }

    public function pr(){
        $data = $this->DataMain();
        $data['title'] = "สกจ. ประชาสัมพันธ์";
        $data['description'] = "";
        $data['banner'] = "";

        $data['banner'] = $this->BannerModel->select('banner_id,banner_name,banner_img,banner_linkweb,banner_status')
        ->where('banner_status','on')
        ->orderBy('banner_id', 'DESC')
        ->findAll();

        return  view('User/PagePr/PagePrMain',$data);
                
    }
}
