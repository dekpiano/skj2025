<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Services\RemoteUploadService;

class SyncNewsImages extends BaseCommand
{
    protected $group       = 'Media';
    protected $name        = 'news:sync-remote';
    protected $description = 'Sync legacy local news images in uploads/news/ to the remote cloud server and reclaim disk space.';

    protected $usage       = 'news:sync-remote [options]';
    protected $arguments   = [];
    protected $options     = [
        '--keep-local' => 'Keep local image files (do not delete them after uploading)',
        '--dry-run'    => 'Scan and simulate upload without sending files or deleting',
        '--limit'      => 'Limit the number of files to process (default: all)',
    ];

    public function run(array $params)
    {
        CLI::write("=== เริ่มต้นกระบวนการซิงค์รูปภาพข่าวสารขึ้น Cloud Server ===", 'green');
        $baseDir = rtrim(FCPATH . 'uploads' . DIRECTORY_SEPARATOR . 'news', DIRECTORY_SEPARATOR);

        if (!is_dir($baseDir)) {
            CLI::error("ไม่พบโฟลเดอร์: {$baseDir}");
            return;
        }

        $keepLocal = array_key_exists('keep-local', $params) || CLI::getOption('keep-local');
        $dryRun    = array_key_exists('dry-run', $params) || CLI::getOption('dry-run');
        $limit     = (int) (CLI::getOption('limit') ?: 0);

        $allowedExts = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $files = [];
        $totalBytes = 0;

        CLI::write("กำลังค้นหารายชื่อไฟล์ภาพใน uploads/news/ ...");

        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($baseDir, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::LEAVES_ONLY
        );

        foreach ($iterator as $fileInfo) {
            if ($fileInfo->isFile()) {
                $ext = strtolower($fileInfo->getExtension());
                if (in_array($ext, $allowedExts, true)) {
                    $realPath = $fileInfo->getRealPath();
                    $relPath  = ltrim(substr($realPath, strlen($baseDir)), DIRECTORY_SEPARATOR);
                    $relPath  = str_replace(DIRECTORY_SEPARATOR, '/', $relPath);
                    $size     = $fileInfo->getSize();
                    $files[]  = ['rel' => $relPath, 'full' => $realPath, 'size' => $size];
                    $totalBytes += $size;
                }
            }
        }

        $totalCount = count($files);
        $totalMb = round($totalBytes / (1024 * 1024), 2);
        CLI::write("พบไฟล์ทั้งหมด: {$totalCount} ไฟล์ (ขนาด {$totalMb} MB)", 'yellow');

        if ($totalCount === 0) {
            CLI::write("ไม่มีไฟล์ที่ต้องซิงค์", 'green');
            return;
        }

        if ($limit > 0 && $limit < $totalCount) {
            $files = array_slice($files, 0, $limit);
            CLI::write("จำกัดการประมวลผลไว้ที่ {$limit} ไฟล์", 'cyan');
        }

        if ($dryRun) {
            CLI::write("โหมดจำลอง (Dry-Run): ไม่มีไฟล์ใดถูกอัปโหลดหรือลบจริง", 'yellow');
            return;
        }

        $remoteUpload = new RemoteUploadService();
        $ping = $remoteUpload->pingServer();
        if ($ping['status'] !== 'online') {
            CLI::error("ไม่สามารถเชื่อมต่อไปยัง Remote Server ได้: " . ($ping['message'] ?? ''));
            return;
        }

        CLI::write("เชื่อมต่อ Remote Server สำเร็จ เริ่มการซิงค์...", 'green');

        $success = 0;
        $failed  = 0;
        $freed   = 0;

        foreach ($files as $idx => $f) {
            $current = $idx + 1;
            $rel = $f['rel'];
            $full = $f['full'];
            $size = $f['size'];

            $pathParts = pathinfo($rel);
            $filename  = $pathParts['basename'];
            $dir       = ($pathParts['dirname'] !== '.' && $pathParts['dirname'] !== '') ? $pathParts['dirname'] : '';
            $remoteSubPath = 'news' . ($dir !== '' ? '/' . str_replace('\\', '/', $dir) : '');

            CLI::print(" [{$current}/" . count($files) . "] กำลังอัปโหลด {$rel} ... ");

            $res = $remoteUpload->uploadLocalFile($full, $remoteSubPath, $filename);

            if (($res['status'] ?? '') === 'success') {
                $success++;
                if (! $keepLocal) {
                    @unlink($full);
                    $freed += $size;

                    // Clean empty parent folder
                    $parentDir = dirname($full);
                    if ($parentDir !== $baseDir && is_dir($parentDir)) {
                        $remaining = array_diff(scandir($parentDir), ['.', '..']);
                        if (empty($remaining)) {
                            @rmdir($parentDir);
                        }
                    }
                }
                CLI::write("สำเร็จ", 'green');
            } else {
                $failed++;
                CLI::write("ล้มเหลว (" . ($res['message'] ?? 'error') . ")", 'red');
            }
        }

        $freedMb = round($freed / (1024 * 1024), 2);
        CLI::newLine();
        CLI::write("=== การซิงค์เสร็จสิ้น ===", 'green');
        CLI::write("อัปโหลดสำเร็จ: {$success} ไฟล์");
        CLI::write("อัปโหลดล้มเหลว: {$failed} ไฟล์");
        if (! $keepLocal) {
            CLI::write("พื้นที่ว่างที่ได้คืนมา: {$freedMb} MB", 'yellow');
        }
    }
}

