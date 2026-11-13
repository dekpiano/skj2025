# Admin Backend Mobile-First Architecture Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Transform the SKJ Admin backend into a responsive, touch-friendly, Mobile-First experience for smartphone users, featuring a persistent Mobile Bottom Navigation Bar, touch-optimized DataTables, responsive bottom-sheet modals, scrollable Quill editor, and finger-friendly UI targets.

**Architecture:**
- **Layout Foundation:** Add a fixed-bottom glassmorphism Mobile Bottom Navigation Bar in `AdminLayout.php`/`AdminFooter.php` with safe-area insets, active state indicators, and Quick Action bottom sheet.
- **Responsive Top Navbar:** Refactor `AdminNavbar.php` on `< 768px` viewports with collapsible search, touch-padded avatar, and optimized navbar spacing.
- **Styling & Touch Engine:** Enhance `admin-luxury-theme.css` with mobile-first breakpoints (`@media (max-width: 767.98px)` and `@media (max-width: 575.98px)`), smooth touch scrolling for tables, horizontal scrolling for Quill toolbar, sticky modal action footers, and minimum 44px touch targets.
- **Table & Card Optimization:** Add mobile responsive wrappers for DataTables, pagination flex-stacking, and action button pill groups.

**Tech Stack:** Bootstrap 5, Sneat Admin Template, CodeIgniter 4, jQuery, DataTables 2.0+, Quill.js, Boxicons.

**Spec:** User requirement for comprehensive Mobile-First backend transformation across all admin features.

## Global Constraints
- Must adhere to Bootstrap 5 responsive utility classes (`d-block d-md-none`, `d-none d-md-flex`, etc.).
- Maintain luxury theme styling consistency (`admin-luxury-theme.css`).
- Safe-area insets (`env(safe-area-inset-bottom)`) must be respected for iPhone notch/home bar.
- Do not break desktop layout (`>= 768px` or `>= 1200px`); desktop behavior must remain intact.

## Review Focus
1. Mobile Bottom Bar overlap: Content must have sufficient bottom padding (`pb-5 mb-4`) so content or submit buttons are not hidden under the bottom bar.
2. Virtual keyboard popping up: Input focus must not clip modals or bottom sheets offscreen.
3. DataTable horizontal scrolling: Wide tables must scroll smoothly without breaking the container page width.
4. Sneat offcanvas menu: Triggering the sidebar menu from the bottom bar must work seamlessly with the existing Sneat menu JS overlay.
5. Touch targets: All icons, buttons, and dropdown links must be easily tappable on a 360px-430px smartphone screen.

---

### Task 1: Mobile Bottom Navigation Bar & Quick Action Sheet

**Files:**
- Modify: `app/Views/Admin/layout/AdminLayout.php`
- Modify: `app/Views/Admin/layout/AdminFooter.php`
- Modify: `assets/admin/assets/css/admin-luxury-theme.css`

**Steps:**
- [x] Add `#mobile-bottom-nav` markup in `AdminLayout.php` with 5 touch tabs:
  1. Dashboard (`Admin/Dashboard`)
  2. News (`Admin/News`)
  3. Quick Action FAB (`+` button opening Quick Action Sheet)
  4. Public Website (`base_url('/')` in new tab)
  5. Menu Drawer (Triggers Sneat offcanvas menu `.layout-menu-toggle`)
- [x] Add `#quickActionModal` Bottom Sheet modal in `AdminLayout.php` (Actions: "เพิ่มข่าวใหม่", "ดึงข่าวจาก Facebook", "จัดการแบนเนอร์", "เปิดหน้าเว็บไซต์")
- [x] Style `#mobile-bottom-nav` in `admin-luxury-theme.css` with frosted glass background (`backdrop-filter: blur(16px)`), z-index 1080, rounded top border, safe-area inset, and active pill highlights.
- [x] Add bottom content clearance (`.content-wrapper { padding-bottom: 75px; }` on `< 768px`).
- [x] Add JS handler in `AdminFooter.php` so tapping the bottom "เมนู" tab smoothly triggers `Helpers.toggleCollapsed()`.

---

### Task 2: Top Navbar & Header Mobile Optimization

**Files:**
- Modify: `app/Views/Admin/layout/AdminHeader.php`
- Modify: `app/Views/Admin/layout/AdminNavbar.php`
- Modify: `assets/admin/assets/css/admin-luxury-theme.css`

**Steps:**
- [x] In `AdminHeader.php`, ensure `viewport-fit=cover` and user-scalable accessibility.
- [x] In `AdminNavbar.php`, optimize search input on `< 768px` (collapsible icon toggle or streamlined width).
- [x] Enlarge user avatar button touch target to 44x44px.
- [x] Style user dropdown menu on mobile so it anchors neatly within the viewport without horizontal overflow.

---

### Task 3: Mobile DataTables, Filter Toolbars & Modals

**Files:**
- Modify: `assets/admin/assets/css/admin-luxury-theme.css`
- Modify: `app/Views/Admin/PageAdminNews/PageAdminNewsMain.php`

**Steps:**
- [x] Add smooth touch scrolling for `.table-responsive` (`-webkit-overflow-scrolling: touch;`).
- [x] Add visual swipe hint / scroll gradient on tables when overflowing.
- [x] Stack DataTable search box, length dropdown, and pagination cleanly on `< 768px`.
- [x] In `PageAdminNewsMain.php`, make top action buttons ("เพิ่มข่าว", "ดึงจาก Facebook", "Sync Cloud") stack as full-width or auto-grid pills on `< 576px`.
- [x] In `admin-luxury-theme.css`, style modals on mobile (`< 768px`) with bottom-sheet appearance, `border-radius: 24px 24px 0 0`, sticky header, scrollable body, and sticky footer.

---

### Task 4: Mobile Quill Rich Text Editor & Form Touch Enhancements

**Files:**
- Modify: `assets/admin/assets/css/admin-luxury-theme.css`

**Steps:**
- [x] Add horizontal scrolling to `.ql-toolbar` on mobile screens with `-webkit-overflow-scrolling: touch` and hidden scrollbar.
- [x] Ensure font-size on all mobile inputs and floating labels is at least `16px` to prevent iOS Safari auto-zoom.
- [x] Increase tap padding on `.btn`, `.dropdown-item`, and checkbox/switch labels.

---

### Task 5: Verification & Integration Testing

**Files:**
- Test: Responsive viewports (375px, 414px, 768px, 1200px)
- Test: All interactive admin components (Bottom Nav, Sneat Menu Drawer, Quick Action, Modals, DataTables)
- Command: Git status check & verification

**Steps:**
- [x] Verify bottom navigation bar displays strictly on screens `< 768px` and hides on desktop.
- [x] Verify tapping "เมนู" tab on mobile opens the Sneat sidebar offcanvas smoothly.
- [x] Verify Quick Action sheet opens and links navigate correctly.
- [x] Verify News management table scrolls cleanly without breaking layout width.
- [x] Verify News Facebook import modal and News Add/Edit modals display comfortably on 375px viewport.
- [x] Confirm no regressions on desktop layout (`>= 768px`).
