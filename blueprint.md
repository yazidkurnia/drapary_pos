# Blueprint for Laravel POS Project

## 1. Overview
This is a Laravel-based Point of Sale (POS) application designed for managing sales transactions. The application utilizes the Stisla admin template for its user interface, providing a modern and responsive dashboard experience.

## 2. Project Outline
*   **Current State:** The project is a standard Laravel MVC application.
*   **Assets:** Stisla template assets (CSS, JS, Images, Modules) are located in the `public/stisla-assets/` directory.
*   **Layouts:** A base layout is established in `resources/views/layouts/app.blade.php`, which includes common partials like navbar, sidebar, and footer.
*   **Views:** Page-specific content is organized within `resources/views/pages/`, such as the POS dashboard.
*   **Structure:** Follows standard Laravel conventions for routing (`routes/web.php`), controllers (`app/Http/Controllers/`), and models (`app/Models/`).

## 3. Current Request Plan
### Fix CSS Loading Issues
*   Audit `resources/views/layouts/app.blade.php` to ensure all `<link>` tags for Bootstrap, FontAwesome, and Stisla core CSS use the correct `asset()` paths pointing to `public/stisla-assets/`.
*   Ensure that core Bootstrap CSS is loaded from `stisla-assets/modules/bootstrap/css/bootstrap.min.css`.

### Improve POS Page Layout
*   Refine `resources/views/pages/pos/index.blade.php` to optimize the product grid and shopping cart UX.
*   Ensure product cards are responsive and visually consistent with the Stisla theme.
*   Check image paths for products to ensure they render correctly.

### Verify JavaScript Dependencies
*   Confirm that essential scripts (jQuery, Popper, Bootstrap JS, Nicescroll, Stisla core JS) are correctly linked in the layout footer.
*   Ensure `@stack('script')` is available for page-specific logic like cart interactions.