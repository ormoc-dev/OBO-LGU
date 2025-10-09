USE `obo_db`;

-- Seed an initial admin user (password: admin123)
INSERT INTO `users` (`name`,  `password`, `role`, `status`) VALUES
(
    'admin', 
    'admin', 
    'admin',
    'active'
);

-- Note: The hash corresponds to bcrypt of 'admin123'. Change after first login.