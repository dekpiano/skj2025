# News Images Remote Sync (Freeing Local Disk Space) Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

## Overview
Implement an automated synchronization system to migrate ~1,498 legacy local news images (~627 MB) from `uploads/news/` (including `news/detail/` and `news/album/`) to the remote cloud server (`https://skj.nsnpao.go.th/uploads/`), with safe verification and local file deletion to reclaim server disk space.

Provides both:
1. **Web Admin UI**: An interactive batching modal with live progress bar and pause/resume capability, running batches of 10-15 files via AJAX to prevent timeouts.
2. **Spark CLI Command**: `php spark news:sync-remote` for administrators who prefer running a single fast background process from terminal.

---

## File Structure & Responsibilities
- `app/Controllers/Admin/ConAdminNews.php`:
  - `SyncImagesStatus()`: Scans local `uploads/news/` directory and returns count & total MB.
  - `SyncImagesBatch()`: Uploads a batch of files via `RemoteUploadService::uploadLocalFile()` and safely deletes the local file on successful verification.
- `app/Commands/SyncNewsImages.php`:
  - Spark command `news:sync-remote` with `--delete-local` and `--limit` options.
- `app/Config/Routes.php`:
  - Add routes for `Admin/News/SyncImagesStatus` and `Admin/News/SyncImagesBatch`.
- `app/Views/Admin/PageAdminNews/PageAdminNewsMain.php`:
  - Add "ซิงค์รูปภาพขึ้น Cloud" button and interactive modal `#ModalSyncNewsImages` with live progress bar and status counter.

---

## Tasks

### Task 1: Controller Endpoints & Route Definitions
- [x] Add `Admin/News/SyncImagesStatus` and `Admin/News/SyncImagesBatch` to `app/Config/Routes.php`.
- [x] In `ConAdminNews.php`, implement `SyncImagesStatus()`:
  - Recursively scan `uploads/news/` for images (`jpg`, `jpeg`, `png`, `webp`, `gif`).
  - Calculate total count and total megabytes.
  - Return JSON summary.
- [x] In `ConAdminNews.php`, implement `SyncImagesBatch()`:
  - Read batch of files (default 10 files per request).
  - Determine relative path within `uploads/news/` (e.g. `news/detail/2021-03-31/sample.jpg`).
  - Upload via `RemoteUploadService::uploadLocalFile()`.
  - When status is 'success', safely unlink local file and clean up empty parent directories.
  - Return JSON with processed count, success count, bytes freed, and remaining files.

### Task 2: CodeIgniter 4 Spark Command
- [x] Create `app/Commands/SyncNewsImages.php` (`news:sync-remote`):
  - Command options: `--delete-local` (default true) and `--dry-run`.
  - Display progress bar and summary in terminal.

### Task 3: Admin Web UI in `PageAdminNewsMain.php`
- [x] Add "ซิงค์รูปภาพขึ้น Cloud" action button in the news list toolbar.
- [x] Add `#ModalSyncNewsImages` modal:
  - Info card showing local news image count and disk space.
  - Checkbox: "ลบไฟล์ในเครื่องออกหลังจากอัปโหลดสำเร็จ (เพื่อลดพื้นที่)".
  - Animated Progress Bar (0% to 100%), counter "กำลังประมวลผล X / Y รูป", and freed MB counter.
  - Start, Pause, and Close buttons.
- [x] Add JavaScript logic in `PageAdminNewsMain.php`:
  - Fetch status on modal open.
  - Recursive AJAX batching loop with error handling and retry.
  - Update progress bar and disk space freed smoothly.

### Task 4: Verification & Testing
- [x] Test status endpoint and ensure it returns accurate file count and size.
- [x] Test single-file batch sync with remote server and verify remote response.
- [x] Verify that `news_image_url()` loads the image correctly from remote server after local deletion.
