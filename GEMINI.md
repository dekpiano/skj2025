# Gemini CLI: Project Context & Guidelines for skj2022

This document provides the context and rules for the Gemini CLI to ensure consistency and adherence to the project's standards, particularly for UX/UI design and development.

## 1. Project Overview

- **Project Name:** SKJ School Website (skj2022)
- **Description:** A web application for a school (likely named SKJ) that includes a public-facing website and a backend admin panel for content management.
- **Architecture:** Standard MVC (Model-View-Controller).

## 2. Technology Stack

- **Backend:** PHP (v7.4 || v8.0)
- **Framework:** CodeIgniter 4
- **Frontend:** HTML, CSS, JavaScript
- **CSS Framework:** Bootstrap (as seen in `assets/css/bootstrap.min.css`)
- **Database:** MySQL (via MySQLi driver)

## 3. Database Structure

The application connects to three distinct databases:

1.  **`skjacth_skj` (Default):** The primary database for main website content like news, pages, and banners.
2.  **`skjacth_personnel` (Personnel):** Dedicated to managing all personnel and teacher information.
    - **Table:** `tb_personnel`
3.  **`skjacth_academic` (Academic):** Dedicated to managing academic data, such as subjects and student grades.
    - **Tables:** `tb_students`, `tb_subjects`, `tb_register`

## 4. UX/UI Design Guidelines

The primary goal is to maintain and extend the existing visual style for a consistent user experience.

- **Framework:** All new UI components **must** be built using the existing **Bootstrap** framework and its conventions.
- **Consistency:** New pages and components should mimic the style, layout, and structure of existing pages (e.g., `PageNews`, `PagePersonnal`).
- **Layout:** Adhere to the main layout defined in `app/Views/layout/`. All new views should integrate into this structure.
- **Color Palette:** Use the existing color scheme defined in `assets/css/style.css`. Do not introduce new colors without explicit instruction.
- **Typography:** Use the fonts and typography styles already established in `assets/css/style.css`.
- **Responsiveness:** All UI elements must be fully responsive and work on all screen sizes, following the patterns in `assets/css/media.css`.

## 5. Development Rules

- **Framework Conventions:** Strictly follow CodeIgniter 4 best practices and coding standards.
- **MVC Pattern:**
    - **Controllers (`app/Controllers`):** Should contain business logic.
    - **Models (`app/Models`):** Should only handle database interactions.
    - **Views (`app/Views`):** Should only handle presentation logic.
- **Routing:** Define all new routes in `app/Config/Routes.php`. Do not use auto-routing.
- **Database Interaction:** When interacting with a specific database, ensure the correct database group (`default`, `personnal`, `academic`) is used in the model.
- **Security:** Apply standard security practices, including CSRF protection and input validation as already implemented in the project.
