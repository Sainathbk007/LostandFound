-- Migration: add student_college_id and image columns to lost_items
ALTER TABLE `lost_items`
  ADD COLUMN `student_college_id` VARCHAR(100) NOT NULL AFTER `contact_info`,
  ADD COLUMN `image` VARCHAR(255) DEFAULT NULL AFTER `student_college_id`;

-- Make sure to run this against your lost_and_found database:
-- mysql -u root -p lost_and_found < db_migrate_add_lost_fields.sql
