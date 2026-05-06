<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\BotanyModel;

class ConBotany extends BaseController
{
    /**
     * หน้าแรกตอนรับ (Landing Page) ของสวนพฤกษศาสตร์
     */
    public function index()
    {
        $botanyNewsModel = new \App\Models\BotanyNewsModel();
        
        $page_data['title'] = 'งานสวนพฤกษศาสตร์โรงเรียน | โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์';
        $page_data['description'] = 'ยินดีต้อนรับสู่งานสวนพฤกษศาสตร์โรงเรียน สวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์ - โครงการอนุรักษ์พันธุกรรมพืชอันเนื่องมาจากพระราชดำริฯ';
        $page_data['latest_news'] = $botanyNewsModel->getActiveNews(3);
        
        $data = array_merge($this->data, $page_data);

        return view('User/layout/header', $data)
             . view('User/layout/navbar', $data)
             . view('User/Botany/PageIndex', $data)
             . view('User/layout/footer', $data);
    }

    /**
     * หน้าคลังข้อมูลพรรณไม้ (Plant Database)
     */
    public function plants()
    {
        $botanyModel = new BotanyModel();
        
        $page_data['title'] = 'คลังข้อมูลพรรณไม้ | งานสวนพฤกษศาสตร์โรงเรียน';
        $page_data['description'] = 'ฐานข้อมูลทรัพยากรท้องถิ่น รวบรวมพันธุ์ไม้ภายในโรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์';
        $page_data['plants'] = $botanyModel->getActivePlants();
        
        $data = array_merge($this->data, $page_data);

        return view('User/layout/header', $data)
             . view('User/layout/navbar', $data)
             . view('User/Botany/PageBotany', $data)
             . view('User/layout/footer', $data);
    }

    /**
     * หน้ารายละเอียดพรรณไม้
     */
    public function detail($id)
    {
        $botanyModel = new BotanyModel();
        $plant = $botanyModel->getPlantBySlug($id);
        
        if (!$plant) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        
        $page_data['title'] = $plant->botany_name_th . ' - ข้อมูลพรรณไม้';
        $page_data['description'] = $plant->botany_description;
        $page_data['plant'] = $plant;
        
        $data = array_merge($this->data, $page_data);

        return view('User/layout/header', $data)
             . view('User/layout/navbar', $data)
             . view('User/Botany/PageBotanyDetail', $data)
             . view('User/layout/footer', $data);
    }

    /**
     * หน้ารวมกิจกรรมและข่าวสาร
     */
    public function news()
    {
        $botanyNewsModel = new \App\Models\BotanyNewsModel();
        
        $page_data['title'] = 'กิจกรรมและข่าวสาร | งานสวนพฤกษศาสตร์โรงเรียน';
        $page_data['description'] = 'ภาพกิจกรรมและการดำเนินงานต่างๆ ของโครงการงานสวนพฤกษศาสตร์โรงเรียน';
        $page_data['news'] = $botanyNewsModel->getActiveNews();
        
        $data = array_merge($this->data, $page_data);

        return view('User/layout/header', $data)
             . view('User/layout/navbar', $data)
             . view('User/Botany/PageNews', $data)
             . view('User/layout/footer', $data);
    }

    /**
     * หน้ารายละเอียดข่าวสาร
     */
    public function newsDetail($id)
    {
        $botanyNewsModel = new \App\Models\BotanyNewsModel();
        $news = $botanyNewsModel->find($id);
        
        if (!$news) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        
        $botanyNewsImageModel = new \App\Models\BotanyNewsImageModel();
        
        $page_data['title'] = $news->news_title . ' - กิจกรรมและข่าวสาร';
        $page_data['description'] = strip_tags($news->news_content);
        $page_data['news'] = $news;
        $page_data['album'] = $botanyNewsImageModel->getImagesByNews($id);
        $page_data['recent_news'] = $botanyNewsModel->getActiveNews(5);
        
        $data = array_merge($this->data, $page_data);

        return view('User/layout/header', $data)
             . view('User/layout/navbar', $data)
             . view('User/Botany/PageNewsDetail', $data)
             . view('User/layout/footer', $data);
    }
}
