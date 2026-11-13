# Redesign Facebook News Import UX/UI & Form Spacing Balance Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

## Overview
1. Fix form floating label balance globally across the entire admin system so that inputs, select boxes, and labels have proportionate, harmonious vertical alignment (no awkward gaps or bottom-heavy text).
2. Upgrade `ModalFacebook` in `PageAdminNewsMain.php`:
   - Expand from `modal-lg` to `modal-xl` with responsive generous width.
   - Design a luxury modern Facebook Header (Royal Blue / Indigo gradient with branding badge).
   - Implement an intuitive dual-method selector (Direct URL Paste vs Recent Page Posts Dropdown).
   - Redesign the Live Preview into a spacious 2-column balanced layout (60% news content, 40% cover photo & interactive album grid).
   - Keep all existing IDs and JS event hooks fully functional.

---

## File Structure & Responsibilities
- `assets/admin/assets/css/admin-luxury-theme.css`:
  Global styles for `.form-floating`, `.form-floating-outline`, `.form-control`, `.form-select`, and custom Facebook modal enhancements.
- `app/Views/Admin/PageAdminNews/PageAdminNewsMain.php`:
  The view containing `ModalFacebook` with new spacious structure, improved labels, and visual cards.
- `app/Views/Admin/layout/AdminHeader.php`:
  Cache bust query string update (`?v=1.2`) to ensure immediate browser rendering.

---

## Tasks

### Task 1: Refine Form Floating Balance & Alignment in `admin-luxury-theme.css`
- [x] Adjust `.form-floating` and `.form-floating-outline` vertical padding and line-height:
  - Set height: `calc(3.35rem + 2px)` (~56px) with `padding-top: 1.35rem` and `padding-bottom: 0.45rem` to keep the text vertically centered in the lower area.
  - Set floating label transform to `scale(0.78) translateY(-0.6rem)` with `font-weight: 600` so it sits proportionally at the top without crowding the value.
  - Ensure `.form-select` has `padding-right: 2.25rem` so arrow icons never overlap text.
  - Ensure standard non-floating `.form-control` and `.form-select` remain balanced with `min-height: 42px` and `padding: 0.65rem 0.95rem`.
- [x] Add luxury styling utilities for Facebook Modal (gradient header, pill badges, preview cards, interactive album thumbnails).

### Task 2: Redesign `ModalFacebook` in `PageAdminNewsMain.php`
- [x] Change `modal-dialog modal-lg` to `modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable`.
- [x] Rebuild Modal Header:
  - Luxury gradient `#1877f2` to `#4338ca`.
  - Icon, bold white title "ดึงข่าวจาก Facebook Page", subtitle explaining the automated media download.
- [x] Restructure Input Section:
  - Top card: Modern URL input with integrated search button, clear helper text.
  - Clean collapsible dropdown selector for recent page posts with clear status indicator.
- [x] Restructure Live Preview Area:
  - Left column (col-lg-7):
    - Row with News Date and Category side-by-side.
    - News Topic input.
    - Rich text editor with comfortable height (250px).
  - Right column (col-lg-5):
    - Large cover photo card with "ภาพหน้าปกหลัก" badge and hover indicator.
    - Album preview grid card with photo count badge and clear caption.
- [x] Preserve all existing form field names and element IDs so backend API and JavaScript continue working without changes.

### Task 3: Cache Busting & Verification
- [x] Update `AdminHeader.php` stylesheet version to `admin-luxury-theme.css?v=1.2`.
- [x] Verify HTML structure and syntax of `PageAdminNewsMain.php`.
- [x] Verify that opening `ModalFacebook` renders in full `modal-xl` width with balanced forms.
