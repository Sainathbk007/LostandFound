# Lost & Found - PHP + MySQLi (Bootstrap 5)

This is a simple Lost & Found web application with a single Admin login (no user registration).

Features
- Public: View lost items, view found items, submit a lost item report, request/claim a found item (forms without login)
- Admin: Login, manage lost/found items (add/edit/delete/approve), manage requests, view dashboard stats

Tech
- PHP (MySQLi)
- MySQL (SQL dump provided)
- Bootstrap 5

Setup
1. Create a MySQL database and user.
2. Import the provided `db_dump.sql` into your database. Example (MySQL):

   mysql -u root -p < db_dump.sql

3. Configure database credentials

   - Copy `includes/config.example.php` to `includes/config.php` and update the values.
   - `includes/config.php` is ignored by `.gitignore` to avoid committing secrets.
   - `includes/db.php` will load `includes/config.php` if present, otherwise it falls back to default values.
4. Make sure `uploads/` is writable by your web server (for image uploads).
5. Verify and helper scripts

   - `test_upload.php` — quick page to verify `uploads/` is writable and to preview a sample image.
   - `tools/verify_references.php` — command-line PHP script that scans the project for include/require and local src/href references and reports missing targets.

   Run the verifier from a PHP-capable shell: `php tools/verify_references.php`
5. Place the project in your PHP server's www directory (e.g., XAMPP htdocs) and open `/` in a browser.

Admin
- Default admin username: `admin`
- Default password: `admin123`
- You should change the password after first login. Use PHP's `password_hash()` to generate a new hash if you edit the SQL dump.

Files of interest
- `includes/db.php` - database connection (MySQLi) with comments
- `index.php`, `lost.php`, `found.php`, `add_lost.php`, `request.php`, `contact.php` - public pages
- `admin/` - admin area (login, dashboard, management pages)
- `db_dump.sql` - SQL dump to create database and insert a sample admin
 - `db_sample_insert.sql` - optional sample insert that adds a 'found' item referencing `uploads/sample.svg` (edit columns if your schema differs)

Notes
- This project uses simple, minimal security for demonstration. For production, add CSRF protection, input sanitization, prepared statements everywhere, and HTTPS.

Quick checks after setup

- After importing your main `db_dump.sql`, optionally import `db_sample_insert.sql` to add a sample found item that points to `uploads/sample.svg`:

   mysql -u root -p < db_sample_insert.sql

- Open the quick test page to verify uploads and image serving:

   http://localhost/lost-and-found/test_upload.php

- Run the verifier to check for missing static references (from project root):

   php tools/verify_references.php

