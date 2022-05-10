INSERT INTO `user_role` (`role_id`, `role_name`) VALUES
(1, 'Admin'),
(2, 'Kasubbag TU'),
(3, 'Kepala Museum');

INSERT INTO `user` 
(`user_id`, `user_name`, `user_password`, `user_full_name`, `user_email`, `user_phone`, `user_role_role_id`, `user_address`, `user_created_date`, `user_last_update`, `user_deleted`) VALUES
(1, 'admin', '$2y$10$IO2T1M78n8kWFh9Xa78PfetOw4V1Ops4YFpuCBHDiA8CMpjwfK4c6', 'Administrator', 'admin@example.com', NULL, 1, NULL, NULL, NULL, 0),
(2, 'kasubbag', '$2y$10$IO2T1M78n8kWFh9Xa78PfetOw4V1Ops4YFpuCBHDiA8CMpjwfK4c6', 'Kepala Bagian Tata Usaha', 'kasubbag@example.com', NULL, 2, NULL, NULL, NULL, 0),
(3, 'kamus', '$2y$10$IO2T1M78n8kWFh9Xa78PfetOw4V1Ops4YFpuCBHDiA8CMpjwfK4c6', 'Kepala Museum', 'kamus@example.com', NULL, 3, NULL, NULL, NULL, 0);

INSERT INTO `setting_category` (`setting_category_id`, `setting_category_name`) VALUES
(1, 'General'),
(2, 'Email'),
(3, 'Image');

INSERT INTO `setting` (`setting_key`, `setting_value`, `setting_category_setting_category_id`) VALUES
('address', '', 1),
('admin_email', '', 1),
('app_name', '', 1),
('app_tagline', '', 1),
('bank_1', '', 1),
('bank_2', '', 1),
('bank_3', '', 1),
('cp_phone', '', 1),
('cp_bbm', '', 1),
('cp_whatsapp', '', 1),
('email_from', '', 2),
('email_from_name', '', 2),
('email_protocol', '', 2),
('email_smtp_host', '', 2),
('email_smtp_pass', '', 2),
('email_smtp_port', '', 2),
('email_smtp_timeout', '', 2),
('email_smtp_user', '', 2),
('socmed_fb', '', 1),
('socmed_instagram', '', 1),
('socmed_twitter', '', 1),
('img_favicon', NULL, 3), 
('img_logo', NULL, 3), 
('img_brand', NULL, 3);

INSERT INTO `setting` (`setting_key`, `setting_value`, `setting_category_setting_category_id`) VALUES 
('fb_id', NULL, '1');

INSERT INTO `reservasi_status` (`status_id`, `status_name`) VALUES 
('1', 'Baru'), 
('2', 'Proses'), 
('3', 'Disetujui'), 
('4', 'Ditolak'), 
('5', 'DIbatalkan');

INSERT INTO `reservasi_position` (`position_id`, `position_name`) VALUES 
('1', 'Kepala Bagian Tata Usaha'), 
('2', 'Kepala Museum'), 
('3', 'Kepala Bagian Tata Usaha');

INSERT INTO `catalog_category` (`catalog_category_id`, `catalog_category_name`, `catalog_category_created_date`, `catalog_category_last_update`, `user_user_id`) VALUES 
(1, 'Uncategorized', NULL, NULL, NULL);

INSERT INTO `posting_category` (`posting_category_id`, `posting_category_name`) VALUES 
(1, 'Uncategorized');

INSERT INTO `page` (`page_id`, `page_name`, `page_short_desc`, `page_content`, `page_is_published`, `page_image`, `user_user_id`, `page_created_date`, `page_last_update`) VALUES 
(1, 'faq', 'FAQ', 'FAQ', '0', NULL, NULL, NULL, NULL);