# Facebook News Import by Link Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Allow administrators to import school news into `Admin/News` by simply pasting a Facebook post URL (link), automatically retrieving the headline, full text content, date, cover photo, and all album photos.

**Architecture:** 
1. Add backend URL parser and Graph API fetcher in `ConAdminNews::FetchFacebookByUrl` that resolves Facebook URLs (standard posts, permalinks, mobile share links), extracts the post ID, and retrieves post details + attachments from Facebook Graph API.
2. Extend `ConAdminNews::NewsAddFacebook` to support downloading multiple photos into `uploads/news/album/` and saving them into `tb_news_images`.
3. Enhance `ModalFacebook` in `PageAdminNewsMain.php` with a sleek URL input section, live preview of text and album thumbnails, and seamless save action using existing Bootstrap & Quill styling.

**Tech Stack:** PHP 8.3+, CodeIgniter 4, MySQL (`tb_news`, `tb_news_images`), Bootstrap 5, jQuery, Quill.js, SweetAlert2.

---

### Task 1: Add Facebook URL Parsing & Graph API Fetch Endpoint in Backend

**Files:**
- Modify: `app/Config/Routes.php` (register `Admin/News/FetchFacebookByUrl`)
- Modify: `app/Controllers/Admin/ConAdminNews.php` (implement `FetchFacebookByUrl` and helper methods for URL resolving & attachment extraction)

**Step-by-step:**
- [ ] Add route `$routes->post('News/FetchFacebookByUrl', 'ConAdminNews::FetchFacebookByUrl', ['filter' => 'permission:Admin']);` under the Admin group in `app/Config/Routes.php`.
- [ ] In `ConAdminNews.php`, implement `extractFacebookPostId($url)` helper:
  - Follow redirects for `facebook.com/share/p/...` or `fb.watch` to obtain the canonical URL.
  - Parse `story_fbid=X&id=Y` from query strings.
  - Parse `/posts/{postId}` or `/photos/{photoId}` from path.
  - Support both numeric IDs and alphanumeric `pfbid...` tokens.
- [ ] In `ConAdminNews.php`, implement `FetchFacebookByUrl()`:
  - Read input `url` from POST request.
  - Validate URL format.
  - Extract Post ID and query Facebook Graph API `/{target_id}?fields=id,message,created_time,full_picture,attachments{media,subattachments}&access_token={token}`.
  - Extract title (first line or first 100 characters), full message, created date, primary image, and array of album images from `attachments`.
  - Check `tb_news` to notify if this post was already imported (`is_saved`).
  - Return JSON with `status: true`, `data: [...]`.

---

### Task 2: Enhance NewsAddFacebook to Support Multi-Photo Album Downloads

**Files:**
- Modify: `app/Controllers/Admin/ConAdminNews.php` (`NewsAddFacebook`)

**Step-by-step:**
- [ ] In `ConAdminNews::NewsAddFacebook`, accept `news_album_images_facebook` (array of image URLs).
- [ ] Ensure `uploads/news/album/` folder exists and is writable.
- [ ] Iterate through `news_album_images_facebook`, download each image using `downloadFacebookImage()`, generate unique filename (`fb_album_...jpg`), and insert into `tb_news_images` table via `NewsImageModel`.
- [ ] Ensure transaction or proper error handling so that failed individual album images don't break the entire post import.

---

### Task 3: Upgrade UI in PageAdminNewsMain with Link Import & Album Preview

**Files:**
- Modify: `app/Views/Admin/PageAdminNews/PageAdminNewsMain.php`

**Step-by-step:**
- [ ] In `ModalFacebook`, update the modal header to "ดึงข่าวจาก Facebook (ผ่านลิงก์ หรือ เพจ)" and add a clean URL input field with a "ดึงข้อมูลจากลิงก์" button at the top.
- [ ] Add an accordion or divider allowing users to either:
  1. Paste a direct Facebook URL (Primary input)
  2. Select from recent posts of the school page (Secondary dropdown fallback)
- [ ] In the preview area (`#fb_preview`):
  - Add an album preview container showing thumbnails of all detected images in the post with a count badge.
  - Add hidden inputs for `news_album_images_facebook[]`.
- [ ] Add JavaScript event handler for clicking "ดึงข้อมูลจากลิงก์":
  - Validate non-empty URL.
  - Show loading state / spinner.
  - Send POST request to `Admin/News/FetchFacebookByUrl`.
  - Populate title, date, category, Quill editor, cover image, and album thumbnails.
- [ ] Ensure form submission passes both cover photo and album photos to `Admin/News/Add/NewsFacebook`.

---

### Task 4: Verification and Testing

**Files:**
- Test URL parsing with test script in `scratch/test_fb_parser.php`.
- Test Facebook API response formatting and fallback handling.
- Verify CodeIgniter routes and controller syntax.

