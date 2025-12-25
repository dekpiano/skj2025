<?php

namespace App\Models;

use CodeIgniter\Model;

class VisitorModel extends Model
{
    protected $table = 'tb_visit_user_history';
    protected $primaryKey = 'visitU_id';
    protected $allowedFields = ['visitU_ip', 'visitU_agent', 'visitU_timestamp'];

    /**
     * Adds a new visitor record if they haven\'t visited today.
     *
     * @param string $ip
     * @param string $agent
     * @return void
     */
    public function addVisitor($ip, $agent)
    {
        // Check if this IP has visited today already
        $today = date('Y-m-d');
        $existing = $this->where('visitU_ip', $ip)
                         ->where('DATE(visitU_timestamp)', $today)
                         ->first();

        // If not, add a new record
        if (!$existing) {
            $data = [
                'visitU_ip' => $ip,
                'visitU_agent' => $agent,
                'visitU_timestamp' => date('Y-m-d H:i:s')
            ];
            $this->insert($data);
        }
    }

    /**
     * Gets visitor statistics.
     *
     * @return array
     */
    public function getStats()
    {
        // Load the cache service
        $cache = \Config\Services::cache();
        $cacheKey = 'visitor_stats';

        // Try to get the stats from the cache
        if (!$stats = $cache->get($cacheKey)) {
            // If not in cache, calculate them
            $db = $this->db;
            $today = date('Y-m-d');
            $currentMonth = date('m');
            $currentYear = date('Y');

            // Total unique visitors (based on IP)
            $totalResult = $db->query("SELECT COUNT(DISTINCT visitU_ip) as total FROM " . $this->table)->getRow();

            // Today's unique visitors
            $todayResult = $db->query("SELECT COUNT(DISTINCT visitU_ip) as total FROM " . $this->table . " WHERE DATE(visitU_timestamp) = ?", [$today])->getRow();

            // This month's unique visitors
            $monthResult = $db->query("SELECT COUNT(DISTINCT visitU_ip) as total FROM " . $this->table . " WHERE MONTH(visitU_timestamp) = ? AND YEAR(visitU_timestamp) = ?", [$currentMonth, $currentYear])->getRow();

            // This year's unique visitors
            $yearResult = $db->query("SELECT COUNT(DISTINCT visitU_ip) as total FROM " . $this->table . " WHERE YEAR(visitU_timestamp) = ?", [$currentYear])->getRow();

            $stats = [
                'visitAll' => $totalResult->total ?? 0,
                'VisitToday' => $todayResult->total ?? 0,
                'visitMouth' => $monthResult->total ?? 0,
                'visitYear' => $yearResult->total ?? 0,
            ];

            // Save the stats to the cache for 10 minutes (600 seconds)
            $cache->save($cacheKey, $stats, 600);
        }

        return $stats;
    }
}
