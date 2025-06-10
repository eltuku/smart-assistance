-- Database migration for role-based user management
-- Add role column to users table if it doesn't exist
ALTER TABLE `users` ADD COLUMN IF NOT EXISTS `role` ENUM('admin', 'preceptor', 'padre') NOT NULL DEFAULT 'admin';

-- Update existing admin user to have admin role
UPDATE `users` SET `role` = 'admin' WHERE `username` = 'admin';

-- Create parent_student relationship table
CREATE TABLE IF NOT EXISTS `parent_student` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_user_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_parent_student` (`parent_user_id`, `student_id`),
  KEY `parent_user_id` (`parent_user_id`),
  KEY `student_id` (`student_id`),
  CONSTRAINT `fk_parent_user` FOREIGN KEY (`parent_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_student` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
