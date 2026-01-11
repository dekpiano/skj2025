<?php

namespace App\Controllers\Manager;

use App\Controllers\BaseController;

class ConManagerGeneral extends BaseController
{
    public function index()
    {
        $db_general = \Config\Database::connect('general');
        $db_academic = \Config\Database::connect('academic');
        
        // Get schoolyear
        $schoolyear = $db_academic->table('tb_schoolyear')->orderBy('schyear_id', 'DESC')->get()->getRowArray();
        
        $today = date('Y-m-d');
        $thisMonth = date('Y-m');
        
        // ========== BOOKING STATS ==========
        $booking_today = $db_general->table('tb_booking')
            ->where('booking_dateStart', $today)
            ->countAllResults();
        
        $booking_pending = $db_general->table('tb_booking')
            ->where('booking_admin_approve', 'รอตรวจสอบ')
            ->countAllResults();
        
        $booking_month = $db_general->table('tb_booking')
            ->like('booking_dateStart', $thisMonth, 'after')
            ->countAllResults();
        
        // ========== CAR RESERVATION STATS ==========
        $car_today = $db_general->table('tb_car_reservation')
            ->where('car_reserv_StartDate', $today)
            ->countAllResults();
        
        $car_pending = $db_general->table('tb_car_reservation')
            ->where('car_reserv_status', 'รอตรวจสอบ')
            ->countAllResults();
        
        $car_month = $db_general->table('tb_car_reservation')
            ->like('car_reserv_StartDate', $thisMonth, 'after')
            ->countAllResults();
        
        // ========== REPAIR STATS ==========
        $repair_pending = $db_general->table('tb_repair')
            ->whereNotIn('repair_status', ['เสร็จสิ้น', 'ยกเลิก'])
            ->countAllResults();
        
        $repair_done = $db_general->table('tb_repair')
            ->where('repair_status', 'เสร็จสิ้น')
            ->countAllResults();
        
        $repair_total = $db_general->table('tb_repair')->countAllResults();
        
        // ========== FOOD REPORTS STATS ==========
        $food_month = $db_general->table('tb_food_reports')
            ->like('food_date', $thisMonth, 'after')
            ->countAllResults();
        
        // ========== PENDING APPROVALS ==========
        $pending_bookings = $db_general->table('tb_booking')
            ->select('booking_id, booking_order, booking_title, booking_dateStart, booking_timeStart, booking_Booker')
            ->where('booking_admin_approve', 'รอตรวจสอบ')
            ->orderBy('booking_dateStart', 'ASC')
            ->limit(10)
            ->get()->getResultArray();
        
        $pending_cars = $db_general->table('tb_car_reservation')
            ->select('car_reserv_id, car_reserv_order, car_reserv_location, car_reserv_StartDate, car_reserv_StartTime, car_reserv_memberID')
            ->where('car_reserv_status', 'รอตรวจสอบ')
            ->orderBy('car_reserv_StartDate', 'ASC')
            ->limit(10)
            ->get()->getResultArray();
        
        $pending_repairs = $db_general->table('tb_repair')
            ->select('repair_ID, repair_order, repair_room, repair_caselist, repair_datetime, repair_status')
            ->whereNotIn('repair_status', ['เสร็จสิ้น', 'ยกเลิก'])
            ->orderBy('repair_datetime', 'ASC')
            ->limit(10)
            ->get()->getResultArray();
        
        // ========== MONTHLY STATS FOR CHART ==========
        $booking_by_month = $db_general->query("
            SELECT DATE_FORMAT(booking_dateStart, '%Y-%m') as month, COUNT(*) as count
            FROM tb_booking
            WHERE booking_dateStart >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
            GROUP BY DATE_FORMAT(booking_dateStart, '%Y-%m')
            ORDER BY month ASC
        ")->getResultArray();
        
        $car_by_month = $db_general->query("
            SELECT DATE_FORMAT(car_reserv_StartDate, '%Y-%m') as month, COUNT(*) as count
            FROM tb_car_reservation
            WHERE car_reserv_StartDate >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
            GROUP BY DATE_FORMAT(car_reserv_StartDate, '%Y-%m')
            ORDER BY month ASC
        ")->getResultArray();
        
        // Repair status distribution
        $repair_by_status = $db_general->table('tb_repair')
            ->select('repair_status, COUNT(*) as count')
            ->groupBy('repair_status')
            ->get()->getResultArray();

        $data = [
            'title' => 'งานบริหารทั่วไป',
            'description' => 'Dashboard งานบริหารทั่วไป',
            'schoolyear' => $schoolyear,
            'booking_today' => $booking_today,
            'booking_pending' => $booking_pending,
            'booking_month' => $booking_month,
            'car_today' => $car_today,
            'car_pending' => $car_pending,
            'car_month' => $car_month,
            'repair_pending' => $repair_pending,
            'repair_done' => $repair_done,
            'repair_total' => $repair_total,
            'food_month' => $food_month,
            'pending_bookings' => $pending_bookings,
            'pending_cars' => $pending_cars,
            'pending_repairs' => $pending_repairs,
            'booking_by_month' => $booking_by_month,
            'car_by_month' => $car_by_month,
            'repair_by_status' => $repair_by_status
        ];

        return view('Manager/ManagerGeneral/PageManagerGeneral', array_merge($this->data, $data));
    }

    public function getAnalysis()
    {
        $db_general = \Config\Database::connect('general');
        $startDate = $this->request->getGet('startDate');
        $endDate = $this->request->getGet('endDate');

        // Filter by date range
        $dateFilterBooking = "";
        $dateFilterCar = "";
        $dateFilterRepair = "";
        $dateFilterFood = "";
        
        if ($startDate && $endDate) {
            $dateFilterBooking = " AND booking_dateStart BETWEEN '{$startDate}' AND '{$endDate}'";
            $dateFilterCar = " AND car_reserv_StartDate BETWEEN '{$startDate}' AND '{$endDate}'";
            $dateFilterRepair = " AND DATE(repair_datetime) BETWEEN '{$startDate}' AND '{$endDate}'";
            $dateFilterFood = " AND food_date BETWEEN '{$startDate}' AND '{$endDate}'";
        }

        // Booking stats
        $booking_total = $db_general->query("SELECT COUNT(*) as cnt FROM tb_booking WHERE 1=1 {$dateFilterBooking}")->getRow()->cnt ?? 0;
        $booking_pending = $db_general->query("SELECT COUNT(*) as cnt FROM tb_booking WHERE booking_admin_approve = 'รอตรวจสอบ' {$dateFilterBooking}")->getRow()->cnt ?? 0;
        
        // Car stats
        $car_total = $db_general->query("SELECT COUNT(*) as cnt FROM tb_car_reservation WHERE 1=1 {$dateFilterCar}")->getRow()->cnt ?? 0;
        $car_pending = $db_general->query("SELECT COUNT(*) as cnt FROM tb_car_reservation WHERE car_reserv_status = 'รอตรวจสอบ' {$dateFilterCar}")->getRow()->cnt ?? 0;
        
        // Repair stats
        $repair_pending = $db_general->query("SELECT COUNT(*) as cnt FROM tb_repair WHERE repair_status NOT IN ('เสร็จสิ้น', 'ยกเลิก') {$dateFilterRepair}")->getRow()->cnt ?? 0;
        $repair_done = $db_general->query("SELECT COUNT(*) as cnt FROM tb_repair WHERE repair_status = 'เสร็จสิ้น' {$dateFilterRepair}")->getRow()->cnt ?? 0;
        $repair_total = $db_general->query("SELECT COUNT(*) as cnt FROM tb_repair WHERE 1=1 {$dateFilterRepair}")->getRow()->cnt ?? 0;
        
        // Food stats
        $food_total = $db_general->query("SELECT COUNT(*) as cnt FROM tb_food_reports WHERE 1=1 {$dateFilterFood}")->getRow()->cnt ?? 0;

        return $this->response->setJSON([
            'status' => true,
            'booking_total' => (int)$booking_total,
            'booking_pending' => (int)$booking_pending,
            'car_total' => (int)$car_total,
            'car_pending' => (int)$car_pending,
            'repair_pending' => (int)$repair_pending,
            'repair_done' => (int)$repair_done,
            'repair_total' => (int)$repair_total,
            'food_total' => (int)$food_total
        ]);
    }
}
