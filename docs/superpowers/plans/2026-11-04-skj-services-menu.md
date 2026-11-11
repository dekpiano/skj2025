# SKJ Services Menu Restructuring & Guard Check Integration Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Reorganize the "SKJ บริการ" (SKJ Services) navigation menu across desktop and mobile navbars into 4 school administrative departments (วิชาการ, ทั่วไป, บุคคล, งบประมาณและแผน) and integrate the new Guard Check service (`https://guardcheck.skj.ac.th/`).

**Architecture:** Update CodeIgniter 4 view templates (`app/Views/User/Home/navbar.php` and `app/Views/User/layout/navbar.php`) adhering to existing Bootstrap grid, icons, and styling classes (`dropdown-menu-skj`, `mega-menu`, and `mob-dropdown`).

**Tech Stack:** PHP, CodeIgniter 4, Bootstrap 5, Bootstrap Icons.

**Spec:** User requested adding `https://guardcheck.skj.ac.th/` named `Guard Check (ระบบตรวจเวร)` and restructuring services into 4 school administrative groups.

## Global Constraints
- Strictly preserve existing links and targets (`target="_blank"` where applicable).
- Adhere to Bootstrap layout and responsive CSS patterns.
- Do not break HTML markup or nested tags.

---

### Task 1: Update Home Navbar (`app/Views/User/Home/navbar.php`)
- [x] Replace the 5 uneven categories in `app/Views/User/Home/navbar.php` (lines 867-935) with the clean 4-department single-row structure.
- [x] Add `Guard Check (ระบบตรวจเวร)` (`https://guardcheck.skj.ac.th/`) under "กลุ่มบริหารทั่วไป" with `target="_blank"`.

### Task 2: Update Layout Navbar - Desktop & Mobile (`app/Views/User/layout/navbar.php`)
- [x] Update Desktop Mega Menu in `app/Views/User/layout/navbar.php` (lines 129-185) with the 4-department structure.
- [x] Update Mobile Menu in `app/Views/User/layout/navbar.php` (lines 384-428) with the 4-department structure.
- [x] Include `Guard Check (ระบบตรวจเวร)` in both desktop and mobile layouts.

### Task 3: Verification & Syntax Validation
- [x] Run tag parity & balance verification on both updated navbar files.
- [x] Verify HTML tag nesting and Bootstrap grid balance via git diff.
