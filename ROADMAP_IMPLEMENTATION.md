# PC Builder – Roadmap implementation

This project has been updated to follow the roadmap: custom PC builder + admin inventory, while **keeping the same theme** (black, green, Roboto Mono on the user site; amber/slate on the admin panel).

## 1. Run the database migration (required)

Run **once** on your existing `wp_project` database:

```sql
-- In phpMyAdmin or MySQL client, run the contents of:
database_migration.sql
```

This adds:

- `user.role` (user/admin)
- For each component table: `stock`, `image_url`, and compatibility/spec columns (`socket_type`, `ram_type`, `wattage`, `form_factor`, `description`)
- Tables: `builds`, `build_items`

If a column already exists (e.g. you run the migration twice), you may see “Duplicate column” errors for that line; you can ignore or comment out those lines.

---

## 2. Core features (implemented)

### User side

- **Create account / Login** – Already present; signup collects full details (name, email, phone, address, city, state, country, zip).
- **Browse components by category** – **COMPONENTS** in the nav → filter by CPU, GPU, Motherboard, RAM, Storage, PSU, Case, Cooling; search within category.
- **Add components to build** – Custom Rig page: searchable dropdowns per category; “Add to build” from Components page links to builder.
- **Compatibility validation** – On the builder, when you select CPU, Motherboard, RAM, PSU, compatibility messages appear (e.g. CPU socket vs motherboard socket, RAM type; PSU wattage). Warnings in red, OK in green.
- **Total price** – Updates dynamically as you select parts.
- **Save build** – Logged-in users see a **Save build** button; current selection is saved to **My builds**.
- **Add build to cart** – **Place Order** continues to use the existing cart/checkout flow.
- **Order history** – Dashboard → **Order history** lists past orders.
- **My builds** – Dashboard → **My builds** lists saved builds with parts and total.

### Admin side

- **Admin login** – `admin_login.php` (unchanged; e.g. admin / password123).
- **Add components** – **Components** in admin sidebar → choose category → **Add** → name, price, stock, image upload, optional specs (socket, RAM type, wattage, form factor).
- **Edit component** – In each category list, **Edit** → change name, price, stock, image, specs.
- **Delete component** – **Delete** in the list (with confirmation).
- **Upload images** – Add/Edit forms support image upload; stored under `images/components/{category}/`.
- **Manage stock** – Stock field in Add/Edit component forms.
- **View orders** – **Manage Orders** in admin sidebar.
- **Manage users** – **Manage Users** in admin sidebar.

---

## 3. Tech stack (unchanged)

- **Frontend:** HTML, CSS, JavaScript (same theme: black, green, Roboto Mono).
- **Backend:** PHP.
- **Database:** MySQL (same `wp_project` schema + migration).
- **Hosting:** Works on XAMPP / any PHP+MySQL host (e.g. cPanel).

---

## 4. New / updated files

| File | Purpose |
|------|--------|
| `database_migration.sql` | One-time DB migration (run manually). |
| `config/categories.php` | Category → table mapping for components. |
| `includes/admin_sidebar.php` | Shared admin sidebar. |
| `admin_components.php` | Admin: list categories and component counts. |
| `admin_components_list.php` | Admin: list components in one category. |
| `admin_component_add.php` | Admin: add component form. |
| `admin_component_edit.php` | Admin: edit component form. |
| `admin_component_delete.php` | Admin: delete component (POST). |
| `components.php` | User: browse components by category + search. |
| `styles/components.css` | Styles for components browse page. |
| `save_build.php` | Save current builder selection to `builds` + `build_items`. |
| `my_builds.php` | User: list saved builds. |
| `order_history.php` | User: list order history. |
| `styles/order_history.css` | Styles for order history / my builds. |

Navigation: **COMPONENTS** added; dashboard has **My builds** and **Order history**. Builder: compatibility message div, **Save build** button (when logged in), and optional success/error messages.

---

## 5. Security notes

- Passwords hashed with `password_hash()` (signup/login).
- Admin routes check `$_SESSION['admin_logged_in']`.
- User routes check `$_SESSION['customer']` where needed.
- Input escaped for output (`htmlspecialchars`, `mysqli_real_escape_string`). For production, consider prepared statements everywhere and stricter upload validation.

---

## 6. Optional next steps (roadmap “later”)

- Reduce stock when an order is placed.
- Stripe (or other) payment integration.
- Admin: analytics dashboard, bulk edit.
- User: wishlist, compare components, prebuilt configs.
- Stronger compatibility engine (e.g. estimated power draw, case clearance).

Your existing flow (custom rig → cart → place order) is unchanged; new features (components browse, save build, compatibility, order history, admin inventory) are added on top with the same theme.
