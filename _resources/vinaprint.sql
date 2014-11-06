-- Adminer 4.1.0 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `wp_commentmeta`;
CREATE TABLE `wp_commentmeta` (
  `meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `comment_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `meta_key` varchar(255) DEFAULT NULL,
  `meta_value` longtext,
  PRIMARY KEY (`meta_id`),
  KEY `comment_id` (`comment_id`),
  KEY `meta_key` (`meta_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `wp_comments`;
CREATE TABLE `wp_comments` (
  `comment_ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `comment_post_ID` bigint(20) unsigned NOT NULL DEFAULT '0',
  `comment_author` tinytext NOT NULL,
  `comment_author_email` varchar(100) NOT NULL DEFAULT '',
  `comment_author_url` varchar(200) NOT NULL DEFAULT '',
  `comment_author_IP` varchar(100) NOT NULL DEFAULT '',
  `comment_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comment_date_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comment_content` text NOT NULL,
  `comment_karma` int(11) NOT NULL DEFAULT '0',
  `comment_approved` varchar(20) NOT NULL DEFAULT '1',
  `comment_agent` varchar(255) NOT NULL DEFAULT '',
  `comment_type` varchar(20) NOT NULL DEFAULT '',
  `comment_parent` bigint(20) unsigned NOT NULL DEFAULT '0',
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`comment_ID`),
  KEY `comment_post_ID` (`comment_post_ID`),
  KEY `comment_approved_date_gmt` (`comment_approved`,`comment_date_gmt`),
  KEY `comment_date_gmt` (`comment_date_gmt`),
  KEY `comment_parent` (`comment_parent`),
  KEY `comment_author_email` (`comment_author_email`(10))
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `wp_links`;
CREATE TABLE `wp_links` (
  `link_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `link_url` varchar(255) NOT NULL DEFAULT '',
  `link_name` varchar(255) NOT NULL DEFAULT '',
  `link_image` varchar(255) NOT NULL DEFAULT '',
  `link_target` varchar(25) NOT NULL DEFAULT '',
  `link_description` varchar(255) NOT NULL DEFAULT '',
  `link_visible` varchar(20) NOT NULL DEFAULT 'Y',
  `link_owner` bigint(20) unsigned NOT NULL DEFAULT '1',
  `link_rating` int(11) NOT NULL DEFAULT '0',
  `link_updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `link_rel` varchar(255) NOT NULL DEFAULT '',
  `link_notes` mediumtext NOT NULL,
  `link_rss` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`link_id`),
  KEY `link_visible` (`link_visible`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `wp_options`;
CREATE TABLE `wp_options` (
  `option_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `option_name` varchar(64) NOT NULL DEFAULT '',
  `option_value` longtext NOT NULL,
  `autoload` varchar(20) NOT NULL DEFAULT 'yes',
  PRIMARY KEY (`option_id`),
  UNIQUE KEY `option_name` (`option_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `wp_postmeta`;
CREATE TABLE `wp_postmeta` (
  `meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `meta_key` varchar(255) DEFAULT NULL,
  `meta_value` longtext,
  PRIMARY KEY (`meta_id`),
  KEY `post_id` (`post_id`),
  KEY `meta_key` (`meta_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `wp_postmeta` (`meta_id`, `post_id`, `meta_key`, `meta_value`) VALUES
(89,	29,	'_edit_last',	'1'),
(92,	29,	'position',	'normal'),
(93,	29,	'layout',	'default'),
(94,	29,	'hide_on_screen',	''),
(95,	29,	'_edit_lock',	'1415000492:1'),
(237,	29,	'field_5451fd2b015d1',	'a:14:{s:3:\"key\";s:19:\"field_5451fd2b015d1\";s:5:\"label\";s:11:\"Paper Types\";s:4:\"name\";s:11:\"paper_types\";s:4:\"type\";s:12:\"relationship\";s:12:\"instructions\";s:0:\"\";s:8:\"required\";s:1:\"0\";s:13:\"return_format\";s:6:\"object\";s:9:\"post_type\";a:1:{i:0;s:10:\"paper_type\";}s:8:\"taxonomy\";a:1:{i:0;s:3:\"all\";}s:7:\"filters\";a:1:{i:0;s:6:\"search\";}s:15:\"result_elements\";a:1:{i:0;s:9:\"post_type\";}s:3:\"max\";s:0:\"\";s:17:\"conditional_logic\";a:3:{s:6:\"status\";s:1:\"0\";s:5:\"rules\";a:1:{i:0;a:3:{s:5:\"field\";s:4:\"null\";s:8:\"operator\";s:2:\"==\";s:5:\"value\";s:0:\"\";}}s:8:\"allorany\";s:3:\"all\";}s:8:\"order_no\";i:0;}'),
(248,	29,	'field_54520227d607e',	'a:14:{s:3:\"key\";s:19:\"field_54520227d607e\";s:5:\"label\";s:11:\"Print Types\";s:4:\"name\";s:11:\"print_types\";s:4:\"type\";s:12:\"relationship\";s:12:\"instructions\";s:0:\"\";s:8:\"required\";s:1:\"0\";s:13:\"return_format\";s:6:\"object\";s:9:\"post_type\";a:1:{i:0;s:10:\"print_type\";}s:8:\"taxonomy\";a:1:{i:0;s:3:\"all\";}s:7:\"filters\";a:1:{i:0;s:6:\"search\";}s:15:\"result_elements\";a:1:{i:0;s:9:\"post_type\";}s:3:\"max\";s:0:\"\";s:17:\"conditional_logic\";a:3:{s:6:\"status\";s:1:\"0\";s:5:\"rules\";a:1:{i:0;a:3:{s:5:\"field\";s:4:\"null\";s:8:\"operator\";s:2:\"==\";s:5:\"value\";s:0:\"\";}}s:8:\"allorany\";s:3:\"all\";}s:8:\"order_no\";i:1;}'),
(329,	29,	'field_54572baab593b',	'a:14:{s:3:\"key\";s:19:\"field_54572baab593b\";s:5:\"label\";s:11:\"Paper Types\";s:4:\"name\";s:11:\"paper_types\";s:4:\"type\";s:12:\"relationship\";s:12:\"instructions\";s:0:\"\";s:8:\"required\";s:1:\"0\";s:13:\"return_format\";s:6:\"object\";s:9:\"post_type\";a:1:{i:0;s:10:\"paper_type\";}s:8:\"taxonomy\";a:1:{i:0;s:3:\"all\";}s:7:\"filters\";a:1:{i:0;s:6:\"search\";}s:15:\"result_elements\";a:1:{i:0;s:9:\"post_type\";}s:3:\"max\";s:0:\"\";s:17:\"conditional_logic\";a:3:{s:6:\"status\";s:1:\"0\";s:5:\"rules\";a:1:{i:0;a:2:{s:5:\"field\";s:4:\"null\";s:8:\"operator\";s:2:\"==\";}}s:8:\"allorany\";s:3:\"all\";}s:8:\"order_no\";i:2;}'),
(331,	29,	'field_54572bca6886e',	'a:12:{s:3:\"key\";s:19:\"field_54572bca6886e\";s:5:\"label\";s:11:\"Price Table\";s:4:\"name\";s:11:\"price_table\";s:4:\"type\";s:11:\"post_object\";s:12:\"instructions\";s:0:\"\";s:8:\"required\";s:1:\"0\";s:9:\"post_type\";a:1:{i:0;s:16:\"tablepress_table\";}s:8:\"taxonomy\";a:1:{i:0;s:3:\"all\";}s:10:\"allow_null\";s:1:\"0\";s:8:\"multiple\";s:1:\"0\";s:17:\"conditional_logic\";a:3:{s:6:\"status\";s:1:\"0\";s:5:\"rules\";a:1:{i:0;a:2:{s:5:\"field\";s:4:\"null\";s:8:\"operator\";s:2:\"==\";}}s:8:\"allorany\";s:3:\"all\";}s:8:\"order_no\";i:3;}'),
(373,	29,	'rule',	'a:5:{s:5:\"param\";s:9:\"post_type\";s:8:\"operator\";s:2:\"==\";s:5:\"value\";s:7:\"product\";s:8:\"order_no\";i:0;s:8:\"group_no\";i:0;}'),
(1108,	154,	'_edit_last',	'1'),
(1109,	154,	'field_545735847e0fc',	'a:14:{s:3:\"key\";s:19:\"field_545735847e0fc\";s:5:\"label\";s:13:\"Product Lists\";s:4:\"name\";s:13:\"product_lists\";s:4:\"type\";s:12:\"relationship\";s:12:\"instructions\";s:0:\"\";s:8:\"required\";s:1:\"0\";s:13:\"return_format\";s:6:\"object\";s:9:\"post_type\";a:1:{i:0;s:7:\"product\";}s:8:\"taxonomy\";a:1:{i:0;s:3:\"all\";}s:7:\"filters\";a:1:{i:0;s:6:\"search\";}s:15:\"result_elements\";a:1:{i:0;s:9:\"post_type\";}s:3:\"max\";s:0:\"\";s:17:\"conditional_logic\";a:3:{s:6:\"status\";s:1:\"0\";s:5:\"rules\";a:1:{i:0;a:3:{s:5:\"field\";s:4:\"null\";s:8:\"operator\";s:2:\"==\";s:5:\"value\";s:0:\"\";}}s:8:\"allorany\";s:3:\"all\";}s:8:\"order_no\";i:1;}'),
(1111,	154,	'position',	'normal'),
(1112,	154,	'layout',	'default'),
(1113,	154,	'hide_on_screen',	''),
(1114,	154,	'_edit_lock',	'1415173824:1'),
(1119,	154,	'field_54573911b05fd',	'a:13:{s:3:\"key\";s:19:\"field_54573911b05fd\";s:5:\"label\";s:13:\"Banner Images\";s:4:\"name\";s:13:\"banner_images\";s:4:\"type\";s:8:\"repeater\";s:12:\"instructions\";s:0:\"\";s:8:\"required\";s:1:\"0\";s:10:\"sub_fields\";a:2:{i:0;a:12:{s:3:\"key\";s:19:\"field_54573929b05fe\";s:5:\"label\";s:5:\"Image\";s:4:\"name\";s:5:\"image\";s:4:\"type\";s:5:\"image\";s:12:\"instructions\";s:0:\"\";s:8:\"required\";s:1:\"1\";s:12:\"column_width\";s:0:\"\";s:11:\"save_format\";s:3:\"url\";s:12:\"preview_size\";s:4:\"full\";s:7:\"library\";s:3:\"all\";s:17:\"conditional_logic\";a:3:{s:6:\"status\";s:1:\"0\";s:5:\"rules\";a:1:{i:0;a:2:{s:5:\"field\";s:4:\"null\";s:8:\"operator\";s:2:\"==\";}}s:8:\"allorany\";s:3:\"all\";}s:8:\"order_no\";i:0;}i:1;a:15:{s:3:\"key\";s:19:\"field_54573996b05ff\";s:5:\"label\";s:7:\"Link to\";s:4:\"name\";s:7:\"link_to\";s:4:\"type\";s:4:\"text\";s:12:\"instructions\";s:0:\"\";s:8:\"required\";s:1:\"0\";s:12:\"column_width\";s:0:\"\";s:13:\"default_value\";s:0:\"\";s:11:\"placeholder\";s:0:\"\";s:7:\"prepend\";s:0:\"\";s:6:\"append\";s:0:\"\";s:10:\"formatting\";s:4:\"html\";s:9:\"maxlength\";s:0:\"\";s:17:\"conditional_logic\";a:3:{s:6:\"status\";s:1:\"0\";s:5:\"rules\";a:1:{i:0;a:2:{s:5:\"field\";s:4:\"null\";s:8:\"operator\";s:2:\"==\";}}s:8:\"allorany\";s:3:\"all\";}s:8:\"order_no\";i:1;}}s:7:\"row_min\";s:0:\"\";s:9:\"row_limit\";s:0:\"\";s:6:\"layout\";s:3:\"row\";s:12:\"button_label\";s:10:\"Add Banner\";s:17:\"conditional_logic\";a:3:{s:6:\"status\";s:1:\"0\";s:5:\"rules\";a:1:{i:0;a:2:{s:5:\"field\";s:4:\"null\";s:8:\"operator\";s:2:\"==\";}}s:8:\"allorany\";s:3:\"all\";}s:8:\"order_no\";i:0;}'),
(1120,	154,	'rule',	'a:5:{s:5:\"param\";s:13:\"page_template\";s:8:\"operator\";s:2:\"==\";s:5:\"value\";s:23:\"page-templates/home.php\";s:8:\"order_no\";i:0;s:8:\"group_no\";i:0;}'),
(1121,	155,	'_edit_last',	'1'),
(1122,	155,	'_edit_lock',	'1415177647:1'),
(1123,	155,	'_wp_page_template',	'page-templates/home.php'),
(1124,	156,	'banner_images',	'0'),
(1125,	156,	'_banner_images',	'field_54573911b05fd'),
(1126,	156,	'product_lists',	''),
(1127,	156,	'_product_lists',	'field_545735847e0fc'),
(1128,	155,	'banner_images',	'1'),
(1129,	155,	'_banner_images',	'field_54573911b05fd'),
(1130,	155,	'product_lists',	'a:7:{i:0;s:3:\"110\";i:1;s:3:\"112\";i:2;s:3:\"114\";i:3;s:3:\"116\";i:4;s:3:\"118\";i:5;s:3:\"120\";i:6;s:3:\"122\";}'),
(1131,	155,	'_product_lists',	'field_545735847e0fc'),
(1138,	110,	'_edit_lock',	'1415174648:1'),
(1139,	159,	'_edit_last',	'1'),
(1140,	159,	'field_5459d9dfce31c',	'a:13:{s:3:\"key\";s:19:\"field_5459d9dfce31c\";s:5:\"label\";s:17:\"Order Upload File\";s:4:\"name\";s:17:\"order_upload_file\";s:4:\"type\";s:8:\"repeater\";s:12:\"instructions\";s:0:\"\";s:8:\"required\";s:1:\"0\";s:10:\"sub_fields\";a:2:{i:0;a:13:{s:3:\"key\";s:19:\"field_5459d9f7ce31d\";s:5:\"label\";s:7:\"Product\";s:4:\"name\";s:7:\"product\";s:4:\"type\";s:11:\"post_object\";s:12:\"instructions\";s:0:\"\";s:8:\"required\";s:1:\"1\";s:12:\"column_width\";s:0:\"\";s:9:\"post_type\";a:1:{i:0;s:7:\"product\";}s:8:\"taxonomy\";a:1:{i:0;s:3:\"all\";}s:10:\"allow_null\";s:1:\"0\";s:8:\"multiple\";s:1:\"0\";s:17:\"conditional_logic\";a:3:{s:6:\"status\";s:1:\"0\";s:5:\"rules\";a:1:{i:0;a:2:{s:5:\"field\";s:4:\"null\";s:8:\"operator\";s:2:\"==\";}}s:8:\"allorany\";s:3:\"all\";}s:8:\"order_no\";i:0;}i:1;a:14:{s:3:\"key\";s:19:\"field_5459da1dce31e\";s:5:\"label\";s:9:\"File List\";s:4:\"name\";s:9:\"file_list\";s:4:\"type\";s:8:\"repeater\";s:12:\"instructions\";s:0:\"\";s:8:\"required\";s:1:\"0\";s:12:\"column_width\";s:0:\"\";s:10:\"sub_fields\";a:1:{i:0;a:11:{s:3:\"key\";s:19:\"field_5459da2bce31f\";s:5:\"label\";s:4:\"File\";s:4:\"name\";s:4:\"file\";s:4:\"type\";s:4:\"file\";s:12:\"instructions\";s:0:\"\";s:8:\"required\";s:1:\"1\";s:12:\"column_width\";s:0:\"\";s:11:\"save_format\";s:6:\"object\";s:7:\"library\";s:3:\"all\";s:17:\"conditional_logic\";a:3:{s:6:\"status\";s:1:\"0\";s:5:\"rules\";a:1:{i:0;a:2:{s:5:\"field\";s:4:\"null\";s:8:\"operator\";s:2:\"==\";}}s:8:\"allorany\";s:3:\"all\";}s:8:\"order_no\";i:0;}}s:7:\"row_min\";s:0:\"\";s:9:\"row_limit\";s:0:\"\";s:6:\"layout\";s:5:\"table\";s:12:\"button_label\";s:12:\"Add New File\";s:17:\"conditional_logic\";a:3:{s:6:\"status\";s:1:\"0\";s:5:\"rules\";a:1:{i:0;a:2:{s:5:\"field\";s:4:\"null\";s:8:\"operator\";s:2:\"==\";}}s:8:\"allorany\";s:3:\"all\";}s:8:\"order_no\";i:1;}}s:7:\"row_min\";s:0:\"\";s:9:\"row_limit\";s:0:\"\";s:6:\"layout\";s:5:\"table\";s:12:\"button_label\";s:30:\"Add New Upload File To Product\";s:17:\"conditional_logic\";a:3:{s:6:\"status\";s:1:\"0\";s:5:\"rules\";a:1:{i:0;a:2:{s:5:\"field\";s:4:\"null\";s:8:\"operator\";s:2:\"==\";}}s:8:\"allorany\";s:3:\"all\";}s:8:\"order_no\";i:0;}'),
(1141,	159,	'rule',	'a:5:{s:5:\"param\";s:9:\"post_type\";s:8:\"operator\";s:2:\"==\";s:5:\"value\";s:10:\"shop_order\";s:8:\"order_no\";i:0;s:8:\"group_no\";i:0;}'),
(1142,	159,	'position',	'normal'),
(1143,	159,	'layout',	'default'),
(1144,	159,	'hide_on_screen',	''),
(1145,	159,	'_edit_lock',	'1415180597:1'),
(1146,	160,	'_menu_item_type',	'custom'),
(1147,	160,	'_menu_item_menu_item_parent',	'0'),
(1148,	160,	'_menu_item_object_id',	'160'),
(1149,	160,	'_menu_item_object',	'custom'),
(1150,	160,	'_menu_item_target',	''),
(1151,	160,	'_menu_item_classes',	'a:1:{i:0;s:0:\"\";}'),
(1152,	160,	'_menu_item_xfn',	''),
(1153,	160,	'_menu_item_url',	'http://vinaprint.local/'),
(1154,	160,	'_menu_item_orphaned',	'1415174797'),
(1155,	161,	'_menu_item_type',	'post_type'),
(1156,	161,	'_menu_item_menu_item_parent',	'0'),
(1157,	161,	'_menu_item_object_id',	'155'),
(1158,	161,	'_menu_item_object',	'page'),
(1159,	161,	'_menu_item_target',	''),
(1160,	161,	'_menu_item_classes',	'a:1:{i:0;s:0:\"\";}'),
(1161,	161,	'_menu_item_xfn',	''),
(1162,	161,	'_menu_item_url',	''),
(1173,	161,	'mmpm_item_style',	''),
(1174,	161,	'mmpm_item_icon',	'im-icon-home-9'),
(1175,	161,	'mmpm_disable_icon',	'a:1:{i:0;s:11:\"is_checkbox\";}'),
(1176,	161,	'mmpm_disable_text',	'a:1:{i:0;s:11:\"is_checkbox\";}'),
(1177,	161,	'mmpm_disable_link',	'a:1:{i:0;s:11:\"is_checkbox\";}'),
(1178,	161,	'mmpm_submenu_type',	'default_dropdown'),
(1179,	161,	'mmpm_submenu_post_type',	'post'),
(1180,	161,	'mmpm_submenu_drops_side',	'drop_to_right'),
(1181,	161,	'mmpm_submenu_columns',	'1'),
(1182,	161,	'mmpm_submenu_enable_full_width',	'a:1:{i:0;s:11:\"is_checkbox\";}'),
(1183,	161,	'mmpm_submenu_bg_image',	'a:5:{s:16:\"background_image\";s:0:\"\";s:17:\"background_repeat\";s:6:\"repeat\";s:21:\"background_attachment\";s:6:\"scroll\";s:19:\"background_position\";s:6:\"center\";s:15:\"background_size\";s:4:\"auto\";}'),
(1186,	168,	'_wp_attached_file',	'2014/11/visitkort_banner.jpg'),
(1187,	168,	'_wp_attachment_metadata',	'a:5:{s:5:\"width\";i:730;s:6:\"height\";i:155;s:4:\"file\";s:28:\"2014/11/visitkort_banner.jpg\";s:5:\"sizes\";a:7:{s:9:\"thumbnail\";a:4:{s:4:\"file\";s:28:\"visitkort_banner-150x150.jpg\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:6:\"medium\";a:4:{s:4:\"file\";s:27:\"visitkort_banner-300x63.jpg\";s:5:\"width\";i:300;s:6:\"height\";i:63;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:16:\"admin-list-thumb\";a:4:{s:4:\"file\";s:27:\"visitkort_banner-100x70.jpg\";s:5:\"width\";i:100;s:6:\"height\";i:70;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:14:\"shop_thumbnail\";a:4:{s:4:\"file\";s:26:\"visitkort_banner-90x90.jpg\";s:5:\"width\";i:90;s:6:\"height\";i:90;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:12:\"shop_catalog\";a:4:{s:4:\"file\";s:28:\"visitkort_banner-150x150.jpg\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:11:\"shop_single\";a:4:{s:4:\"file\";s:28:\"visitkort_banner-300x155.jpg\";s:5:\"width\";i:300;s:6:\"height\";i:155;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:14:\"post-thumbnail\";a:4:{s:4:\"file\";s:28:\"visitkort_banner-624x132.jpg\";s:5:\"width\";i:624;s:6:\"height\";i:132;s:9:\"mime-type\";s:10:\"image/jpeg\";}}s:10:\"image_meta\";a:11:{s:8:\"aperture\";i:0;s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";i:0;s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";i:0;s:3:\"iso\";i:0;s:13:\"shutter_speed\";i:0;s:5:\"title\";s:0:\"\";s:11:\"orientation\";i:0;}}'),
(1188,	169,	'banner_images_0_image',	'168'),
(1189,	169,	'_banner_images_0_image',	'field_54573929b05fe'),
(1190,	169,	'banner_images_0_link_to',	''),
(1191,	169,	'_banner_images_0_link_to',	'field_54573996b05ff'),
(1192,	169,	'banner_images',	'1'),
(1193,	169,	'_banner_images',	'field_54573911b05fd'),
(1194,	169,	'product_lists',	''),
(1195,	169,	'_product_lists',	'field_545735847e0fc'),
(1196,	155,	'banner_images_0_image',	'168'),
(1197,	155,	'_banner_images_0_image',	'field_54573929b05fe'),
(1198,	155,	'banner_images_0_link_to',	''),
(1199,	155,	'_banner_images_0_link_to',	'field_54573996b05ff'),
(1200,	170,	'_edit_last',	'1'),
(1201,	170,	'field_5459e1dd31e05',	'a:11:{s:3:\"key\";s:19:\"field_5459e1dd31e05\";s:5:\"label\";s:4:\"Logo\";s:4:\"name\";s:4:\"logo\";s:4:\"type\";s:5:\"image\";s:12:\"instructions\";s:0:\"\";s:8:\"required\";s:1:\"0\";s:11:\"save_format\";s:3:\"url\";s:12:\"preview_size\";s:9:\"thumbnail\";s:7:\"library\";s:3:\"all\";s:17:\"conditional_logic\";a:3:{s:6:\"status\";s:1:\"0\";s:5:\"rules\";a:1:{i:0;a:2:{s:5:\"field\";s:4:\"null\";s:8:\"operator\";s:2:\"==\";}}s:8:\"allorany\";s:3:\"all\";}s:8:\"order_no\";i:0;}'),
(1202,	170,	'rule',	'a:5:{s:5:\"param\";s:12:\"options_page\";s:8:\"operator\";s:2:\"==\";s:5:\"value\";s:11:\"acf-options\";s:8:\"order_no\";i:0;s:8:\"group_no\";i:0;}'),
(1203,	170,	'position',	'normal'),
(1204,	170,	'layout',	'default'),
(1205,	170,	'hide_on_screen',	''),
(1206,	170,	'_edit_lock',	'1415176563:1'),
(1207,	171,	'_wp_attached_file',	'2014/11/logo.png'),
(1208,	171,	'_wp_attachment_metadata',	'a:5:{s:5:\"width\";i:276;s:6:\"height\";i:100;s:4:\"file\";s:16:\"2014/11/logo.png\";s:5:\"sizes\";a:4:{s:9:\"thumbnail\";a:4:{s:4:\"file\";s:16:\"logo-150x100.png\";s:5:\"width\";i:150;s:6:\"height\";i:100;s:9:\"mime-type\";s:9:\"image/png\";}s:16:\"admin-list-thumb\";a:4:{s:4:\"file\";s:15:\"logo-100x70.png\";s:5:\"width\";i:100;s:6:\"height\";i:70;s:9:\"mime-type\";s:9:\"image/png\";}s:14:\"shop_thumbnail\";a:4:{s:4:\"file\";s:14:\"logo-90x90.png\";s:5:\"width\";i:90;s:6:\"height\";i:90;s:9:\"mime-type\";s:9:\"image/png\";}s:12:\"shop_catalog\";a:4:{s:4:\"file\";s:16:\"logo-150x100.png\";s:5:\"width\";i:150;s:6:\"height\";i:100;s:9:\"mime-type\";s:9:\"image/png\";}}s:10:\"image_meta\";a:11:{s:8:\"aperture\";i:0;s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";i:0;s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";i:0;s:3:\"iso\";i:0;s:13:\"shutter_speed\";i:0;s:5:\"title\";s:0:\"\";s:11:\"orientation\";i:0;}}'),
(1209,	172,	'banner_images_0_image',	'168'),
(1210,	172,	'_banner_images_0_image',	'field_54573929b05fe'),
(1211,	172,	'banner_images_0_link_to',	''),
(1212,	172,	'_banner_images_0_link_to',	'field_54573996b05ff'),
(1213,	172,	'banner_images',	'1'),
(1214,	172,	'_banner_images',	'field_54573911b05fd'),
(1215,	172,	'product_lists',	'a:7:{i:0;s:3:\"110\";i:1;s:3:\"112\";i:2;s:3:\"114\";i:3;s:3:\"116\";i:4;s:3:\"118\";i:5;s:3:\"120\";i:6;s:3:\"122\";}'),
(1216,	172,	'_product_lists',	'field_545735847e0fc'),
(1217,	164,	'_edit_lock',	'1415177685:1'),
(1218,	166,	'_edit_lock',	'1415177692:1'),
(1219,	173,	'_order_key',	'wc_order_5459ebb0e9f3f'),
(1220,	173,	'_order_currency',	'DKK'),
(1221,	173,	'_prices_include_tax',	'no'),
(1222,	173,	'_customer_ip_address',	'127.0.0.1'),
(1223,	173,	'_customer_user_agent',	'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:33.0) Gecko/20100101 Firefox/33.0'),
(1224,	173,	'_customer_user',	'1'),
(1225,	173,	'_order_shipping',	'46'),
(1226,	173,	'_billing_country',	'VN'),
(1227,	173,	'_billing_first_name',	'Craig'),
(1228,	173,	'_billing_last_name',	'Lee'),
(1229,	173,	'_billing_company',	'Craig'),
(1230,	173,	'_billing_address_1',	'Ha Noi Viet Nam'),
(1231,	173,	'_billing_address_2',	''),
(1232,	173,	'_billing_city',	'Ha Noi'),
(1233,	173,	'_billing_state',	''),
(1234,	173,	'_billing_postcode',	''),
(1235,	173,	'_billing_email',	'ngochicongbk@gmail.com'),
(1236,	173,	'_billing_phone',	'98123123123'),
(1237,	173,	'_shipping_country',	'VN'),
(1238,	173,	'_shipping_first_name',	'Craig'),
(1239,	173,	'_shipping_last_name',	'Lee'),
(1240,	173,	'_shipping_company',	'Craig'),
(1241,	173,	'_shipping_address_1',	'Ha Noi Viet Nam'),
(1242,	173,	'_shipping_address_2',	''),
(1243,	173,	'_shipping_city',	'Ha Noi'),
(1244,	173,	'_shipping_state',	''),
(1245,	173,	'_shipping_postcode',	''),
(1246,	173,	'_payment_method',	'cod'),
(1247,	173,	'_payment_method_title',	'Cash on Delivery'),
(1248,	173,	'_order_discount',	'0'),
(1249,	173,	'_cart_discount',	'0'),
(1250,	173,	'_order_tax',	'0'),
(1251,	173,	'_order_shipping_tax',	'0'),
(1252,	173,	'_order_total',	'65.00'),
(1253,	173,	'_download_permissions_granted',	'1'),
(1254,	110,	'total_sales',	'2'),
(1255,	173,	'_recorded_sales',	'yes'),
(1256,	173,	'_recorded_coupon_usage_counts',	'yes'),
(1257,	173,	'_edit_lock',	'1415180443:1'),
(1260,	173,	'_edit_last',	'1'),
(1261,	173,	'_transaction_id',	''),
(1265,	173,	'_order_upload_file_0_file_list_0_file',	'field_5459da2bce31f'),
(1269,	173,	'_order_upload_file',	'field_5459d9dfce31c'),
(1271,	173,	'_order_upload_file_0_product',	'field_5459d9f7ce31d'),
(1273,	173,	'_order_upload_file_0_file_list',	'field_5459da1dce31e'),
(1274,	173,	'order_upload_file_0_product',	'110'),
(1275,	173,	'order_upload_file_0_file_list_0_file',	'171'),
(1276,	173,	'order_upload_file_0_file_list',	'1'),
(1277,	173,	'order_upload_file',	'1');

DROP TABLE IF EXISTS `wp_posts`;
CREATE TABLE `wp_posts` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_author` bigint(20) unsigned NOT NULL DEFAULT '0',
  `post_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_date_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_content` longtext NOT NULL,
  `post_title` text NOT NULL,
  `post_excerpt` text NOT NULL,
  `post_status` varchar(20) NOT NULL DEFAULT 'publish',
  `comment_status` varchar(20) NOT NULL DEFAULT 'open',
  `ping_status` varchar(20) NOT NULL DEFAULT 'open',
  `post_password` varchar(20) NOT NULL DEFAULT '',
  `post_name` varchar(200) NOT NULL DEFAULT '',
  `to_ping` text NOT NULL,
  `pinged` text NOT NULL,
  `post_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_modified_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_content_filtered` longtext NOT NULL,
  `post_parent` bigint(20) unsigned NOT NULL DEFAULT '0',
  `guid` varchar(255) NOT NULL DEFAULT '',
  `menu_order` int(11) NOT NULL DEFAULT '0',
  `post_type` varchar(20) NOT NULL DEFAULT 'post',
  `post_mime_type` varchar(100) NOT NULL DEFAULT '',
  `comment_count` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`),
  KEY `post_name` (`post_name`),
  KEY `type_status_date` (`post_type`,`post_status`,`post_date`,`ID`),
  KEY `post_parent` (`post_parent`),
  KEY `post_author` (`post_author`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `wp_terms`;
CREATE TABLE `wp_terms` (
  `term_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL DEFAULT '',
  `slug` varchar(200) NOT NULL DEFAULT '',
  `term_group` bigint(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`term_id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `wp_term_relationships`;
CREATE TABLE `wp_term_relationships` (
  `object_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `term_taxonomy_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `term_order` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`object_id`,`term_taxonomy_id`),
  KEY `term_taxonomy_id` (`term_taxonomy_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `wp_term_taxonomy`;
CREATE TABLE `wp_term_taxonomy` (
  `term_taxonomy_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `term_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `taxonomy` varchar(32) NOT NULL DEFAULT '',
  `description` longtext NOT NULL,
  `parent` bigint(20) unsigned NOT NULL DEFAULT '0',
  `count` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`term_taxonomy_id`),
  UNIQUE KEY `term_id_taxonomy` (`term_id`,`taxonomy`),
  KEY `taxonomy` (`taxonomy`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `wp_usermeta`;
CREATE TABLE `wp_usermeta` (
  `umeta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `meta_key` varchar(255) DEFAULT NULL,
  `meta_value` longtext,
  PRIMARY KEY (`umeta_id`),
  KEY `user_id` (`user_id`),
  KEY `meta_key` (`meta_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `wp_users`;
CREATE TABLE `wp_users` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_login` varchar(60) NOT NULL DEFAULT '',
  `user_pass` varchar(64) NOT NULL DEFAULT '',
  `user_nicename` varchar(50) NOT NULL DEFAULT '',
  `user_email` varchar(100) NOT NULL DEFAULT '',
  `user_url` varchar(100) NOT NULL DEFAULT '',
  `user_registered` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_activation_key` varchar(60) NOT NULL DEFAULT '',
  `user_status` int(11) NOT NULL DEFAULT '0',
  `display_name` varchar(250) NOT NULL DEFAULT '',
  PRIMARY KEY (`ID`),
  KEY `user_login_key` (`user_login`),
  KEY `user_nicename` (`user_nicename`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `wp_woocommerce_attribute_taxonomies`;
CREATE TABLE `wp_woocommerce_attribute_taxonomies` (
  `attribute_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `attribute_name` varchar(200) NOT NULL,
  `attribute_label` longtext,
  `attribute_type` varchar(200) NOT NULL,
  `attribute_orderby` varchar(200) NOT NULL,
  PRIMARY KEY (`attribute_id`),
  KEY `attribute_name` (`attribute_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `wp_woocommerce_downloadable_product_permissions`;
CREATE TABLE `wp_woocommerce_downloadable_product_permissions` (
  `permission_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `download_id` varchar(32) NOT NULL,
  `product_id` bigint(20) NOT NULL,
  `order_id` bigint(20) NOT NULL DEFAULT '0',
  `order_key` varchar(200) NOT NULL,
  `user_email` varchar(200) NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `downloads_remaining` varchar(9) DEFAULT NULL,
  `access_granted` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `access_expires` datetime DEFAULT NULL,
  `download_count` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`permission_id`),
  KEY `download_order_key_product` (`product_id`,`order_id`,`order_key`,`download_id`),
  KEY `download_order_product` (`download_id`,`order_id`,`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `wp_woocommerce_order_itemmeta`;
CREATE TABLE `wp_woocommerce_order_itemmeta` (
  `meta_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `order_item_id` bigint(20) NOT NULL,
  `meta_key` varchar(255) DEFAULT NULL,
  `meta_value` longtext,
  PRIMARY KEY (`meta_id`),
  KEY `order_item_id` (`order_item_id`),
  KEY `meta_key` (`meta_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `wp_woocommerce_order_items`;
CREATE TABLE `wp_woocommerce_order_items` (
  `order_item_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `order_item_name` longtext NOT NULL,
  `order_item_type` varchar(200) NOT NULL DEFAULT '',
  `order_id` bigint(20) NOT NULL,
  PRIMARY KEY (`order_item_id`),
  KEY `order_id` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `wp_woocommerce_tax_rates`;
CREATE TABLE `wp_woocommerce_tax_rates` (
  `tax_rate_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `tax_rate_country` varchar(200) NOT NULL DEFAULT '',
  `tax_rate_state` varchar(200) NOT NULL DEFAULT '',
  `tax_rate` varchar(200) NOT NULL DEFAULT '',
  `tax_rate_name` varchar(200) NOT NULL DEFAULT '',
  `tax_rate_priority` bigint(20) NOT NULL,
  `tax_rate_compound` int(1) NOT NULL DEFAULT '0',
  `tax_rate_shipping` int(1) NOT NULL DEFAULT '1',
  `tax_rate_order` bigint(20) NOT NULL,
  `tax_rate_class` varchar(200) NOT NULL DEFAULT '',
  PRIMARY KEY (`tax_rate_id`),
  KEY `tax_rate_country` (`tax_rate_country`),
  KEY `tax_rate_state` (`tax_rate_state`),
  KEY `tax_rate_class` (`tax_rate_class`),
  KEY `tax_rate_priority` (`tax_rate_priority`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `wp_woocommerce_tax_rate_locations`;
CREATE TABLE `wp_woocommerce_tax_rate_locations` (
  `location_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `location_code` varchar(255) NOT NULL,
  `tax_rate_id` bigint(20) NOT NULL,
  `location_type` varchar(40) NOT NULL,
  PRIMARY KEY (`location_id`),
  KEY `tax_rate_id` (`tax_rate_id`),
  KEY `location_type` (`location_type`),
  KEY `location_type_code` (`location_type`,`location_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `wp_woocommerce_termmeta`;
CREATE TABLE `wp_woocommerce_termmeta` (
  `meta_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `woocommerce_term_id` bigint(20) NOT NULL,
  `meta_key` varchar(255) DEFAULT NULL,
  `meta_value` longtext,
  PRIMARY KEY (`meta_id`),
  KEY `woocommerce_term_id` (`woocommerce_term_id`),
  KEY `meta_key` (`meta_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- 2014-11-05 09:54:49
