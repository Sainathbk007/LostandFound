-- Sample insert for a found item referencing uploads/sample.svg
-- Adjust column names/types to match your actual schema if needed

INSERT INTO `found` (`item_name`, `description`, `image`, `reported_by`, `reported_at`, `status`) VALUES
('Blue Notebook', 'A blue spiral notebook found in the library.', 'sample.svg', 'site', NOW(), 'available');

-- If your table uses different columns, edit this file accordingly before importing.
