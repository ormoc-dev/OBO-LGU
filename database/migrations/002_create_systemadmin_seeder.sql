USE `lgu_annual_inspection`;

-- Seed an initial admin user (password: admin123)
INSERT INTO `users` (`name`,  `password`, `role`, `status`) VALUES
(
    'Systemadmin', 
    'admin123', 
    'systemadmin',
    'active'
);

-- Note: The hash corresponds to bcrypt of 'admin123'. Change after first login.