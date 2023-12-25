-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 27, 2018 at 11:09 AM
-- Server version: 10.1.25-MariaDB
-- PHP Version: 7.0.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ultimate_sms`
--

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8_unicode_ci NOT NULL,
  `queue` text COLLATE utf8_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8_unicode_ci NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(298, '2017_02_11_160113_Create_AppConfig_Table', 1),
(299, '2017_02_15_051702_Create_Admins_Table', 1),
(300, '2017_02_15_051715_Create_Clients_Table', 1),
(301, '2017_02_24_140141_Create_SMS_Gateways_Table', 1),
(302, '2017_02_24_145218_Create_Payment_Gateways_Table', 1),
(303, '2017_02_24_153927_Create_Email_Templates_Table', 1),
(304, '2017_02_26_060604_Create_Client_Groups_Table', 1),
(305, '2017_02_27_174402_Create_Ticket_Table', 1),
(306, '2017_02_27_174448_Create_Ticket_Replies_Table', 1),
(307, '2017_02_27_174529_Create_Support_Department_Table', 1),
(308, '2017_02_27_174612_Create_Ticket_Files_Table', 1),
(309, '2017_02_28_134400_Create_Administrator_Role_Table', 1),
(310, '2017_02_28_134742_Create_Administrator_Role_Permission_Table', 1),
(311, '2017_03_01_170716_Create_Invoices_Table', 1),
(312, '2017_03_01_170742_Create_Invoice_Items_Table', 1),
(313, '2017_03_08_160657_Create_SMS_Transaction_Table', 1),
(314, '2017_03_10_175534_Create_Int_Country_Codes', 1),
(315, '2017_03_11_164932_Create_SenderID_Management_table', 1),
(316, '2017_03_14_163320_Create_SMS_Plan_Feature', 1),
(317, '2017_03_14_163416_Create_SMS_Price_Plan_Table', 1),
(318, '2017_03_27_150018_create_jobs_table', 1),
(319, '2017_04_09_145036_Create_Custom_SMS_Gateways_Table', 1),
(320, '2017_04_11_163310_Create_SMS_History_Table', 1),
(321, '2017_04_12_052528_Create_SMS_Templates_Table', 1),
(322, '2017_04_14_140621_Create_Schedule_SMS_Table', 1),
(323, '2017_05_06_054309_Create_Language_Table', 1),
(324, '2017_05_06_054719_Create_Language_Data_Table', 1),
(325, '2017_06_30_142046_create_failed_jobs_table', 1),
(326, '2017_07_02_175729_Create_Import_Phone_Number_table', 1),
(327, '2017_07_11_170134_Create_Bulk_SMS_Table', 1),
(328, '2017_07_16_171839_Create_SMS_Bundles_Table', 1),
(329, '2017_10_10_160541_Create_Contact_Table', 1),
(330, '2017_10_11_181347_Create_Blacklist_Table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `sys_admins`
--

CREATE TABLE `sys_admins` (
  `id` int(10) UNSIGNED NOT NULL,
  `fname` text COLLATE utf8_unicode_ci NOT NULL,
  `lname` text COLLATE utf8_unicode_ci,
  `username` text COLLATE utf8_unicode_ci NOT NULL,
  `password` text COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('Active','Inactive') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Active',
  `email` text COLLATE utf8_unicode_ci,
  `image` text COLLATE utf8_unicode_ci,
  `roleid` int(11) NOT NULL,
  `lastlogin` datetime DEFAULT NULL,
  `pwresetkey` text COLLATE utf8_unicode_ci,
  `pwresetexpiry` int(11) DEFAULT NULL,
  `emailnotify` enum('Yes','No') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'No',
  `online` int(11) NOT NULL DEFAULT '0',
  `menu_open` int(11) NOT NULL DEFAULT '0',
  `remember_token` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `sys_admins`
--

INSERT INTO `sys_admins` (`id`, `fname`, `lname`, `username`, `password`, `status`, `email`, `image`, `roleid`, `lastlogin`, `pwresetkey`, `pwresetexpiry`, `emailnotify`, `online`, `menu_open`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Abul Kashem', 'Shamim', 'admin', '$2y$10$LrSbUYx79DdJQ.LXNULfh.Jd7rwkVMa7LGvaZ3TC/PGPzCRFUj8NG', 'Active', 'akasham67@gmail.com', 'profile.jpg', 0, NULL, NULL, NULL, 'No', 0, 0, NULL, '2018-01-27 10:03:59', '2018-01-27 10:03:59');

-- --------------------------------------------------------

--
-- Table structure for table `sys_admin_role`
--

CREATE TABLE `sys_admin_role` (
  `id` int(10) UNSIGNED NOT NULL,
  `role_name` text COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('Active','Inactive') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sys_admin_role_perm`
--

CREATE TABLE `sys_admin_role_perm` (
  `id` int(10) UNSIGNED NOT NULL,
  `role_id` int(11) NOT NULL,
  `perm_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sys_app_config`
--

CREATE TABLE `sys_app_config` (
  `id` int(10) UNSIGNED NOT NULL,
  `setting` text COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `sys_app_config`
--

INSERT INTO `sys_app_config` (`id`, `setting`, `value`, `created_at`, `updated_at`) VALUES
(1, 'AppName', 'Ultimate SMS', '2018-01-27 10:03:56', '2018-01-27 10:03:56'),
(2, 'AppUrl', 'ultimatesms.coderpixel.com', '2018-01-27 10:03:56', '2018-01-27 10:03:56'),
(3, 'purchase_key', '', '2018-01-27 10:03:56', '2018-01-27 10:03:56'),
(4, 'valid_domain', 'yes', '2018-01-27 10:03:56', '2018-01-27 10:03:56'),
(5, 'Email', 'akasham67@gmail.com', '2018-01-27 10:03:56', '2018-01-27 10:03:56'),
(6, 'Address', 'House#11, Block#B, <br>Rampura<br>Banasree Project<br>Dhaka<br>1219<br>Bangladesh', '2018-01-27 10:03:56', '2018-01-27 10:03:56'),
(7, 'SoftwareVersion', '2.2', '2018-01-27 10:03:56', '2018-01-27 10:03:56'),
(8, 'AppTitle', 'Ultimate SMS - Bulk SMS Sending Application', '2018-01-27 10:03:57', '2018-01-27 10:03:57'),
(9, 'FooterTxt', 'Copyright &copy; Codeglen - 2018', '2018-01-27 10:03:57', '2018-01-27 10:03:57'),
(10, 'AppLogo', 'assets/img/logo.png', '2018-01-27 10:03:57', '2018-01-27 10:03:57'),
(11, 'AppFav', 'assets/img/favicon.ico', '2018-01-27 10:03:57', '2018-01-27 10:03:57'),
(12, 'Country', 'Bangladesh', '2018-01-27 10:03:57', '2018-01-27 10:03:57'),
(13, 'Timezone', 'Asia/Dhaka', '2018-01-27 10:03:57', '2018-01-27 10:03:57'),
(14, 'Currency', 'USD', '2018-01-27 10:03:57', '2018-01-27 10:03:57'),
(15, 'CurrencyCode', '$', '2018-01-27 10:03:57', '2018-01-27 10:03:57'),
(16, 'Gateway', 'default', '2018-01-27 10:03:57', '2018-01-27 10:03:57'),
(17, 'SMTPHostName', 'smtp.gmail.com', '2018-01-27 10:03:57', '2018-01-27 10:03:57'),
(18, 'SMTPUserName', 'user@example.com', '2018-01-27 10:03:57', '2018-01-27 10:03:57'),
(19, 'SMTPPassword', 'testpassword', '2018-01-27 10:03:57', '2018-01-27 10:03:57'),
(20, 'SMTPPort', '587', '2018-01-27 10:03:57', '2018-01-27 10:03:57'),
(21, 'SMTPSecure', 'tls', '2018-01-27 10:03:57', '2018-01-27 10:03:57'),
(22, 'AppStage', 'Live', '2018-01-27 10:03:57', '2018-01-27 10:03:57'),
(23, 'DateFormat', 'jS M y', '2018-01-27 10:03:57', '2018-01-27 10:03:57'),
(24, 'Language', '1', '2018-01-27 10:03:57', '2018-01-27 10:03:57'),
(25, 'sms_api_permission', '1', '2018-01-27 10:03:57', '2018-01-27 10:03:57'),
(26, 'sms_api_gateway', '1', '2018-01-27 10:03:57', '2018-01-27 10:03:57'),
(27, 'api_url', 'https://ultimatesms.codeglen.com/demo', '2018-01-27 10:03:57', '2018-01-27 10:03:57'),
(28, 'api_key', 'YWRtaW46YWRtaW4ucGFzc3dvcmQ=', '2018-01-27 10:03:58', '2018-01-27 10:03:58'),
(29, 'client_registration', '1', '2018-01-27 10:03:58', '2018-01-27 10:03:58'),
(30, 'registration_verification', '0', '2018-01-27 10:03:58', '2018-01-27 10:03:58'),
(31, 'captcha_in_admin', '0', '2018-01-27 10:03:58', '2018-01-27 10:03:58'),
(32, 'captcha_in_client', '0', '2018-01-27 10:03:58', '2018-01-27 10:03:58'),
(33, 'captcha_in_client_registration', '0', '2018-01-27 10:03:58', '2018-01-27 10:03:58'),
(34, 'captcha_site_key', '6LcVTCEUAAAAAF2VucYNRFbnfD12MO41LpcS71o9', '2018-01-27 10:03:58', '2018-01-27 10:03:58'),
(35, 'captcha_secret_key', '6LcVTCEUAAAAAGBbxACgcO6sBFPNIrMOkXJGh-Yu', '2018-01-27 10:03:58', '2018-01-27 10:03:58'),
(36, 'purchase_code_error_count', '0', '2018-01-27 10:03:58', '2018-01-27 10:03:58'),
(37, 'sender_id_verification', '1', '2018-01-27 10:03:58', '2018-01-27 10:03:58'),
(38, 'license_type', '', '2018-01-27 10:03:58', '2018-01-27 10:03:58');

-- --------------------------------------------------------

--
-- Table structure for table `sys_blacklist_contacts`
--

CREATE TABLE `sys_blacklist_contacts` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `numbers` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sys_bulk_sms`
--

CREATE TABLE `sys_bulk_sms` (
  `id` int(10) UNSIGNED NOT NULL,
  `userid` int(11) NOT NULL,
  `sender` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `msg_data` longtext COLLATE utf8_unicode_ci NOT NULL,
  `use_gateway` int(11) NOT NULL,
  `type` enum('plain','unicode') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'plain',
  `status` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sys_clients`
--

CREATE TABLE `sys_clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `groupid` int(11) NOT NULL DEFAULT '0',
  `parent` int(11) NOT NULL DEFAULT '0',
  `fname` text COLLATE utf8_unicode_ci NOT NULL,
  `lname` text COLLATE utf8_unicode_ci,
  `company` text COLLATE utf8_unicode_ci,
  `website` text COLLATE utf8_unicode_ci,
  `email` text COLLATE utf8_unicode_ci,
  `username` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `password` text COLLATE utf8_unicode_ci NOT NULL,
  `address1` text COLLATE utf8_unicode_ci,
  `address2` text COLLATE utf8_unicode_ci,
  `state` text COLLATE utf8_unicode_ci,
  `city` text COLLATE utf8_unicode_ci,
  `postcode` text COLLATE utf8_unicode_ci,
  `country` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `image` text COLLATE utf8_unicode_ci,
  `datecreated` date NOT NULL DEFAULT '2018-01-27',
  `sms_limit` varchar(11) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `api_access` enum('Yes','No') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'No',
  `api_key` text COLLATE utf8_unicode_ci,
  `online` int(11) NOT NULL DEFAULT '0',
  `status` enum('Active','Inactive','Closed') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Active',
  `reseller` enum('Yes','No') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'No',
  `sms_gateway` varchar(25) COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `lastlogin` date DEFAULT NULL,
  `pwresetkey` text COLLATE utf8_unicode_ci,
  `pwresetexpiry` int(11) DEFAULT NULL,
  `emailnotify` enum('Yes','No') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'No',
  `menu_open` int(11) NOT NULL DEFAULT '0',
  `remember_token` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sys_client_groups`
--

CREATE TABLE `sys_client_groups` (
  `id` int(10) UNSIGNED NOT NULL,
  `group_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL DEFAULT '0',
  `status` enum('Yes','No') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Yes',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sys_contact_list`
--

CREATE TABLE `sys_contact_list` (
  `id` int(10) UNSIGNED NOT NULL,
  `pid` int(11) NOT NULL,
  `phone_number` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `email_address` text COLLATE utf8_unicode_ci,
  `user_name` text COLLATE utf8_unicode_ci,
  `company` text COLLATE utf8_unicode_ci,
  `first_name` text COLLATE utf8_unicode_ci,
  `last_name` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sys_custom_sms_gateways`
--

CREATE TABLE `sys_custom_sms_gateways` (
  `id` int(10) UNSIGNED NOT NULL,
  `gateway_id` int(11) NOT NULL,
  `username_param` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `username_value` text COLLATE utf8_unicode_ci NOT NULL,
  `password_param` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_value` text COLLATE utf8_unicode_ci,
  `password_status` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'yes',
  `action_param` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `action_value` text COLLATE utf8_unicode_ci,
  `action_status` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'yes',
  `source_param` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `source_value` text COLLATE utf8_unicode_ci,
  `source_status` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'yes',
  `destination_param` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `message_param` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `unicode_param` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `unicode_value` text COLLATE utf8_unicode_ci,
  `unicode_status` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'yes',
  `route_param` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `route_value` text COLLATE utf8_unicode_ci,
  `route_status` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'yes',
  `language_param` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `language_value` text COLLATE utf8_unicode_ci,
  `language_status` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'yes',
  `custom_one_param` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `custom_one_value` text COLLATE utf8_unicode_ci,
  `custom_one_status` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'yes',
  `custom_two_param` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `custom_two_value` text COLLATE utf8_unicode_ci,
  `custom_two_status` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'yes',
  `custom_three_param` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `custom_three_value` text COLLATE utf8_unicode_ci,
  `custom_three_status` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'yes',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sys_email_templates`
--

CREATE TABLE `sys_email_templates` (
  `id` int(10) UNSIGNED NOT NULL,
  `tplname` text COLLATE utf8_unicode_ci NOT NULL,
  `subject` text COLLATE utf8_unicode_ci NOT NULL,
  `message` text COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('1','0') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `sys_email_templates`
--

INSERT INTO `sys_email_templates` (`id`, `tplname`, `subject`, `message`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Client SignUp', 'Welcome to {{business_name}}', '<div style=\"margin:0;padding:0\">\n<table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" border=\"0\" bgcolor=\"#439cc8\">\n  <tbody><tr>\n    <td align=\"center\">\n            <table cellspacing=\"0\" cellpadding=\"0\" width=\"672\" border=\"0\">\n              <tbody><tr>\n                <td height=\"95\" bgcolor=\"#439cc8\" style=\"background:#439cc8;text-align:left\">\n                <table cellspacing=\"0\" cellpadding=\"0\" width=\"672\" border=\"0\">\n                      <tbody><tr>\n                        <td width=\"672\" height=\"40\" style=\"font-size:40px;line-height:40px;height:40px;text-align:left\"></td>\n                      </tr>\n                      <tr>\n                        <td style=\"text-align:left\">\n                        <table cellspacing=\"0\" cellpadding=\"0\" width=\"672\" border=\"0\">\n                          <tbody><tr>\n                            <td width=\"37\" height=\"24\" style=\"font-size:40px;line-height:40px;height:40px;text-align:left\">\n                            </td>\n                            <td width=\"523\" height=\"24\" style=\"text-align:left\">\n                            <div width=\"125\" height=\"23\" style=\"display:block;color:#ffffff;font-size:20px;font-family:Arial,Helvetica,sans-serif;max-width:557px;min-height:auto\">{{business_name}}</div>\n                            </td>\n                            <td width=\"44\" style=\"text-align:left\"></td>\n                            <td width=\"30\" style=\"text-align:left\"></td>\n                            <td width=\"38\" height=\"24\" style=\"font-size:40px;line-height:40px;height:40px;text-align:left\"></td>\n                          </tr>\n                        </tbody></table>\n                        </td>\n                      </tr>\n                      <tr><td width=\"672\" height=\"33\" style=\"font-size:33px;line-height:33px;height:33px;text-align:left\"></td></tr>\n                    </tbody></table>\n\n                </td>\n              </tr>\n            </tbody></table>\n     </td>\n    </tr>\n </tbody></table>\n\n <table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" bgcolor=\"#439cc8\"><tbody><tr><td height=\"5\" style=\"background:#439cc8;height:5px;font-size:5px;line-height:5px\"></td></tr></tbody></table>\n\n <table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" border=\"0\" bgcolor=\"#e9eff0\">\n  <tbody><tr>\n    <td align=\"center\">\n      <table cellspacing=\"0\" cellpadding=\"0\" width=\"671\" border=\"0\" bgcolor=\"#e9eff0\" style=\"background:#e9eff0\">\n        <tbody><tr>\n          <td width=\"38\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n          <td width=\"596\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n          <td width=\"37\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n        </tr>\n        <tr>\n          <td width=\"38\" height=\"40\" style=\"font-size:40px;line-height:40px;height:40px;text-align:left\"></td>\n          <td style=\"text-align:left\"><table cellspacing=\"0\" cellpadding=\"0\" width=\"596\" border=\"0\" bgcolor=\"#ffffff\">\n            <tbody><tr>\n              <td width=\"20\" height=\"26\" style=\"font-size:26px;line-height:26px;height:26px;text-align:left\"></td>\n              <td width=\"556\" height=\"26\" style=\"font-size:26px;line-height:26px;height:26px;text-align:left\"></td>\n              <td width=\"20\" height=\"26\" style=\"font-size:26px;line-height:26px;height:26px;text-align:left\"></td>\n            </tr>\n            <tr>\n              <td width=\"20\" height=\"26\" style=\"font-size:26px;line-height:26px;height:26px;text-align:left\"></td>\n              <td width=\"556\" style=\"text-align:left\"><table cellspacing=\"0\" cellpadding=\"0\" width=\"556\" border=\"0\" style=\"font-family:helvetica,arial,sans-seif;color:#666666;font-size:16px;line-height:22px\">\n                <tbody><tr>\n                  <td style=\"text-align:left\"></td>\n                </tr>\n                <tr>\n                  <td style=\"text-align:left\"><table cellspacing=\"0\" cellpadding=\"0\" width=\"556\" border=\"0\">\n                    <tbody><tr><td style=\"font-family:helvetica,arial,sans-serif;font-size:30px;line-height:40px;font-weight:normal;color:#253c44;text-align:left\"></td></tr>\n                    <tr><td width=\"556\" height=\"20\" style=\"font-size:20px;line-height:20px;height:20px;text-align:left\"></td></tr>\n                    <tr>\n                      <td style=\"text-align:left\">\n                 Hi {{name}},<br>\n                 <br>\n                Welcome to {{business_name}}! This message is an automated reply to your User Access request. Login to your User panel by using the details below:\n            <br>\n                <a target=\"_blank\" style=\"color:#ff6600;font-weight:bold;font-family:helvetica,arial,sans-seif;text-decoration:none\" href=\"{{sys_url}}\">{{sys_url}}</a>.<br>\n                                    User Name: {{username}}<br>\n                                    Password: {{password}}\n            <br>\n            Regards,<br>\n            {{business_name}}<br>\n            <br>\n          </td>\n                    </tr>\n                    <tr>\n                      <td width=\"556\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\">&nbsp;</td>\n                    </tr>\n                  </tbody></table></td>\n                </tr>\n              </tbody></table></td>\n              <td width=\"20\" height=\"26\" style=\"font-size:26px;line-height:26px;height:26px;text-align:left\"></td>\n            </tr>\n            <tr>\n              <td width=\"20\" height=\"2\" bgcolor=\"#d9dfe1\" style=\"background-color:#d9dfe1;font-size:2px;line-height:2px;height:2px;text-align:left\"></td>\n              <td width=\"556\" height=\"2\" bgcolor=\"#d9dfe1\" style=\"background-color:#d9dfe1;font-size:2px;line-height:2px;height:2px;text-align:left\"></td>\n              <td width=\"20\" height=\"2\" bgcolor=\"#d9dfe1\" style=\"background-color:#d9dfe1;font-size:2px;line-height:2px;height:2px;text-align:left\"></td>\n            </tr>\n          </tbody></table></td>\n          <td width=\"37\" height=\"40\" style=\"font-size:40px;line-height:40px;height:40px;text-align:left\"></td>\n        </tr>\n        <tr>\n          <td width=\"38\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n          <td width=\"596\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n          <td width=\"37\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n        </tr>\n      </tbody></table>\n  </td></tr>\n</tbody>\n</table>\n<table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" border=\"0\" bgcolor=\"#273f47\"><tbody><tr><td align=\"center\">&nbsp;</td></tr></tbody></table>\n<table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" border=\"0\" bgcolor=\"#364a51\">\n  <tbody><tr>\n    <td align=\"center\">\n       <table cellspacing=\"0\" cellpadding=\"0\" width=\"672\" border=\"0\" bgcolor=\"#364a51\">\n              <tbody><tr>\n              <td width=\"38\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n          <td width=\"569\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n          <td width=\"38\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n              </tr>\n              <tr>\n                <td width=\"38\" height=\"40\" style=\"font-size:40px;line-height:40px;text-align:left\">\n                </td>\n                <td valign=\"top\" style=\"font-family:helvetica,arial,sans-seif;font-size:12px;line-height:16px;color:#949fa3;text-align:left\">Copyright &copy; {{business_name}}, All rights reserved.<br><br><br></td>\n                <td width=\"38\" height=\"40\" style=\"font-size:40px;line-height:40px;text-align:left\"></td>\n              </tr>\n              <tr>\n              <td width=\"38\" height=\"40\" style=\"font-size:40px;line-height:40px;text-align:left\"></td>\n              <td width=\"569\" height=\"40\" style=\"font-size:40px;line-height:40px;text-align:left\"></td>\n                <td width=\"38\" height=\"40\" style=\"font-size:40px;line-height:40px;text-align:left\"></td>\n              </tr>\n            </tbody></table>\n     </td>\n  </tr>\n</tbody></table><div class=\"yj6qo\"></div><div class=\"adL\">\n\n</div></div>\n', '1', '2018-01-27 10:04:05', '2018-01-27 10:04:05'),
(2, 'Client Registration Verification', 'Registration Verification From {{business_name}}', '<div style=\"margin:0;padding:0\">\n<table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" border=\"0\" bgcolor=\"#439cc8\">\n  <tbody><tr>\n    <td align=\"center\">\n            <table cellspacing=\"0\" cellpadding=\"0\" width=\"672\" border=\"0\">\n              <tbody><tr>\n                <td height=\"95\" bgcolor=\"#439cc8\" style=\"background:#439cc8;text-align:left\">\n                <table cellspacing=\"0\" cellpadding=\"0\" width=\"672\" border=\"0\">\n                      <tbody><tr>\n                        <td width=\"672\" height=\"40\" style=\"font-size:40px;line-height:40px;height:40px;text-align:left\"></td>\n                      </tr>\n                      <tr>\n                        <td style=\"text-align:left\">\n                        <table cellspacing=\"0\" cellpadding=\"0\" width=\"672\" border=\"0\">\n                          <tbody><tr>\n                            <td width=\"37\" height=\"24\" style=\"font-size:40px;line-height:40px;height:40px;text-align:left\">\n                            </td>\n                            <td width=\"523\" height=\"24\" style=\"text-align:left\">\n                            <div width=\"125\" height=\"23\" style=\"display:block;color:#ffffff;font-size:20px;font-family:Arial,Helvetica,sans-serif;max-width:557px;min-height:auto\">{{business_name}}</div>\n                            </td>\n                            <td width=\"44\" style=\"text-align:left\"></td>\n                            <td width=\"30\" style=\"text-align:left\"></td>\n                            <td width=\"38\" height=\"24\" style=\"font-size:40px;line-height:40px;height:40px;text-align:left\"></td>\n                          </tr>\n                        </tbody></table>\n                        </td>\n                      </tr>\n                      <tr><td width=\"672\" height=\"33\" style=\"font-size:33px;line-height:33px;height:33px;text-align:left\"></td></tr>\n                    </tbody></table>\n\n                </td>\n              </tr>\n            </tbody></table>\n     </td>\n    </tr>\n </tbody></table>\n\n <table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" bgcolor=\"#439cc8\"><tbody><tr><td height=\"5\" style=\"background:#439cc8;height:5px;font-size:5px;line-height:5px\"></td></tr></tbody></table>\n\n <table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" border=\"0\" bgcolor=\"#e9eff0\">\n  <tbody><tr>\n    <td align=\"center\">\n      <table cellspacing=\"0\" cellpadding=\"0\" width=\"671\" border=\"0\" bgcolor=\"#e9eff0\" style=\"background:#e9eff0\">\n        <tbody><tr>\n          <td width=\"38\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n          <td width=\"596\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n          <td width=\"37\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n        </tr>\n        <tr>\n          <td width=\"38\" height=\"40\" style=\"font-size:40px;line-height:40px;height:40px;text-align:left\"></td>\n          <td style=\"text-align:left\"><table cellspacing=\"0\" cellpadding=\"0\" width=\"596\" border=\"0\" bgcolor=\"#ffffff\">\n            <tbody><tr>\n              <td width=\"20\" height=\"26\" style=\"font-size:26px;line-height:26px;height:26px;text-align:left\"></td>\n              <td width=\"556\" height=\"26\" style=\"font-size:26px;line-height:26px;height:26px;text-align:left\"></td>\n              <td width=\"20\" height=\"26\" style=\"font-size:26px;line-height:26px;height:26px;text-align:left\"></td>\n            </tr>\n            <tr>\n              <td width=\"20\" height=\"26\" style=\"font-size:26px;line-height:26px;height:26px;text-align:left\"></td>\n              <td width=\"556\" style=\"text-align:left\"><table cellspacing=\"0\" cellpadding=\"0\" width=\"556\" border=\"0\" style=\"font-family:helvetica,arial,sans-seif;color:#666666;font-size:16px;line-height:22px\">\n                <tbody><tr>\n                  <td style=\"text-align:left\"></td>\n                </tr>\n                <tr>\n                  <td style=\"text-align:left\"><table cellspacing=\"0\" cellpadding=\"0\" width=\"556\" border=\"0\">\n                    <tbody><tr><td style=\"font-family:helvetica,arial,sans-serif;font-size:30px;line-height:40px;font-weight:normal;color:#253c44;text-align:left\"></td></tr>\n                    <tr><td width=\"556\" height=\"20\" style=\"font-size:20px;line-height:20px;height:20px;text-align:left\"></td></tr>\n                    <tr>\n                      <td style=\"text-align:left\">\n                 Hi {{name}},<br>\n                 <br>\n                Welcome to {{business_name}}! This message is an automated reply to your account verification request. Click the following url to verify your account:\n            <br>\n                <a target=\"_blank\" style=\"color:#ff6600;font-weight:bold;font-family:helvetica,arial,sans-seif;text-decoration:none\" href=\"{{sys_url}}\">{{sys_url}}</a>\n            <br>\n            Regards,<br>\n            {{business_name}}<br>\n            <br>\n          </td>\n                    </tr>\n                    <tr>\n                      <td width=\"556\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\">&nbsp;</td>\n                    </tr>\n                  </tbody></table></td>\n                </tr>\n              </tbody></table></td>\n              <td width=\"20\" height=\"26\" style=\"font-size:26px;line-height:26px;height:26px;text-align:left\"></td>\n            </tr>\n            <tr>\n              <td width=\"20\" height=\"2\" bgcolor=\"#d9dfe1\" style=\"background-color:#d9dfe1;font-size:2px;line-height:2px;height:2px;text-align:left\"></td>\n              <td width=\"556\" height=\"2\" bgcolor=\"#d9dfe1\" style=\"background-color:#d9dfe1;font-size:2px;line-height:2px;height:2px;text-align:left\"></td>\n              <td width=\"20\" height=\"2\" bgcolor=\"#d9dfe1\" style=\"background-color:#d9dfe1;font-size:2px;line-height:2px;height:2px;text-align:left\"></td>\n            </tr>\n          </tbody></table></td>\n          <td width=\"37\" height=\"40\" style=\"font-size:40px;line-height:40px;height:40px;text-align:left\"></td>\n        </tr>\n        <tr>\n          <td width=\"38\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n          <td width=\"596\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n          <td width=\"37\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n        </tr>\n      </tbody></table>\n  </td></tr>\n</tbody>\n</table>\n<table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" border=\"0\" bgcolor=\"#273f47\"><tbody><tr><td align=\"center\">&nbsp;</td></tr></tbody></table>\n<table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" border=\"0\" bgcolor=\"#364a51\">\n  <tbody><tr>\n    <td align=\"center\">\n       <table cellspacing=\"0\" cellpadding=\"0\" width=\"672\" border=\"0\" bgcolor=\"#364a51\">\n              <tbody><tr>\n              <td width=\"38\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n          <td width=\"569\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n          <td width=\"38\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n              </tr>\n              <tr>\n                <td width=\"38\" height=\"40\" style=\"font-size:40px;line-height:40px;text-align:left\">\n                </td>\n                <td valign=\"top\" style=\"font-family:helvetica,arial,sans-seif;font-size:12px;line-height:16px;color:#949fa3;text-align:left\">Copyright &copy; {{business_name}}, All rights reserved.<br><br><br></td>\n                <td width=\"38\" height=\"40\" style=\"font-size:40px;line-height:40px;text-align:left\"></td>\n              </tr>\n              <tr>\n              <td width=\"38\" height=\"40\" style=\"font-size:40px;line-height:40px;text-align:left\"></td>\n              <td width=\"569\" height=\"40\" style=\"font-size:40px;line-height:40px;text-align:left\"></td>\n                <td width=\"38\" height=\"40\" style=\"font-size:40px;line-height:40px;text-align:left\"></td>\n              </tr>\n            </tbody></table>\n     </td>\n  </tr>\n</tbody></table><div class=\"yj6qo\"></div><div class=\"adL\">\n\n</div></div>\n', '1', '2018-01-27 10:04:05', '2018-01-27 10:04:05'),
(3, 'Ticket For Client', 'New Ticket From {{business_name}}', '<div style=\"margin:0;padding:0\">\n<table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" border=\"0\" bgcolor=\"#439cc8\">\n  <tbody><tr>\n    <td align=\"center\">\n            <table cellspacing=\"0\" cellpadding=\"0\" width=\"672\" border=\"0\">\n              <tbody><tr>\n                <td height=\"95\" bgcolor=\"#439cc8\" style=\"background:#439cc8;text-align:left\">\n                <table cellspacing=\"0\" cellpadding=\"0\" width=\"672\" border=\"0\">\n                      <tbody><tr>\n                        <td width=\"672\" height=\"40\" style=\"font-size:40px;line-height:40px;height:40px;text-align:left\"></td>\n                      </tr>\n                      <tr>\n                        <td style=\"text-align:left\">\n                        <table cellspacing=\"0\" cellpadding=\"0\" width=\"672\" border=\"0\">\n                          <tbody><tr>\n                            <td width=\"37\" height=\"24\" style=\"font-size:40px;line-height:40px;height:40px;text-align:left\">\n                            </td>\n                            <td width=\"523\" height=\"24\" style=\"text-align:left\">\n                            <div width=\"125\" height=\"23\" style=\"display:block;color:#ffffff;font-size:20px;font-family:Arial,Helvetica,sans-serif;max-width:557px;min-height:auto\" >{{business_name}}</div>\n                            </td>\n                            <td width=\"44\" style=\"text-align:left\"></td>\n                            <td width=\"30\" style=\"text-align:left\"></td>\n                            <td width=\"38\" height=\"24\" style=\"font-size:40px;line-height:40px;height:40px;text-align:left\"></td>\n                          </tr>\n                        </tbody></table>\n                        </td>\n                      </tr>\n                      <tr><td width=\"672\" height=\"33\" style=\"font-size:33px;line-height:33px;height:33px;text-align:left\"></td></tr>\n                    </tbody></table>\n\n                </td>\n              </tr>\n            </tbody></table>\n     </td>\n    </tr>\n </tbody></table>\n\n <table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" bgcolor=\"#439cc8\"><tbody><tr><td height=\"5\" style=\"background:#439cc8;height:5px;font-size:5px;line-height:5px\"></td></tr></tbody></table>\n\n <table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" border=\"0\" bgcolor=\"#e9eff0\">\n  <tbody><tr>\n    <td align=\"center\">\n      <table cellspacing=\"0\" cellpadding=\"0\" width=\"671\" border=\"0\" bgcolor=\"#e9eff0\" style=\"background:#e9eff0\">\n        <tbody><tr>\n          <td width=\"38\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n          <td width=\"596\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n          <td width=\"37\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n        </tr>\n        <tr>\n          <td width=\"38\" height=\"40\" style=\"font-size:40px;line-height:40px;height:40px;text-align:left\"></td>\n          <td style=\"text-align:left\"><table cellspacing=\"0\" cellpadding=\"0\" width=\"596\" border=\"0\" bgcolor=\"#ffffff\">\n            <tbody><tr>\n              <td width=\"20\" height=\"26\" style=\"font-size:26px;line-height:26px;height:26px;text-align:left\"></td>\n              <td width=\"556\" height=\"26\" style=\"font-size:26px;line-height:26px;height:26px;text-align:left\"></td>\n              <td width=\"20\" height=\"26\" style=\"font-size:26px;line-height:26px;height:26px;text-align:left\"></td>\n            </tr>\n            <tr>\n              <td width=\"20\" height=\"26\" style=\"font-size:26px;line-height:26px;height:26px;text-align:left\"></td>\n              <td width=\"556\" style=\"text-align:left\"><table cellspacing=\"0\" cellpadding=\"0\" width=\"556\" border=\"0\" style=\"font-family:helvetica,arial,sans-seif;color:#666666;font-size:16px;line-height:22px\">\n                <tbody><tr>\n                  <td style=\"text-align:left\"></td>\n                </tr>\n                <tr>\n                  <td style=\"text-align:left\"><table cellspacing=\"0\" cellpadding=\"0\" width=\"556\" border=\"0\">\n                    <tbody><tr><td style=\"font-family:helvetica,arial,sans-serif;font-size:30px;line-height:40px;font-weight:normal;color:#253c44;text-align:left\"></td></tr>\n                    <tr><td width=\"556\" height=\"20\" style=\"font-size:20px;line-height:20px;height:20px;text-align:left\"></td></tr>\n                    <tr>\n                      <td style=\"text-align:left\">\n                 Hi {{name}},<br>\n                 <br>\n                Thank you for stay with us! This is a Support Ticket For Yours.. Login to your account to view  your support tickets details:\n            <br>\n                <a target=\"_blank\" style=\"color:#ff6600;font-weight:bold;font-family:helvetica,arial,sans-seif;text-decoration:none\" href=\"{{sys_url}}\">{{sys_url}}</a>.<br>\n                Ticket ID: {{ticket_id}}<br>\n                Ticket Subject: {{ticket_subject}}<br>\n                Message: {{message}}<br>\n                Created By: {{create_by}}\n            <br>\n            Regards,<br>\n            {{business_name}}<br>\n            <br>\n          </td>\n                    </tr>\n                    <tr>\n                      <td width=\"556\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\">Â </td>\n                    </tr>\n                  </tbody></table></td>\n                </tr>\n              </tbody></table></td>\n              <td width=\"20\" height=\"26\" style=\"font-size:26px;line-height:26px;height:26px;text-align:left\"></td>\n            </tr>\n            <tr>\n              <td width=\"20\" height=\"2\" bgcolor=\"#d9dfe1\" style=\"background-color:#d9dfe1;font-size:2px;line-height:2px;height:2px;text-align:left\"></td>\n              <td width=\"556\" height=\"2\" bgcolor=\"#d9dfe1\" style=\"background-color:#d9dfe1;font-size:2px;line-height:2px;height:2px;text-align:left\"></td>\n              <td width=\"20\" height=\"2\" bgcolor=\"#d9dfe1\" style=\"background-color:#d9dfe1;font-size:2px;line-height:2px;height:2px;text-align:left\"></td>\n            </tr>\n          </tbody></table></td>\n          <td width=\"37\" height=\"40\" style=\"font-size:40px;line-height:40px;height:40px;text-align:left\"></td>\n        </tr>\n        <tr>\n          <td width=\"38\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n          <td width=\"596\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n          <td width=\"37\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n        </tr>\n      </tbody></table>\n  </td></tr>\n</tbody>\n</table>\n<table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" border=\"0\" bgcolor=\"#273f47\"><tbody><tr><td align=\"center\"> </td></tr></tbody></table>\n<table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" border=\"0\" bgcolor=\"#364a51\">\n  <tbody><tr>\n    <td align=\"center\">\n       <table cellspacing=\"0\" cellpadding=\"0\" width=\"672\" border=\"0\" bgcolor=\"#364a51\">\n              <tbody><tr>\n              <td width=\"38\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n          <td width=\"569\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n          <td width=\"38\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n              </tr>\n              <tr>\n                <td width=\"38\" height=\"40\" style=\"font-size:40px;line-height:40px;text-align:left\">\n                </td>\n                <td valign=\"top\" style=\"font-family:helvetica,arial,sans-seif;font-size:12px;line-height:16px;color:#949fa3;text-align:left\">Copyright Â© {{business_name}}, All rights reserved.<br><br><br></td>\n                <td width=\"38\" height=\"40\" style=\"font-size:40px;line-height:40px;text-align:left\"></td>\n              </tr>\n              <tr>\n              <td width=\"38\" height=\"40\" style=\"font-size:40px;line-height:40px;text-align:left\"></td>\n              <td width=\"569\" height=\"40\" style=\"font-size:40px;line-height:40px;text-align:left\"></td>\n                <td width=\"38\" height=\"40\" style=\"font-size:40px;line-height:40px;text-align:left\"></td>\n              </tr>\n            </tbody></table>\n     </td>\n  </tr>\n</tbody></table><div class=\"yj6qo\"></div><div class=\"adL\">\n\n</div></div>\n\n                ', '1', '2018-01-27 10:04:05', '2018-01-27 10:04:05'),
(4, 'Admin Password Reset', '{{business_name}} New Password', '<div style=\"margin:0;padding:0\">\n<table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" border=\"0\" bgcolor=\"#439cc8\">\n  <tbody><tr>\n    <td align=\"center\">\n            <table cellspacing=\"0\" cellpadding=\"0\" width=\"672\" border=\"0\">\n              <tbody><tr>\n                <td height=\"95\" bgcolor=\"#439cc8\" style=\"background:#439cc8;text-align:left\">\n                <table cellspacing=\"0\" cellpadding=\"0\" width=\"672\" border=\"0\">\n                      <tbody><tr>\n                        <td width=\"672\" height=\"40\" style=\"font-size:40px;line-height:40px;height:40px;text-align:left\"></td>\n                      </tr>\n                      <tr>\n                        <td style=\"text-align:left\">\n                        <table cellspacing=\"0\" cellpadding=\"0\" width=\"672\" border=\"0\">\n                          <tbody><tr>\n                            <td width=\"37\" height=\"24\" style=\"font-size:40px;line-height:40px;height:40px;text-align:left\">\n                            </td>\n                            <td width=\"523\" height=\"24\" style=\"text-align:left\">\n                            <p  style=\"display:block;color:#ffffff;font-size:20px;font-family:Arial,Helvetica,sans-serif;max-width:557px;min-height:auto\">{{business_name}}</p>\n                            </td>\n                            <td width=\"44\" style=\"text-align:left\"></td>\n                            <td width=\"30\" style=\"text-align:left\"></td>\n                            <td width=\"38\" height=\"24\" style=\"font-size:40px;line-height:40px;height:40px;text-align:left\"></td>\n                          </tr>\n                        </tbody></table>\n                        </td>\n                      </tr>\n                      <tr><td width=\"672\" height=\"33\" style=\"font-size:33px;line-height:33px;height:33px;text-align:left\"></td></tr>\n                    </tbody></table>\n\n                </td>\n              </tr>\n            </tbody></table>\n     </td>\n    </tr>\n </tbody></table>\n\n <table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" bgcolor=\"#439cc8\"><tbody><tr><td height=\"5\" style=\"background:#439cc8;height:5px;font-size:5px;line-height:5px\"></td></tr></tbody></table>\n\n <table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" border=\"0\" bgcolor=\"#e9eff0\">\n  <tbody><tr>\n    <td align=\"center\">\n      <table cellspacing=\"0\" cellpadding=\"0\" width=\"671\" border=\"0\" bgcolor=\"#e9eff0\" style=\"background:#e9eff0\">\n        <tbody><tr>\n          <td width=\"38\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n          <td width=\"596\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n          <td width=\"37\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n        </tr>\n        <tr>\n          <td width=\"38\" height=\"40\" style=\"font-size:40px;line-height:40px;height:40px;text-align:left\"></td>\n          <td style=\"text-align:left\"><table cellspacing=\"0\" cellpadding=\"0\" width=\"596\" border=\"0\" bgcolor=\"#ffffff\">\n            <tbody><tr>\n              <td width=\"20\" height=\"26\" style=\"font-size:26px;line-height:26px;height:26px;text-align:left\"></td>\n              <td width=\"556\" height=\"26\" style=\"font-size:26px;line-height:26px;height:26px;text-align:left\"></td>\n              <td width=\"20\" height=\"26\" style=\"font-size:26px;line-height:26px;height:26px;text-align:left\"></td>\n            </tr>\n            <tr>\n              <td width=\"20\" height=\"26\" style=\"font-size:26px;line-height:26px;height:26px;text-align:left\"></td>\n              <td width=\"556\" style=\"text-align:left\"><table cellspacing=\"0\" cellpadding=\"0\" width=\"556\" border=\"0\" style=\"font-family:helvetica,arial,sans-seif;color:#666666;font-size:16px;line-height:22px\">\n                <tbody><tr>\n                  <td style=\"text-align:left\"></td>\n                </tr>\n                <tr>\n                  <td style=\"text-align:left\"><table cellspacing=\"0\" cellpadding=\"0\" width=\"556\" border=\"0\">\n                    <tbody><tr><td style=\"font-family:helvetica,arial,sans-serif;font-size:30px;line-height:40px;font-weight:normal;color:#253c44;text-align:left\"></td></tr>\n                    <tr><td width=\"556\" height=\"20\" style=\"font-size:20px;line-height:20px;height:20px;text-align:left\"></td></tr>\n                    <tr>\n                      <td style=\"text-align:left\">\n                 Hi {{name}},<br>\n                 <br>\n                Password Reset Successfully!   This message is an automated reply to your password reset request. Login to your account to set up your all details by using the details below:\n            <br>\n                <a target=\"_blank\" style=\"color:#ff6600;font-weight:bold;font-family:helvetica,arial,sans-seif;text-decoration:none\" href=\" {{sys_url}}\"> {{sys_url}}</a>.<br>\n                                    User Name: {{username}}<br>\n                                    Password: {{password}}\n            <br>\n            {{business_name}},<br>\n            <br>\n          </td>\n                    </tr>\n                    <tr>\n                      <td width=\"556\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\">&nbsp;</td>\n                    </tr>\n                  </tbody></table></td>\n                </tr>\n              </tbody></table></td>\n              <td width=\"20\" height=\"26\" style=\"font-size:26px;line-height:26px;height:26px;text-align:left\"></td>\n            </tr>\n            <tr>\n              <td width=\"20\" height=\"2\" bgcolor=\"#d9dfe1\" style=\"background-color:#d9dfe1;font-size:2px;line-height:2px;height:2px;text-align:left\"></td>\n              <td width=\"556\" height=\"2\" bgcolor=\"#d9dfe1\" style=\"background-color:#d9dfe1;font-size:2px;line-height:2px;height:2px;text-align:left\"></td>\n              <td width=\"20\" height=\"2\" bgcolor=\"#d9dfe1\" style=\"background-color:#d9dfe1;font-size:2px;line-height:2px;height:2px;text-align:left\"></td>\n            </tr>\n          </tbody></table></td>\n          <td width=\"37\" height=\"40\" style=\"font-size:40px;line-height:40px;height:40px;text-align:left\"></td>\n        </tr>\n        <tr>\n          <td width=\"38\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n          <td width=\"596\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n          <td width=\"37\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n        </tr>\n      </tbody></table>\n  </td></tr>\n</tbody>\n</table>\n<table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" border=\"0\" bgcolor=\"#273f47\"><tbody><tr><td align=\"center\">&nbsp;</td></tr></tbody></table>\n<table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" border=\"0\" bgcolor=\"#364a51\">\n  <tbody><tr>\n    <td align=\"center\">\n       <table cellspacing=\"0\" cellpadding=\"0\" width=\"672\" border=\"0\" bgcolor=\"#364a51\">\n              <tbody><tr>\n              <td width=\"38\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n          <td width=\"569\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n          <td width=\"38\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n              </tr>\n              <tr>\n                <td width=\"38\" height=\"40\" style=\"font-size:40px;line-height:40px;text-align:left\">\n                </td>\n                <td valign=\"top\" style=\"font-family:helvetica,arial,sans-seif;font-size:12px;line-height:16px;color:#949fa3;text-align:left\">Copyright &copy; {{business_name}}, All rights reserved.<br><br><br></td>\n                <td width=\"38\" height=\"40\" style=\"font-size:40px;line-height:40px;text-align:left\"></td>\n              </tr>\n              <tr>\n              <td width=\"38\" height=\"40\" style=\"font-size:40px;line-height:40px;text-align:left\"></td>\n              <td width=\"569\" height=\"40\" style=\"font-size:40px;line-height:40px;text-align:left\"></td>\n                <td width=\"38\" height=\"40\" style=\"font-size:40px;line-height:40px;text-align:left\"></td>\n              </tr>\n            </tbody></table>\n     </td>\n  </tr>\n</tbody></table><div class=\"yj6qo\"></div><div class=\"adL\">\n\n</div></div>\n', '1', '2018-01-27 10:04:05', '2018-01-27 10:04:05'),
(5, 'Forgot Admin Password', '{{business_name}} password change request', '<div style=\"margin:0;padding:0\">\n<table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" border=\"0\" bgcolor=\"#439cc8\">\n  <tbody><tr>\n    <td align=\"center\">\n            <table cellspacing=\"0\" cellpadding=\"0\" width=\"672\" border=\"0\">\n              <tbody><tr>\n                <td height=\"95\" bgcolor=\"#439cc8\" style=\"background:#439cc8;text-align:left\">\n                <table cellspacing=\"0\" cellpadding=\"0\" width=\"672\" border=\"0\">\n                      <tbody><tr>\n                        <td width=\"672\" height=\"40\" style=\"font-size:40px;line-height:40px;height:40px;text-align:left\"></td>\n                      </tr>\n                      <tr>\n                        <td style=\"text-align:left\">\n                        <table cellspacing=\"0\" cellpadding=\"0\" width=\"672\" border=\"0\">\n                          <tbody><tr>\n                            <td width=\"37\" height=\"24\" style=\"font-size:40px;line-height:40px;height:40px;text-align:left\">\n                            </td>\n                            <td width=\"523\" height=\"24\" style=\"text-align:left\">\n                            <p  style=\"display:block;color:#ffffff;font-size:20px;font-family:Arial,Helvetica,sans-serif;max-width:557px;min-height:auto\" >{{business_name}}</p>\n                            </td>\n                            <td width=\"44\" style=\"text-align:left\"></td>\n                            <td width=\"30\" style=\"text-align:left\"></td>\n                            <td width=\"38\" height=\"24\" style=\"font-size:40px;line-height:40px;height:40px;text-align:left\"></td>\n                          </tr>\n                        </tbody></table>\n                        </td>\n                      </tr>\n                      <tr><td width=\"672\" height=\"33\" style=\"font-size:33px;line-height:33px;height:33px;text-align:left\"></td></tr>\n                    </tbody></table>\n\n                </td>\n              </tr>\n            </tbody></table>\n     </td>\n    </tr>\n </tbody></table>\n\n <table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" bgcolor=\"#439cc8\"><tbody><tr><td height=\"5\" style=\"background:#439cc8;height:5px;font-size:5px;line-height:5px\"></td></tr></tbody></table>\n\n <table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" border=\"0\" bgcolor=\"#e9eff0\">\n  <tbody><tr>\n    <td align=\"center\">\n      <table cellspacing=\"0\" cellpadding=\"0\" width=\"671\" border=\"0\" bgcolor=\"#e9eff0\" style=\"background:#e9eff0\">\n        <tbody><tr>\n          <td width=\"38\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n          <td width=\"596\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n          <td width=\"37\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n        </tr>\n        <tr>\n          <td width=\"38\" height=\"40\" style=\"font-size:40px;line-height:40px;height:40px;text-align:left\"></td>\n          <td style=\"text-align:left\"><table cellspacing=\"0\" cellpadding=\"0\" width=\"596\" border=\"0\" bgcolor=\"#ffffff\">\n            <tbody><tr>\n              <td width=\"20\" height=\"26\" style=\"font-size:26px;line-height:26px;height:26px;text-align:left\"></td>\n              <td width=\"556\" height=\"26\" style=\"font-size:26px;line-height:26px;height:26px;text-align:left\"></td>\n              <td width=\"20\" height=\"26\" style=\"font-size:26px;line-height:26px;height:26px;text-align:left\"></td>\n            </tr>\n            <tr>\n              <td width=\"20\" height=\"26\" style=\"font-size:26px;line-height:26px;height:26px;text-align:left\"></td>\n              <td width=\"556\" style=\"text-align:left\"><table cellspacing=\"0\" cellpadding=\"0\" width=\"556\" border=\"0\" style=\"font-family:helvetica,arial,sans-seif;color:#666666;font-size:16px;line-height:22px\">\n                <tbody><tr>\n                  <td style=\"text-align:left\"></td>\n                </tr>\n                <tr>\n                  <td style=\"text-align:left\"><table cellspacing=\"0\" cellpadding=\"0\" width=\"556\" border=\"0\">\n                    <tbody><tr><td style=\"font-family:helvetica,arial,sans-serif;font-size:30px;line-height:40px;font-weight:normal;color:#253c44;text-align:left\"></td></tr>\n                    <tr><td width=\"556\" height=\"20\" style=\"font-size:20px;line-height:20px;height:20px;text-align:left\"></td></tr>\n                    <tr>\n                      <td style=\"text-align:left\">\n                 Hi {{name}},<br>\n                 <br>\n                Password Reset Successfully!   This message is an automated reply to your password reset request. Click this link to reset your password:\n            <br>\n                <a target=\"_blank\" style=\"color:#ff6600;font-weight:bold;font-family:helvetica,arial,sans-seif;text-decoration:none\" href=\" {{forgotpw_link}} \"> {{forgotpw_link}} </a>.<br>\nNotes: Until your password has been changed, your current password will remain valid. The Forgot Password Link will be available for a limited time only.\n\n            <br>\n            On behalf of the {{business_name}},<br>\n            <br>\n          </td>\n                    </tr>\n                    <tr>\n                      <td width=\"556\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\">&nbsp;</td>\n                    </tr>\n                  </tbody></table></td>\n                </tr>\n              </tbody></table></td>\n              <td width=\"20\" height=\"26\" style=\"font-size:26px;line-height:26px;height:26px;text-align:left\"></td>\n            </tr>\n            <tr>\n              <td width=\"20\" height=\"2\" bgcolor=\"#d9dfe1\" style=\"background-color:#d9dfe1;font-size:2px;line-height:2px;height:2px;text-align:left\"></td>\n              <td width=\"556\" height=\"2\" bgcolor=\"#d9dfe1\" style=\"background-color:#d9dfe1;font-size:2px;line-height:2px;height:2px;text-align:left\"></td>\n              <td width=\"20\" height=\"2\" bgcolor=\"#d9dfe1\" style=\"background-color:#d9dfe1;font-size:2px;line-height:2px;height:2px;text-align:left\"></td>\n            </tr>\n          </tbody></table></td>\n          <td width=\"37\" height=\"40\" style=\"font-size:40px;line-height:40px;height:40px;text-align:left\"></td>\n        </tr>\n        <tr>\n          <td width=\"38\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n          <td width=\"596\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n          <td width=\"37\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n        </tr>\n      </tbody></table>\n  </td></tr>\n</tbody>\n</table>\n<table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" border=\"0\" bgcolor=\"#273f47\"><tbody><tr><td align=\"center\">&nbsp;</td></tr></tbody></table>\n<table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" border=\"0\" bgcolor=\"#364a51\">\n  <tbody><tr>\n    <td align=\"center\">\n       <table cellspacing=\"0\" cellpadding=\"0\" width=\"672\" border=\"0\" bgcolor=\"#364a51\">\n              <tbody><tr>\n              <td width=\"38\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n          <td width=\"569\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n          <td width=\"38\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n              </tr>\n              <tr>\n                <td width=\"38\" height=\"40\" style=\"font-size:40px;line-height:40px;text-align:left\">\n                </td>\n                <td valign=\"top\" style=\"font-family:helvetica,arial,sans-seif;font-size:12px;line-height:16px;color:#949fa3;text-align:left\">Copyright &copy; {{business_name}}, All rights reserved.<br><br><br></td>\n                <td width=\"38\" height=\"40\" style=\"font-size:40px;line-height:40px;text-align:left\"></td>\n              </tr>\n              <tr>\n              <td width=\"38\" height=\"40\" style=\"font-size:40px;line-height:40px;text-align:left\"></td>\n              <td width=\"569\" height=\"40\" style=\"font-size:40px;line-height:40px;text-align:left\"></td>\n                <td width=\"38\" height=\"40\" style=\"font-size:40px;line-height:40px;text-align:left\"></td>\n              </tr>\n            </tbody></table>\n     </td>\n  </tr>\n</tbody></table><div class=\"yj6qo\"></div><div class=\"adL\">\n\n</div></div>\n', '1', '2018-01-27 10:04:05', '2018-01-27 10:04:05');
INSERT INTO `sys_email_templates` (`id`, `tplname`, `subject`, `message`, `status`, `created_at`, `updated_at`) VALUES
(6, 'Ticket Reply', 'Reply to Ticket [TID-{{ticket_id}}]', '<div style=\"margin:0;padding:0\">\n<table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" border=\"0\" bgcolor=\"#439cc8\">\n  <tbody><tr>\n    <td align=\"center\">\n            <table cellspacing=\"0\" cellpadding=\"0\" width=\"672\" border=\"0\">\n              <tbody><tr>\n                <td height=\"95\" bgcolor=\"#439cc8\" style=\"background:#439cc8;text-align:left\">\n                <table cellspacing=\"0\" cellpadding=\"0\" width=\"672\" border=\"0\">\n                      <tbody><tr>\n                        <td width=\"672\" height=\"40\" style=\"font-size:40px;line-height:40px;height:40px;text-align:left\"></td>\n                      </tr>\n                      <tr>\n                        <td style=\"text-align:left\">\n                        <table cellspacing=\"0\" cellpadding=\"0\" width=\"672\" border=\"0\">\n                          <tbody><tr>\n                            <td width=\"37\" height=\"24\" style=\"font-size:40px;line-height:40px;height:40px;text-align:left\">\n                            </td>\n                            <td width=\"523\" height=\"24\" style=\"text-align:left\">\n                            <div width=\"125\" height=\"23\" style=\"display:block;color:#ffffff;font-size:20px;font-family:Arial,Helvetica,sans-serif;max-width:557px;min-height:auto\"  {{business_name}} ></div>\n                            </td>\n                            <td width=\"44\" style=\"text-align:left\"></td>\n                            <td width=\"30\" style=\"text-align:left\"></td>\n                            <td width=\"38\" height=\"24\" style=\"font-size:40px;line-height:40px;height:40px;text-align:left\"></td>\n                          </tr>\n                        </tbody></table>\n                        </td>\n                      </tr>\n                      <tr><td width=\"672\" height=\"33\" style=\"font-size:33px;line-height:33px;height:33px;text-align:left\"></td></tr>\n                    </tbody></table>\n\n                </td>\n              </tr>\n            </tbody></table>\n     </td>\n    </tr>\n </tbody></table>\n\n <table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" bgcolor=\"#439cc8\"><tbody><tr><td height=\"5\" style=\"background:#439cc8;height:5px;font-size:5px;line-height:5px\"></td></tr></tbody></table>\n\n <table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" border=\"0\" bgcolor=\"#e9eff0\">\n  <tbody><tr>\n    <td align=\"center\">\n      <table cellspacing=\"0\" cellpadding=\"0\" width=\"671\" border=\"0\" bgcolor=\"#e9eff0\" style=\"background:#e9eff0\">\n        <tbody><tr>\n          <td width=\"38\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n          <td width=\"596\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n          <td width=\"37\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n        </tr>\n        <tr>\n          <td width=\"38\" height=\"40\" style=\"font-size:40px;line-height:40px;height:40px;text-align:left\"></td>\n          <td style=\"text-align:left\"><table cellspacing=\"0\" cellpadding=\"0\" width=\"596\" border=\"0\" bgcolor=\"#ffffff\">\n            <tbody><tr>\n              <td width=\"20\" height=\"26\" style=\"font-size:26px;line-height:26px;height:26px;text-align:left\"></td>\n              <td width=\"556\" height=\"26\" style=\"font-size:26px;line-height:26px;height:26px;text-align:left\"></td>\n              <td width=\"20\" height=\"26\" style=\"font-size:26px;line-height:26px;height:26px;text-align:left\"></td>\n            </tr>\n            <tr>\n              <td width=\"20\" height=\"26\" style=\"font-size:26px;line-height:26px;height:26px;text-align:left\"></td>\n              <td width=\"556\" style=\"text-align:left\"><table cellspacing=\"0\" cellpadding=\"0\" width=\"556\" border=\"0\" style=\"font-family:helvetica,arial,sans-seif;color:#666666;font-size:16px;line-height:22px\">\n                <tbody><tr>\n                  <td style=\"text-align:left\"></td>\n                </tr>\n                <tr>\n                  <td style=\"text-align:left\"><table cellspacing=\"0\" cellpadding=\"0\" width=\"556\" border=\"0\">\n                    <tbody><tr><td style=\"font-family:helvetica,arial,sans-serif;font-size:30px;line-height:40px;font-weight:normal;color:#253c44;text-align:left\"></td></tr>\n                    <tr><td width=\"556\" height=\"20\" style=\"font-size:20px;line-height:20px;height:20px;text-align:left\"></td></tr>\n                    <tr>\n                      <td style=\"text-align:left\">\n                 Hi {{name}},<br>\n                 <br>\n                Thank you for stay with us! This is a Support Ticket Reply. Login to your account to view  your support ticket reply details:\n            <br>\n                <a target=\"_blank\" style=\"color:#ff6600;font-weight:bold;font-family:helvetica,arial,sans-seif;text-decoration:none\" href=\"{{sys_url}}\">{{sys_url}}</a>.<br>\n                Ticket ID: {{ticket_id}}<br>\n                Ticket Subject: {{ticket_subject}}<br>\n                Message: {{message}}<br>\n                Replyed By: {{reply_by}} <br><br>\n                Should you have any questions in regards to this support ticket or any other tickets related issue, please feel free to contact the Support department by creating a new ticket from your Client/User Portal\n            <br><br>\n            Regards,<br>\n            {{business_name}}<br>\n            <br>\n          </td>\n                    </tr>\n                    <tr>\n                      <td width=\"556\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\">&nbsp;</td>\n                    </tr>\n                  </tbody></table></td>\n                </tr>\n              </tbody></table></td>\n              <td width=\"20\" height=\"26\" style=\"font-size:26px;line-height:26px;height:26px;text-align:left\"></td>\n            </tr>\n            <tr>\n              <td width=\"20\" height=\"2\" bgcolor=\"#d9dfe1\" style=\"background-color:#d9dfe1;font-size:2px;line-height:2px;height:2px;text-align:left\"></td>\n              <td width=\"556\" height=\"2\" bgcolor=\"#d9dfe1\" style=\"background-color:#d9dfe1;font-size:2px;line-height:2px;height:2px;text-align:left\"></td>\n              <td width=\"20\" height=\"2\" bgcolor=\"#d9dfe1\" style=\"background-color:#d9dfe1;font-size:2px;line-height:2px;height:2px;text-align:left\"></td>\n            </tr>\n          </tbody></table></td>\n          <td width=\"37\" height=\"40\" style=\"font-size:40px;line-height:40px;height:40px;text-align:left\"></td>\n        </tr>\n        <tr>\n          <td width=\"38\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n          <td width=\"596\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n          <td width=\"37\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n        </tr>\n      </tbody></table>\n  </td></tr>\n</tbody>\n</table>\n<table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" border=\"0\" bgcolor=\"#273f47\"><tbody><tr><td align=\"center\">&nbsp;</td></tr></tbody></table>\n<table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" border=\"0\" bgcolor=\"#364a51\">\n  <tbody><tr>\n    <td align=\"center\">\n       <table cellspacing=\"0\" cellpadding=\"0\" width=\"672\" border=\"0\" bgcolor=\"#364a51\">\n              <tbody><tr>\n              <td width=\"38\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n          <td width=\"569\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n          <td width=\"38\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n              </tr>\n              <tr>\n                <td width=\"38\" height=\"40\" style=\"font-size:40px;line-height:40px;text-align:left\">\n                </td>\n                <td valign=\"top\" style=\"font-family:helvetica,arial,sans-seif;font-size:12px;line-height:16px;color:#949fa3;text-align:left\">Copyright &copy; {{business_name}}, All rights reserved.<br><br><br></td>\n                <td width=\"38\" height=\"40\" style=\"font-size:40px;line-height:40px;text-align:left\"></td>\n              </tr>\n              <tr>\n              <td width=\"38\" height=\"40\" style=\"font-size:40px;line-height:40px;text-align:left\"></td>\n              <td width=\"569\" height=\"40\" style=\"font-size:40px;line-height:40px;text-align:left\"></td>\n                <td width=\"38\" height=\"40\" style=\"font-size:40px;line-height:40px;text-align:left\"></td>\n              </tr>\n            </tbody></table>\n     </td>\n  </tr>\n</tbody></table><div class=\"yj6qo\"></div><div class=\"adL\">\n\n</div></div>\n', '1', '2018-01-27 10:04:05', '2018-01-27 10:04:05'),
(7, 'Forgot Client Password', '{{business_name}} password change request', '<div style=\"margin:0;padding:0\">\n<table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" border=\"0\" bgcolor=\"#439cc8\">\n  <tbody><tr>\n    <td align=\"center\">\n            <table cellspacing=\"0\" cellpadding=\"0\" width=\"672\" border=\"0\">\n              <tbody><tr>\n                <td height=\"95\" bgcolor=\"#439cc8\" style=\"background:#439cc8;text-align:left\">\n                <table cellspacing=\"0\" cellpadding=\"0\" width=\"672\" border=\"0\">\n                      <tbody><tr>\n                        <td width=\"672\" height=\"40\" style=\"font-size:40px;line-height:40px;height:40px;text-align:left\"></td>\n                      </tr>\n                      <tr>\n                        <td style=\"text-align:left\">\n                        <table cellspacing=\"0\" cellpadding=\"0\" width=\"672\" border=\"0\">\n                          <tbody><tr>\n                            <td width=\"37\" height=\"24\" style=\"font-size:40px;line-height:40px;height:40px;text-align:left\">\n                            </td>\n                            <td width=\"523\" height=\"24\" style=\"text-align:left\">\n                            <p  style=\"display:block;color:#ffffff;font-size:20px;font-family:Arial,Helvetica,sans-serif;max-width:557px;min-height:auto\">{{business_name}} </p>\n                            </td>\n                            <td width=\"44\" style=\"text-align:left\"></td>\n                            <td width=\"30\" style=\"text-align:left\"></td>\n                            <td width=\"38\" height=\"24\" style=\"font-size:40px;line-height:40px;height:40px;text-align:left\"></td>\n                          </tr>\n                        </tbody></table>\n                        </td>\n                      </tr>\n                      <tr><td width=\"672\" height=\"33\" style=\"font-size:33px;line-height:33px;height:33px;text-align:left\"></td></tr>\n                    </tbody></table>\n\n                </td>\n              </tr>\n            </tbody></table>\n     </td>\n    </tr>\n </tbody></table>\n\n <table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" bgcolor=\"#439cc8\"><tbody><tr><td height=\"5\" style=\"background:#439cc8;height:5px;font-size:5px;line-height:5px\"></td></tr></tbody></table>\n\n <table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" border=\"0\" bgcolor=\"#e9eff0\">\n  <tbody><tr>\n    <td align=\"center\">\n      <table cellspacing=\"0\" cellpadding=\"0\" width=\"671\" border=\"0\" bgcolor=\"#e9eff0\" style=\"background:#e9eff0\">\n        <tbody><tr>\n          <td width=\"38\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n          <td width=\"596\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n          <td width=\"37\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n        </tr>\n        <tr>\n          <td width=\"38\" height=\"40\" style=\"font-size:40px;line-height:40px;height:40px;text-align:left\"></td>\n          <td style=\"text-align:left\"><table cellspacing=\"0\" cellpadding=\"0\" width=\"596\" border=\"0\" bgcolor=\"#ffffff\">\n            <tbody><tr>\n              <td width=\"20\" height=\"26\" style=\"font-size:26px;line-height:26px;height:26px;text-align:left\"></td>\n              <td width=\"556\" height=\"26\" style=\"font-size:26px;line-height:26px;height:26px;text-align:left\"></td>\n              <td width=\"20\" height=\"26\" style=\"font-size:26px;line-height:26px;height:26px;text-align:left\"></td>\n            </tr>\n            <tr>\n              <td width=\"20\" height=\"26\" style=\"font-size:26px;line-height:26px;height:26px;text-align:left\"></td>\n              <td width=\"556\" style=\"text-align:left\"><table cellspacing=\"0\" cellpadding=\"0\" width=\"556\" border=\"0\" style=\"font-family:helvetica,arial,sans-seif;color:#666666;font-size:16px;line-height:22px\">\n                <tbody><tr>\n                  <td style=\"text-align:left\"></td>\n                </tr>\n                <tr>\n                  <td style=\"text-align:left\"><table cellspacing=\"0\" cellpadding=\"0\" width=\"556\" border=\"0\">\n                    <tbody><tr><td style=\"font-family:helvetica,arial,sans-serif;font-size:30px;line-height:40px;font-weight:normal;color:#253c44;text-align:left\"></td></tr>\n                    <tr><td width=\"556\" height=\"20\" style=\"font-size:20px;line-height:20px;height:20px;text-align:left\"></td></tr>\n                    <tr>\n                      <td style=\"text-align:left\">\n                 Hi {{name}},<br>\n                 <br>\n                Password Reset Successfully!   This message is an automated reply to your password reset request. Click this link to reset your password:\n            <br>\n                <a target=\"_blank\" style=\"color:#ff6600;font-weight:bold;font-family:helvetica,arial,sans-seif;text-decoration:none\" href=\" {{forgotpw_link}} \"> {{forgotpw_link}} </a>.<br>\nNotes: Until your password has been changed, your current password will remain valid. The Forgot Password Link will be available for a limited time only.\n\n            <br>\n            {{business_name}}<br>\n            <br>\n          </td>\n                    </tr>\n                    <tr>\n                      <td width=\"556\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\">&nbsp;</td>\n                    </tr>\n                  </tbody></table></td>\n                </tr>\n              </tbody></table></td>\n              <td width=\"20\" height=\"26\" style=\"font-size:26px;line-height:26px;height:26px;text-align:left\"></td>\n            </tr>\n            <tr>\n              <td width=\"20\" height=\"2\" bgcolor=\"#d9dfe1\" style=\"background-color:#d9dfe1;font-size:2px;line-height:2px;height:2px;text-align:left\"></td>\n              <td width=\"556\" height=\"2\" bgcolor=\"#d9dfe1\" style=\"background-color:#d9dfe1;font-size:2px;line-height:2px;height:2px;text-align:left\"></td>\n              <td width=\"20\" height=\"2\" bgcolor=\"#d9dfe1\" style=\"background-color:#d9dfe1;font-size:2px;line-height:2px;height:2px;text-align:left\"></td>\n            </tr>\n          </tbody></table></td>\n          <td width=\"37\" height=\"40\" style=\"font-size:40px;line-height:40px;height:40px;text-align:left\"></td>\n        </tr>\n        <tr>\n          <td width=\"38\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n          <td width=\"596\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n          <td width=\"37\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n        </tr>\n      </tbody></table>\n  </td></tr>\n</tbody>\n</table>\n<table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" border=\"0\" bgcolor=\"#273f47\"><tbody><tr><td align=\"center\">&nbsp;</td></tr></tbody></table>\n<table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" border=\"0\" bgcolor=\"#364a51\">\n  <tbody><tr>\n    <td align=\"center\">\n       <table cellspacing=\"0\" cellpadding=\"0\" width=\"672\" border=\"0\" bgcolor=\"#364a51\">\n              <tbody><tr>\n              <td width=\"38\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n          <td width=\"569\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n          <td width=\"38\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n              </tr>\n              <tr>\n                <td width=\"38\" height=\"40\" style=\"font-size:40px;line-height:40px;text-align:left\">\n                </td>\n                <td valign=\"top\" style=\"font-family:helvetica,arial,sans-seif;font-size:12px;line-height:16px;color:#949fa3;text-align:left\">Copyright &copy; {{business_name}}, All rights reserved.<br><br><br></td>\n                <td width=\"38\" height=\"40\" style=\"font-size:40px;line-height:40px;text-align:left\"></td>\n              </tr>\n              <tr>\n              <td width=\"38\" height=\"40\" style=\"font-size:40px;line-height:40px;text-align:left\"></td>\n              <td width=\"569\" height=\"40\" style=\"font-size:40px;line-height:40px;text-align:left\"></td>\n                <td width=\"38\" height=\"40\" style=\"font-size:40px;line-height:40px;text-align:left\"></td>\n              </tr>\n            </tbody></table>\n     </td>\n  </tr>\n</tbody></table><div class=\"yj6qo\"></div><div class=\"adL\">\n\n</div></div>\n', '1', '2018-01-27 10:04:05', '2018-01-27 10:04:05'),
(8, 'Client Registrar Activation', '{{business_name}} Registration Code', '<div style=\"margin:0;padding:0\">\n<table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" border=\"0\" bgcolor=\"#439cc8\">\n  <tbody><tr>\n    <td align=\"center\">\n            <table cellspacing=\"0\" cellpadding=\"0\" width=\"672\" border=\"0\">\n              <tbody><tr>\n                <td height=\"95\" bgcolor=\"#439cc8\" style=\"background:#439cc8;text-align:left\">\n                <table cellspacing=\"0\" cellpadding=\"0\" width=\"672\" border=\"0\">\n                      <tbody><tr>\n                        <td width=\"672\" height=\"40\" style=\"font-size:40px;line-height:40px;height:40px;text-align:left\"></td>\n                      </tr>\n                      <tr>\n                        <td style=\"text-align:left\">\n                        <table cellspacing=\"0\" cellpadding=\"0\" width=\"672\" border=\"0\">\n                          <tbody><tr>\n                            <td width=\"37\" height=\"24\" style=\"font-size:40px;line-height:40px;height:40px;text-align:left\">\n                            </td>\n                            <td width=\"523\" height=\"24\" style=\"text-align:left\">\n                            <p  style=\"display:block;color:#ffffff;font-size:20px;font-family:Arial,Helvetica,sans-serif;max-width:557px;min-height:auto\">{{business_name}} </p>\n                            </td>\n                            <td width=\"44\" style=\"text-align:left\"></td>\n                            <td width=\"30\" style=\"text-align:left\"></td>\n                            <td width=\"38\" height=\"24\" style=\"font-size:40px;line-height:40px;height:40px;text-align:left\"></td>\n                          </tr>\n                        </tbody></table>\n                        </td>\n                      </tr>\n                      <tr><td width=\"672\" height=\"33\" style=\"font-size:33px;line-height:33px;height:33px;text-align:left\"></td></tr>\n                    </tbody></table>\n\n                </td>\n              </tr>\n            </tbody></table>\n     </td>\n    </tr>\n </tbody></table>\n\n <table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" bgcolor=\"#439cc8\"><tbody><tr><td height=\"5\" style=\"background:#439cc8;height:5px;font-size:5px;line-height:5px\"></td></tr></tbody></table>\n\n <table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" border=\"0\" bgcolor=\"#e9eff0\">\n  <tbody><tr>\n    <td align=\"center\">\n      <table cellspacing=\"0\" cellpadding=\"0\" width=\"671\" border=\"0\" bgcolor=\"#e9eff0\" style=\"background:#e9eff0\">\n        <tbody><tr>\n          <td width=\"38\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n          <td width=\"596\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n          <td width=\"37\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n        </tr>\n        <tr>\n          <td width=\"38\" height=\"40\" style=\"font-size:40px;line-height:40px;height:40px;text-align:left\"></td>\n          <td style=\"text-align:left\"><table cellspacing=\"0\" cellpadding=\"0\" width=\"596\" border=\"0\" bgcolor=\"#ffffff\">\n            <tbody><tr>\n              <td width=\"20\" height=\"26\" style=\"font-size:26px;line-height:26px;height:26px;text-align:left\"></td>\n              <td width=\"556\" height=\"26\" style=\"font-size:26px;line-height:26px;height:26px;text-align:left\"></td>\n              <td width=\"20\" height=\"26\" style=\"font-size:26px;line-height:26px;height:26px;text-align:left\"></td>\n            </tr>\n            <tr>\n              <td width=\"20\" height=\"26\" style=\"font-size:26px;line-height:26px;height:26px;text-align:left\"></td>\n              <td width=\"556\" style=\"text-align:left\"><table cellspacing=\"0\" cellpadding=\"0\" width=\"556\" border=\"0\" style=\"font-family:helvetica,arial,sans-seif;color:#666666;font-size:16px;line-height:22px\">\n                <tbody><tr>\n                  <td style=\"text-align:left\"></td>\n                </tr>\n                <tr>\n                  <td style=\"text-align:left\"><table cellspacing=\"0\" cellpadding=\"0\" width=\"556\" border=\"0\">\n                    <tbody><tr><td style=\"font-family:helvetica,arial,sans-serif;font-size:30px;line-height:40px;font-weight:normal;color:#253c44;text-align:left\"></td></tr>\n                    <tr><td width=\"556\" height=\"20\" style=\"font-size:20px;line-height:20px;height:20px;text-align:left\"></td></tr>\n                    <tr>\n                      <td style=\"text-align:left\">\n                 Hi {{name}},<br>\n                 <br>\n                Registration Successfully!   This message is an automated reply to your active registration request. Click this link to active your account:\n            <br>\n                <a target=\"_blank\" style=\"color:#ff6600;font-weight:bold;font-family:helvetica,arial,sans-seif;text-decoration:none\" href=\" {{registration_link}} \"> {{registration_link}} </a>.<br>\n            <br>\n            {{business_name}}<br>\n            <br>\n          </td>\n                    </tr>\n                    <tr>\n                      <td width=\"556\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\">&nbsp;</td>\n                    </tr>\n                  </tbody></table></td>\n                </tr>\n              </tbody></table></td>\n              <td width=\"20\" height=\"26\" style=\"font-size:26px;line-height:26px;height:26px;text-align:left\"></td>\n            </tr>\n            <tr>\n              <td width=\"20\" height=\"2\" bgcolor=\"#d9dfe1\" style=\"background-color:#d9dfe1;font-size:2px;line-height:2px;height:2px;text-align:left\"></td>\n              <td width=\"556\" height=\"2\" bgcolor=\"#d9dfe1\" style=\"background-color:#d9dfe1;font-size:2px;line-height:2px;height:2px;text-align:left\"></td>\n              <td width=\"20\" height=\"2\" bgcolor=\"#d9dfe1\" style=\"background-color:#d9dfe1;font-size:2px;line-height:2px;height:2px;text-align:left\"></td>\n            </tr>\n          </tbody></table></td>\n          <td width=\"37\" height=\"40\" style=\"font-size:40px;line-height:40px;height:40px;text-align:left\"></td>\n        </tr>\n        <tr>\n          <td width=\"38\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n          <td width=\"596\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n          <td width=\"37\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n        </tr>\n      </tbody></table>\n  </td></tr>\n</tbody>\n</table>\n<table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" border=\"0\" bgcolor=\"#273f47\"><tbody><tr><td align=\"center\">&nbsp;</td></tr></tbody></table>\n<table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" border=\"0\" bgcolor=\"#364a51\">\n  <tbody><tr>\n    <td align=\"center\">\n       <table cellspacing=\"0\" cellpadding=\"0\" width=\"672\" border=\"0\" bgcolor=\"#364a51\">\n              <tbody><tr>\n              <td width=\"38\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n          <td width=\"569\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n          <td width=\"38\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n              </tr>\n              <tr>\n                <td width=\"38\" height=\"40\" style=\"font-size:40px;line-height:40px;text-align:left\">\n                </td>\n                <td valign=\"top\" style=\"font-family:helvetica,arial,sans-seif;font-size:12px;line-height:16px;color:#949fa3;text-align:left\">Copyright &copy; {{business_name}}, All rights reserved.<br><br><br></td>\n                <td width=\"38\" height=\"40\" style=\"font-size:40px;line-height:40px;text-align:left\"></td>\n              </tr>\n              <tr>\n              <td width=\"38\" height=\"40\" style=\"font-size:40px;line-height:40px;text-align:left\"></td>\n              <td width=\"569\" height=\"40\" style=\"font-size:40px;line-height:40px;text-align:left\"></td>\n                <td width=\"38\" height=\"40\" style=\"font-size:40px;line-height:40px;text-align:left\"></td>\n              </tr>\n            </tbody></table>\n     </td>\n  </tr>\n</tbody></table><div class=\"yj6qo\"></div><div class=\"adL\">\n\n</div></div>\n', '1', '2018-01-27 10:04:05', '2018-01-27 10:04:05'),
(9, 'Client Password Reset', '{{business_name}} New Password', '<div style=\"margin:0;padding:0\">\n<table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" border=\"0\" bgcolor=\"#439cc8\">\n  <tbody><tr>\n    <td align=\"center\">\n            <table cellspacing=\"0\" cellpadding=\"0\" width=\"672\" border=\"0\">\n              <tbody><tr>\n                <td height=\"95\" bgcolor=\"#439cc8\" style=\"background:#439cc8;text-align:left\">\n                <table cellspacing=\"0\" cellpadding=\"0\" width=\"672\" border=\"0\">\n                      <tbody><tr>\n                        <td width=\"672\" height=\"40\" style=\"font-size:40px;line-height:40px;height:40px;text-align:left\"></td>\n                      </tr>\n                      <tr>\n                        <td style=\"text-align:left\">\n                        <table cellspacing=\"0\" cellpadding=\"0\" width=\"672\" border=\"0\">\n                          <tbody><tr>\n                            <td width=\"37\" height=\"24\" style=\"font-size:40px;line-height:40px;height:40px;text-align:left\">\n                            </td>\n                            <td width=\"523\" height=\"24\" style=\"text-align:left\">\n                            <p  style=\"display:block;color:#ffffff;font-size:20px;font-family:Arial,Helvetica,sans-serif;max-width:557px;min-height:auto\" >{{business_name}}</p>\n                            </td>\n                            <td width=\"44\" style=\"text-align:left\"></td>\n                            <td width=\"30\" style=\"text-align:left\"></td>\n                            <td width=\"38\" height=\"24\" style=\"font-size:40px;line-height:40px;height:40px;text-align:left\"></td>\n                          </tr>\n                        </tbody></table>\n                        </td>\n                      </tr>\n                      <tr><td width=\"672\" height=\"33\" style=\"font-size:33px;line-height:33px;height:33px;text-align:left\"></td></tr>\n                    </tbody></table>\n\n                </td>\n              </tr>\n            </tbody></table>\n     </td>\n    </tr>\n </tbody></table>\n\n <table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" bgcolor=\"#439cc8\"><tbody><tr><td height=\"5\" style=\"background:#439cc8;height:5px;font-size:5px;line-height:5px\"></td></tr></tbody></table>\n\n <table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" border=\"0\" bgcolor=\"#e9eff0\">\n  <tbody><tr>\n    <td align=\"center\">\n      <table cellspacing=\"0\" cellpadding=\"0\" width=\"671\" border=\"0\" bgcolor=\"#e9eff0\" style=\"background:#e9eff0\">\n        <tbody><tr>\n          <td width=\"38\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n          <td width=\"596\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n          <td width=\"37\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n        </tr>\n        <tr>\n          <td width=\"38\" height=\"40\" style=\"font-size:40px;line-height:40px;height:40px;text-align:left\"></td>\n          <td style=\"text-align:left\"><table cellspacing=\"0\" cellpadding=\"0\" width=\"596\" border=\"0\" bgcolor=\"#ffffff\">\n            <tbody><tr>\n              <td width=\"20\" height=\"26\" style=\"font-size:26px;line-height:26px;height:26px;text-align:left\"></td>\n              <td width=\"556\" height=\"26\" style=\"font-size:26px;line-height:26px;height:26px;text-align:left\"></td>\n              <td width=\"20\" height=\"26\" style=\"font-size:26px;line-height:26px;height:26px;text-align:left\"></td>\n            </tr>\n            <tr>\n              <td width=\"20\" height=\"26\" style=\"font-size:26px;line-height:26px;height:26px;text-align:left\"></td>\n              <td width=\"556\" style=\"text-align:left\"><table cellspacing=\"0\" cellpadding=\"0\" width=\"556\" border=\"0\" style=\"font-family:helvetica,arial,sans-seif;color:#666666;font-size:16px;line-height:22px\">\n                <tbody><tr>\n                  <td style=\"text-align:left\"></td>\n                </tr>\n                <tr>\n                  <td style=\"text-align:left\"><table cellspacing=\"0\" cellpadding=\"0\" width=\"556\" border=\"0\">\n                    <tbody><tr><td style=\"font-family:helvetica,arial,sans-serif;font-size:30px;line-height:40px;font-weight:normal;color:#253c44;text-align:left\"></td></tr>\n                    <tr><td width=\"556\" height=\"20\" style=\"font-size:20px;line-height:20px;height:20px;text-align:left\"></td></tr>\n                    <tr>\n                      <td style=\"text-align:left\">\n                 Hi {{name}},<br>\n                 <br>\n                Password Reset Successfully!   This message is an automated reply to your password reset request. Login to your account to set up your all details by using the details below:\n            <br>\n                <a target=\"_blank\" style=\"color:#ff6600;font-weight:bold;font-family:helvetica,arial,sans-seif;text-decoration:none\" href=\" {{sys_url}}\"> {{sys_url}}</a>.<br>\n                                    User Name: {{username}}<br>\n                                    Password: {{password}}\n            <br>\n            {{business_name}}<br>\n            <br>\n          </td>\n                    </tr>\n                    <tr>\n                      <td width=\"556\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\">&nbsp;</td>\n                    </tr>\n                  </tbody></table></td>\n                </tr>\n              </tbody></table></td>\n              <td width=\"20\" height=\"26\" style=\"font-size:26px;line-height:26px;height:26px;text-align:left\"></td>\n            </tr>\n            <tr>\n              <td width=\"20\" height=\"2\" bgcolor=\"#d9dfe1\" style=\"background-color:#d9dfe1;font-size:2px;line-height:2px;height:2px;text-align:left\"></td>\n              <td width=\"556\" height=\"2\" bgcolor=\"#d9dfe1\" style=\"background-color:#d9dfe1;font-size:2px;line-height:2px;height:2px;text-align:left\"></td>\n              <td width=\"20\" height=\"2\" bgcolor=\"#d9dfe1\" style=\"background-color:#d9dfe1;font-size:2px;line-height:2px;height:2px;text-align:left\"></td>\n            </tr>\n          </tbody></table></td>\n          <td width=\"37\" height=\"40\" style=\"font-size:40px;line-height:40px;height:40px;text-align:left\"></td>\n        </tr>\n        <tr>\n          <td width=\"38\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n          <td width=\"596\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n          <td width=\"37\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n        </tr>\n      </tbody></table>\n  </td></tr>\n</tbody>\n</table>\n<table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" border=\"0\" bgcolor=\"#273f47\"><tbody><tr><td align=\"center\">&nbsp;</td></tr></tbody></table>\n<table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" border=\"0\" bgcolor=\"#364a51\">\n  <tbody><tr>\n    <td align=\"center\">\n       <table cellspacing=\"0\" cellpadding=\"0\" width=\"672\" border=\"0\" bgcolor=\"#364a51\">\n              <tbody><tr>\n              <td width=\"38\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n          <td width=\"569\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n          <td width=\"38\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n              </tr>\n              <tr>\n                <td width=\"38\" height=\"40\" style=\"font-size:40px;line-height:40px;text-align:left\">\n                </td>\n                <td valign=\"top\" style=\"font-family:helvetica,arial,sans-seif;font-size:12px;line-height:16px;color:#949fa3;text-align:left\">Copyright &copy; {{business_name}}, All rights reserved.<br><br><br></td>\n                <td width=\"38\" height=\"40\" style=\"font-size:40px;line-height:40px;text-align:left\"></td>\n              </tr>\n              <tr>\n              <td width=\"38\" height=\"40\" style=\"font-size:40px;line-height:40px;text-align:left\"></td>\n              <td width=\"569\" height=\"40\" style=\"font-size:40px;line-height:40px;text-align:left\"></td>\n                <td width=\"38\" height=\"40\" style=\"font-size:40px;line-height:40px;text-align:left\"></td>\n              </tr>\n            </tbody></table>\n     </td>\n  </tr>\n</tbody></table><div class=\"yj6qo\"></div><div class=\"adL\">\n\n</div></div>\n', '1', '2018-01-27 10:04:06', '2018-01-27 10:04:06'),
(10, 'Ticket For Admin', 'New Ticket From {{business_name}} Client', '<div style=\"margin:0;padding:0\">\n<table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" border=\"0\" bgcolor=\"#439cc8\">\n  <tbody><tr>\n    <td align=\"center\">\n            <table cellspacing=\"0\" cellpadding=\"0\" width=\"672\" border=\"0\">\n              <tbody><tr>\n                <td height=\"95\" bgcolor=\"#439cc8\" style=\"background:#439cc8;text-align:left\">\n                <table cellspacing=\"0\" cellpadding=\"0\" width=\"672\" border=\"0\">\n                      <tbody><tr>\n                        <td width=\"672\" height=\"40\" style=\"font-size:40px;line-height:40px;height:40px;text-align:left\"></td>\n                      </tr>\n                      <tr>\n                        <td style=\"text-align:left\">\n                        <table cellspacing=\"0\" cellpadding=\"0\" width=\"672\" border=\"0\">\n                          <tbody><tr>\n                            <td width=\"37\" height=\"24\" style=\"font-size:40px;line-height:40px;height:40px;text-align:left\">\n                            </td>\n                            <td width=\"523\" height=\"24\" style=\"text-align:left\">\n                            <div width=\"125\" height=\"23\" style=\"display:block;color:#ffffff;font-size:20px;font-family:Arial,Helvetica,sans-serif;max-width:557px;min-height:auto\" >{{business_name}}</div>\n                            </td>\n                            <td width=\"44\" style=\"text-align:left\"></td>\n                            <td width=\"30\" style=\"text-align:left\"></td>\n                            <td width=\"38\" height=\"24\" style=\"font-size:40px;line-height:40px;height:40px;text-align:left\"></td>\n                          </tr>\n                        </tbody></table>\n                        </td>\n                      </tr>\n                      <tr><td width=\"672\" height=\"33\" style=\"font-size:33px;line-height:33px;height:33px;text-align:left\"></td></tr>\n                    </tbody></table>\n\n                </td>\n              </tr>\n            </tbody></table>\n     </td>\n    </tr>\n </tbody></table>\n\n <table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" bgcolor=\"#439cc8\"><tbody><tr><td height=\"5\" style=\"background:#439cc8;height:5px;font-size:5px;line-height:5px\"></td></tr></tbody></table>\n\n <table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" border=\"0\" bgcolor=\"#e9eff0\">\n  <tbody><tr>\n    <td align=\"center\">\n      <table cellspacing=\"0\" cellpadding=\"0\" width=\"671\" border=\"0\" bgcolor=\"#e9eff0\" style=\"background:#e9eff0\">\n        <tbody><tr>\n          <td width=\"38\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n          <td width=\"596\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n          <td width=\"37\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n        </tr>\n        <tr>\n          <td width=\"38\" height=\"40\" style=\"font-size:40px;line-height:40px;height:40px;text-align:left\"></td>\n          <td style=\"text-align:left\"><table cellspacing=\"0\" cellpadding=\"0\" width=\"596\" border=\"0\" bgcolor=\"#ffffff\">\n            <tbody><tr>\n              <td width=\"20\" height=\"26\" style=\"font-size:26px;line-height:26px;height:26px;text-align:left\"></td>\n              <td width=\"556\" height=\"26\" style=\"font-size:26px;line-height:26px;height:26px;text-align:left\"></td>\n              <td width=\"20\" height=\"26\" style=\"font-size:26px;line-height:26px;height:26px;text-align:left\"></td>\n            </tr>\n            <tr>\n              <td width=\"20\" height=\"26\" style=\"font-size:26px;line-height:26px;height:26px;text-align:left\"></td>\n              <td width=\"556\" style=\"text-align:left\"><table cellspacing=\"0\" cellpadding=\"0\" width=\"556\" border=\"0\" style=\"font-family:helvetica,arial,sans-seif;color:#666666;font-size:16px;line-height:22px\">\n                <tbody><tr>\n                  <td style=\"text-align:left\"></td>\n                </tr>\n                <tr>\n                  <td style=\"text-align:left\"><table cellspacing=\"0\" cellpadding=\"0\" width=\"556\" border=\"0\">\n                    <tbody><tr><td style=\"font-family:helvetica,arial,sans-serif;font-size:30px;line-height:40px;font-weight:normal;color:#253c44;text-align:left\"></td></tr>\n                    <tr><td width=\"556\" height=\"20\" style=\"font-size:20px;line-height:20px;height:20px;text-align:left\"></td></tr>\n                    <tr>\n                      <td style=\"text-align:left\">\n                 Hi {{name}},<br>{{department_name}},<br>\n                 <br>\n\n                Ticket ID: {{ticket_id}}<br>\n                Ticket Subject: {{ticket_subject}}<br>\n                Message: {{message}}<br>\n                Created By: {{create_by}} <br><br>\n                Waiting for your quick response.\n            <br><br>\n            Thank you.\n            <br>\n            Regards,<br>\n            {{name}}<br>\n{{business_name}} User.\n            <br>\n          </td>\n                    </tr>\n                    <tr>\n                      <td width=\"556\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\">&nbsp;</td>\n                    </tr>\n                  </tbody></table></td>\n                </tr>\n              </tbody></table></td>\n              <td width=\"20\" height=\"26\" style=\"font-size:26px;line-height:26px;height:26px;text-align:left\"></td>\n            </tr>\n            <tr>\n              <td width=\"20\" height=\"2\" bgcolor=\"#d9dfe1\" style=\"background-color:#d9dfe1;font-size:2px;line-height:2px;height:2px;text-align:left\"></td>\n              <td width=\"556\" height=\"2\" bgcolor=\"#d9dfe1\" style=\"background-color:#d9dfe1;font-size:2px;line-height:2px;height:2px;text-align:left\"></td>\n              <td width=\"20\" height=\"2\" bgcolor=\"#d9dfe1\" style=\"background-color:#d9dfe1;font-size:2px;line-height:2px;height:2px;text-align:left\"></td>\n            </tr>\n          </tbody></table></td>\n          <td width=\"37\" height=\"40\" style=\"font-size:40px;line-height:40px;height:40px;text-align:left\"></td>\n        </tr>\n        <tr>\n          <td width=\"38\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n          <td width=\"596\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n          <td width=\"37\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n        </tr>\n      </tbody></table>\n  </td></tr>\n</tbody>\n</table>\n<table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" border=\"0\" bgcolor=\"#273f47\"><tbody><tr><td align=\"center\">&nbsp;</td></tr></tbody></table>\n<table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" border=\"0\" bgcolor=\"#364a51\">\n  <tbody><tr>\n    <td align=\"center\">\n       <table cellspacing=\"0\" cellpadding=\"0\" width=\"672\" border=\"0\" bgcolor=\"#364a51\">\n              <tbody><tr>\n              <td width=\"38\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n          <td width=\"569\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n          <td width=\"38\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n              </tr>\n              <tr>\n                <td width=\"38\" height=\"40\" style=\"font-size:40px;line-height:40px;text-align:left\">\n                </td>\n                <td valign=\"top\" style=\"font-family:helvetica,arial,sans-seif;font-size:12px;line-height:16px;color:#949fa3;text-align:left\">Copyright &copy; {{business_name}}, All rights reserved.<br><br><br></td>\n                <td width=\"38\" height=\"40\" style=\"font-size:40px;line-height:40px;text-align:left\"></td>\n              </tr>\n              <tr>\n              <td width=\"38\" height=\"40\" style=\"font-size:40px;line-height:40px;text-align:left\"></td>\n              <td width=\"569\" height=\"40\" style=\"font-size:40px;line-height:40px;text-align:left\"></td>\n                <td width=\"38\" height=\"40\" style=\"font-size:40px;line-height:40px;text-align:left\"></td>\n              </tr>\n            </tbody></table>\n     </td>\n  </tr>\n</tbody></table><div class=\"yj6qo\"></div><div class=\"adL\">\n\n</div></div>\n', '1', '2018-01-27 10:04:06', '2018-01-27 10:04:06');
INSERT INTO `sys_email_templates` (`id`, `tplname`, `subject`, `message`, `status`, `created_at`, `updated_at`) VALUES
(11, 'Client Ticket Reply', 'Reply to Ticket [TID-{{ticket_id}}]', '<div style=\"margin:0;padding:0\">\n<table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" border=\"0\" bgcolor=\"#439cc8\">\n  <tbody><tr>\n    <td align=\"center\">\n            <table cellspacing=\"0\" cellpadding=\"0\" width=\"672\" border=\"0\">\n              <tbody><tr>\n                <td height=\"95\" bgcolor=\"#439cc8\" style=\"background:#439cc8;text-align:left\">\n                <table cellspacing=\"0\" cellpadding=\"0\" width=\"672\" border=\"0\">\n                      <tbody><tr>\n                        <td width=\"672\" height=\"40\" style=\"font-size:40px;line-height:40px;height:40px;text-align:left\"></td>\n                      </tr>\n                      <tr>\n                        <td style=\"text-align:left\">\n                        <table cellspacing=\"0\" cellpadding=\"0\" width=\"672\" border=\"0\">\n                          <tbody><tr>\n                            <td width=\"37\" height=\"24\" style=\"font-size:40px;line-height:40px;height:40px;text-align:left\">\n                            </td>\n                            <td width=\"523\" height=\"24\" style=\"text-align:left\">\n                            <div width=\"125\" height=\"23\" style=\"display:block;color:#ffffff;font-size:20px;font-family:Arial,Helvetica,sans-serif;max-width:557px;min-height:auto\">{{business_name}}</div>\n                            </td>\n                            <td width=\"44\" style=\"text-align:left\"></td>\n                            <td width=\"30\" style=\"text-align:left\"></td>\n                            <td width=\"38\" height=\"24\" style=\"font-size:40px;line-height:40px;height:40px;text-align:left\"></td>\n                          </tr>\n                        </tbody></table>\n                        </td>\n                      </tr>\n                      <tr><td width=\"672\" height=\"33\" style=\"font-size:33px;line-height:33px;height:33px;text-align:left\"></td></tr>\n                    </tbody></table>\n\n                </td>\n              </tr>\n            </tbody></table>\n     </td>\n    </tr>\n </tbody></table>\n\n <table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" bgcolor=\"#439cc8\"><tbody><tr><td height=\"5\" style=\"background:#439cc8;height:5px;font-size:5px;line-height:5px\"></td></tr></tbody></table>\n\n <table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" border=\"0\" bgcolor=\"#e9eff0\">\n  <tbody><tr>\n    <td align=\"center\">\n      <table cellspacing=\"0\" cellpadding=\"0\" width=\"671\" border=\"0\" bgcolor=\"#e9eff0\" style=\"background:#e9eff0\">\n        <tbody><tr>\n          <td width=\"38\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n          <td width=\"596\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n          <td width=\"37\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n        </tr>\n        <tr>\n          <td width=\"38\" height=\"40\" style=\"font-size:40px;line-height:40px;height:40px;text-align:left\"></td>\n          <td style=\"text-align:left\"><table cellspacing=\"0\" cellpadding=\"0\" width=\"596\" border=\"0\" bgcolor=\"#ffffff\">\n            <tbody><tr>\n              <td width=\"20\" height=\"26\" style=\"font-size:26px;line-height:26px;height:26px;text-align:left\"></td>\n              <td width=\"556\" height=\"26\" style=\"font-size:26px;line-height:26px;height:26px;text-align:left\"></td>\n              <td width=\"20\" height=\"26\" style=\"font-size:26px;line-height:26px;height:26px;text-align:left\"></td>\n            </tr>\n            <tr>\n              <td width=\"20\" height=\"26\" style=\"font-size:26px;line-height:26px;height:26px;text-align:left\"></td>\n              <td width=\"556\" style=\"text-align:left\"><table cellspacing=\"0\" cellpadding=\"0\" width=\"556\" border=\"0\" style=\"font-family:helvetica,arial,sans-seif;color:#666666;font-size:16px;line-height:22px\">\n                <tbody><tr>\n                  <td style=\"text-align:left\"></td>\n                </tr>\n                <tr>\n                  <td style=\"text-align:left\"><table cellspacing=\"0\" cellpadding=\"0\" width=\"556\" border=\"0\">\n                    <tbody><tr><td style=\"font-family:helvetica,arial,sans-serif;font-size:30px;line-height:40px;font-weight:normal;color:#253c44;text-align:left\"></td></tr>\n                    <tr><td width=\"556\" height=\"20\" style=\"font-size:20px;line-height:20px;height:20px;text-align:left\"></td></tr>\n                    <tr>\n                      <td style=\"text-align:left\">\n                 Hi {{name}},<br>{{department_name}},<br>\n                 <br>\n                 This is a Support Ticket Reply From Client.\n            <br>\n                Ticket ID: {{ticket_id}}<br>\n                Ticket Subject: {{ticket_subject}}<br>\n                Message: {{message}}<br>\n                Replyed By: {{reply_by}}  <br><br>\n                Waiting for your quick response.\n            <br><br>\n            Thank you.\n            <br>\n            Regards,<br>\n            {{name}}<br>\n{{business_name}} User.\n            <br>\n          </td>\n                    </tr>\n                    <tr>\n                      <td width=\"556\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\">&nbsp;</td>\n                    </tr>\n                  </tbody></table></td>\n                </tr>\n              </tbody></table></td>\n              <td width=\"20\" height=\"26\" style=\"font-size:26px;line-height:26px;height:26px;text-align:left\"></td>\n            </tr>\n            <tr>\n              <td width=\"20\" height=\"2\" bgcolor=\"#d9dfe1\" style=\"background-color:#d9dfe1;font-size:2px;line-height:2px;height:2px;text-align:left\"></td>\n              <td width=\"556\" height=\"2\" bgcolor=\"#d9dfe1\" style=\"background-color:#d9dfe1;font-size:2px;line-height:2px;height:2px;text-align:left\"></td>\n              <td width=\"20\" height=\"2\" bgcolor=\"#d9dfe1\" style=\"background-color:#d9dfe1;font-size:2px;line-height:2px;height:2px;text-align:left\"></td>\n            </tr>\n          </tbody></table></td>\n          <td width=\"37\" height=\"40\" style=\"font-size:40px;line-height:40px;height:40px;text-align:left\"></td>\n        </tr>\n        <tr>\n          <td width=\"38\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n          <td width=\"596\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n          <td width=\"37\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n        </tr>\n      </tbody></table>\n  </td></tr>\n</tbody>\n</table>\n<table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" border=\"0\" bgcolor=\"#273f47\"><tbody><tr><td align=\"center\">&nbsp;</td></tr></tbody></table>\n<table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" border=\"0\" bgcolor=\"#364a51\">\n  <tbody><tr>\n    <td align=\"center\">\n       <table cellspacing=\"0\" cellpadding=\"0\" width=\"672\" border=\"0\" bgcolor=\"#364a51\">\n              <tbody><tr>\n              <td width=\"38\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n          <td width=\"569\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n          <td width=\"38\" height=\"30\" style=\"font-size:30px;line-height:30px;height:30px;text-align:left\"></td>\n              </tr>\n              <tr>\n                <td width=\"38\" height=\"40\" style=\"font-size:40px;line-height:40px;text-align:left\">\n                </td>\n                <td valign=\"top\" style=\"font-family:helvetica,arial,sans-seif;font-size:12px;line-height:16px;color:#949fa3;text-align:left\">Copyright &copy; {{business_name}}, All rights reserved.<br><br><br></td>\n                <td width=\"38\" height=\"40\" style=\"font-size:40px;line-height:40px;text-align:left\"></td>\n              </tr>\n              <tr>\n              <td width=\"38\" height=\"40\" style=\"font-size:40px;line-height:40px;text-align:left\"></td>\n              <td width=\"569\" height=\"40\" style=\"font-size:40px;line-height:40px;text-align:left\"></td>\n                <td width=\"38\" height=\"40\" style=\"font-size:40px;line-height:40px;text-align:left\"></td>\n              </tr>\n            </tbody></table>\n     </td>\n  </tr>\n</tbody></table><div class=\"yj6qo\"></div><div class=\"adL\">\n\n</div></div>\n', '1', '2018-01-27 10:04:06', '2018-01-27 10:04:06');

-- --------------------------------------------------------

--
-- Table structure for table `sys_import_phone_number`
--

CREATE TABLE `sys_import_phone_number` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `group_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sys_int_country_codes`
--

CREATE TABLE `sys_int_country_codes` (
  `id` int(10) UNSIGNED NOT NULL,
  `country_name` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `iso_code` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country_code` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tariff` decimal(5,2) NOT NULL DEFAULT '3.00',
  `active` enum('1','0') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `sys_int_country_codes`
--

INSERT INTO `sys_int_country_codes` (`id`, `country_name`, `iso_code`, `country_code`, `tariff`, `active`, `created_at`, `updated_at`) VALUES
(1, 'Afghanistan', 'AF / AFG', '93', '1.00', '1', '2018-01-27 10:04:07', '2018-01-27 10:04:07'),
(2, 'Albania', 'AL / ALB', '355', '1.00', '1', '2018-01-27 10:04:07', '2018-01-27 10:04:07'),
(3, 'Algeria', 'DZ / DZA', '213', '1.00', '1', '2018-01-27 10:04:07', '2018-01-27 10:04:07'),
(4, 'Andorra', 'AD / AND', '376', '1.00', '1', '2018-01-27 10:04:07', '2018-01-27 10:04:07'),
(5, 'Angola', 'AO / AGO', '244', '1.00', '0', '2018-01-27 10:04:07', '2018-01-27 10:04:07'),
(6, 'Antarctica', 'AQ / ATA', '672', '1.00', '1', '2018-01-27 10:04:07', '2018-01-27 10:04:07'),
(7, 'Argentina', 'AR / ARG', '54', '1.00', '1', '2018-01-27 10:04:07', '2018-01-27 10:04:07'),
(8, 'Armenia', 'AM / ARM', '374', '1.00', '1', '2018-01-27 10:04:07', '2018-01-27 10:04:07'),
(9, 'Aruba', 'AW / ABW', '297', '1.00', '0', '2018-01-27 10:04:07', '2018-01-27 10:04:07'),
(10, 'Australia', 'AU / AUS', '61', '1.00', '1', '2018-01-27 10:04:07', '2018-01-27 10:04:07'),
(11, 'Austria', 'AT / AUT', '43', '1.00', '1', '2018-01-27 10:04:07', '2018-01-27 10:04:07'),
(12, 'Azerbaijan', 'AZ / AZE', '994', '1.00', '1', '2018-01-27 10:04:07', '2018-01-27 10:04:07'),
(13, 'Bahrain', 'BH / BHR', '973', '1.00', '1', '2018-01-27 10:04:07', '2018-01-27 10:04:07'),
(14, 'Bangladesh', 'BD / BGD', '880', '1.00', '1', '2018-01-27 10:04:07', '2018-01-27 10:04:07'),
(15, 'Belarus', 'BY / BLR', '375', '1.00', '1', '2018-01-27 10:04:08', '2018-01-27 10:04:08'),
(16, 'Belgium', 'BE / BEL', '32', '1.00', '1', '2018-01-27 10:04:08', '2018-01-27 10:04:08'),
(17, 'Belize', 'BZ / BLZ', '501', '1.00', '1', '2018-01-27 10:04:08', '2018-01-27 10:04:08'),
(18, 'Benin', 'BJ / BEN', '229', '1.00', '1', '2018-01-27 10:04:08', '2018-01-27 10:04:08'),
(19, 'Bhutan', 'BT / BTN', '975', '1.00', '1', '2018-01-27 10:04:08', '2018-01-27 10:04:08'),
(20, 'Bolivia', 'BO / BOL', '591', '1.00', '1', '2018-01-27 10:04:08', '2018-01-27 10:04:08'),
(21, 'Bosnia and Herzegovina', 'BA / BIH', '387', '1.00', '1', '2018-01-27 10:04:08', '2018-01-27 10:04:08'),
(22, 'Botswana', 'BW / BWA', '267', '1.00', '1', '2018-01-27 10:04:08', '2018-01-27 10:04:08'),
(23, 'Brazil', 'BR / BRA', '55', '1.00', '1', '2018-01-27 10:04:08', '2018-01-27 10:04:08'),
(24, 'Brunei', 'BN / BRN', '673', '1.00', '1', '2018-01-27 10:04:08', '2018-01-27 10:04:08'),
(25, 'Bulgaria', 'BG / BGR', '359', '1.00', '1', '2018-01-27 10:04:08', '2018-01-27 10:04:08'),
(26, 'Burkina Faso', 'BF / BFA', '226', '1.00', '1', '2018-01-27 10:04:08', '2018-01-27 10:04:08'),
(27, 'Burma (Myanmar)', 'MM / MMR', '95', '1.00', '1', '2018-01-27 10:04:08', '2018-01-27 10:04:08'),
(28, 'Burundi', 'BI / BDI', '257', '1.00', '1', '2018-01-27 10:04:08', '2018-01-27 10:04:08'),
(29, 'Cambodia', 'KH / KHM', '855', '1.00', '1', '2018-01-27 10:04:08', '2018-01-27 10:04:08'),
(30, 'Cameroon', 'CM / CMR', '237', '1.00', '1', '2018-01-27 10:04:08', '2018-01-27 10:04:08'),
(31, 'Canada', 'CA / CAN', '1', '1.00', '1', '2018-01-27 10:04:08', '2018-01-27 10:04:08'),
(32, 'Cape Verde', 'CV / CPV', '238', '1.00', '1', '2018-01-27 10:04:08', '2018-01-27 10:04:08'),
(33, 'Central African Republic', 'CF / CAF', '236', '1.00', '1', '2018-01-27 10:04:08', '2018-01-27 10:04:08'),
(34, 'Chad', 'TD / TCD', '235', '1.00', '1', '2018-01-27 10:04:08', '2018-01-27 10:04:08'),
(35, 'Chile', 'CL / CHL', '56', '1.00', '1', '2018-01-27 10:04:08', '2018-01-27 10:04:08'),
(36, 'China', 'CN / CHN', '86', '1.00', '1', '2018-01-27 10:04:09', '2018-01-27 10:04:09'),
(37, 'Christmas Island', 'CX / CXR', '61', '1.00', '1', '2018-01-27 10:04:09', '2018-01-27 10:04:09'),
(38, 'Cocos (Keeling) Islands', 'CC / CCK', '61', '1.00', '1', '2018-01-27 10:04:09', '2018-01-27 10:04:09'),
(39, 'Colombia', 'CO / COL', '57', '1.00', '1', '2018-01-27 10:04:09', '2018-01-27 10:04:09'),
(40, 'Comoros', 'KM / COM', '269', '1.00', '1', '2018-01-27 10:04:09', '2018-01-27 10:04:09'),
(41, 'Congo', 'CD / COD', '243', '1.00', '1', '2018-01-27 10:04:09', '2018-01-27 10:04:09'),
(42, 'Cook Islands', 'CK / COK', '682', '1.00', '1', '2018-01-27 10:04:09', '2018-01-27 10:04:09'),
(43, 'Costa Rica', 'CR / CRC', '506', '1.00', '1', '2018-01-27 10:04:09', '2018-01-27 10:04:09'),
(44, 'Croatia', 'HR / HRV', '385', '1.00', '1', '2018-01-27 10:04:09', '2018-01-27 10:04:09'),
(45, 'Cuba', 'CU / CUB', '53', '1.00', '1', '2018-01-27 10:04:09', '2018-01-27 10:04:09'),
(46, 'Cyprus', 'CY / CYP', '357', '1.00', '1', '2018-01-27 10:04:09', '2018-01-27 10:04:09'),
(47, 'Czech Republic', 'CZ / CZE', '420', '1.00', '1', '2018-01-27 10:04:09', '2018-01-27 10:04:09'),
(48, 'Denmark', 'DK / DNK', '45', '1.00', '1', '2018-01-27 10:04:09', '2018-01-27 10:04:09'),
(49, 'Djibouti', 'DJ / DJI', '253', '1.00', '1', '2018-01-27 10:04:09', '2018-01-27 10:04:09'),
(50, 'Ecuador', 'EC / ECU', '593', '1.00', '1', '2018-01-27 10:04:09', '2018-01-27 10:04:09'),
(51, 'Egypt', 'EG / EGY', '20', '1.00', '1', '2018-01-27 10:04:09', '2018-01-27 10:04:09'),
(52, 'El Salvador', 'SV / SLV', '503', '1.00', '1', '2018-01-27 10:04:09', '2018-01-27 10:04:09'),
(53, 'Equatorial Guinea', 'GQ / GNQ', '240', '1.00', '1', '2018-01-27 10:04:09', '2018-01-27 10:04:09'),
(54, 'Eritrea', 'ER / ERI', '291', '1.00', '1', '2018-01-27 10:04:09', '2018-01-27 10:04:09'),
(55, 'Estonia', 'EE / EST', '372', '1.00', '1', '2018-01-27 10:04:09', '2018-01-27 10:04:09'),
(56, 'Ethiopia', 'ET / ETH', '251', '1.00', '1', '2018-01-27 10:04:09', '2018-01-27 10:04:09'),
(57, 'Falkland Islands', 'FK / FLK', '500', '1.00', '1', '2018-01-27 10:04:09', '2018-01-27 10:04:09'),
(58, 'Faroe Islands', 'FO / FRO', '298', '1.00', '1', '2018-01-27 10:04:10', '2018-01-27 10:04:10'),
(59, 'Fiji', 'FJ / FJI', '679', '1.00', '1', '2018-01-27 10:04:10', '2018-01-27 10:04:10'),
(60, 'Finland', 'FI / FIN', '358', '1.00', '1', '2018-01-27 10:04:10', '2018-01-27 10:04:10'),
(61, 'France', 'FR / FRA', '33', '1.00', '1', '2018-01-27 10:04:10', '2018-01-27 10:04:10'),
(62, 'French Polynesia', 'PF / PYF', '689', '1.00', '1', '2018-01-27 10:04:10', '2018-01-27 10:04:10'),
(63, 'Gabon', 'GA / GAB', '241', '1.00', '1', '2018-01-27 10:04:10', '2018-01-27 10:04:10'),
(64, 'Gambia', 'GM / GMB', '220', '1.00', '1', '2018-01-27 10:04:10', '2018-01-27 10:04:10'),
(65, 'Gaza Strip', '/', '970', '1.00', '1', '2018-01-27 10:04:10', '2018-01-27 10:04:10'),
(66, 'Georgia', 'GE / GEO', '995', '1.00', '1', '2018-01-27 10:04:10', '2018-01-27 10:04:10'),
(67, 'Germany', 'DE / DEU', '49', '1.00', '1', '2018-01-27 10:04:10', '2018-01-27 10:04:10'),
(68, 'Ghana', 'GH / GHA', '233', '1.00', '1', '2018-01-27 10:04:10', '2018-01-27 10:04:10'),
(69, 'Gibraltar', 'GI / GIB', '350', '1.00', '1', '2018-01-27 10:04:10', '2018-01-27 10:04:10'),
(70, 'Greece', 'GR / GRC', '30', '1.00', '1', '2018-01-27 10:04:10', '2018-01-27 10:04:10'),
(71, 'Greenland', 'GL / GRL', '299', '1.00', '1', '2018-01-27 10:04:10', '2018-01-27 10:04:10'),
(72, 'Guatemala', 'GT / GTM', '502', '1.00', '1', '2018-01-27 10:04:10', '2018-01-27 10:04:10'),
(73, 'Guinea', 'GN / GIN', '224', '1.00', '1', '2018-01-27 10:04:10', '2018-01-27 10:04:10'),
(74, 'Guinea-Bissau', 'GW / GNB', '245', '1.00', '1', '2018-01-27 10:04:10', '2018-01-27 10:04:10'),
(75, 'Guyana', 'GY / GUY', '592', '1.00', '1', '2018-01-27 10:04:10', '2018-01-27 10:04:10'),
(76, 'Haiti', 'HT / HTI', '509', '1.00', '1', '2018-01-27 10:04:10', '2018-01-27 10:04:10'),
(77, 'Holy See (Vatican City)', 'VA / VAT', '39', '1.00', '1', '2018-01-27 10:04:11', '2018-01-27 10:04:11'),
(78, 'Honduras', 'HN / HND', '504', '1.00', '1', '2018-01-27 10:04:11', '2018-01-27 10:04:11'),
(79, 'Hong Kong', 'HK / HKG', '852', '1.00', '1', '2018-01-27 10:04:11', '2018-01-27 10:04:11'),
(80, 'Hungary', 'HU / HUN', '36', '1.00', '1', '2018-01-27 10:04:11', '2018-01-27 10:04:11'),
(81, 'Iceland', 'IS / IS', '354', '1.00', '1', '2018-01-27 10:04:11', '2018-01-27 10:04:11'),
(82, 'India', 'IN / IND', '91', '1.00', '1', '2018-01-27 10:04:11', '2018-01-27 10:04:11'),
(83, 'Indonesia', 'ID / IDN', '62', '1.00', '1', '2018-01-27 10:04:11', '2018-01-27 10:04:11'),
(84, 'Iran', 'IR / IRN', '98', '1.00', '1', '2018-01-27 10:04:11', '2018-01-27 10:04:11'),
(85, 'Iraq', 'IQ / IRQ', '964', '1.00', '1', '2018-01-27 10:04:11', '2018-01-27 10:04:11'),
(86, 'Ireland', 'IE / IRL', '353', '1.00', '1', '2018-01-27 10:04:11', '2018-01-27 10:04:11'),
(87, 'Isle of Man', 'IM / IMN', '44', '1.00', '1', '2018-01-27 10:04:11', '2018-01-27 10:04:11'),
(88, 'Israel', 'IL / ISR', '972', '1.00', '1', '2018-01-27 10:04:11', '2018-01-27 10:04:11'),
(89, 'Italy', 'IT / ITA', '39', '1.00', '1', '2018-01-27 10:04:11', '2018-01-27 10:04:11'),
(90, 'Ivory Coast', 'CI / CIV', '225', '1.00', '1', '2018-01-27 10:04:11', '2018-01-27 10:04:11'),
(91, 'Japan', 'JP / JPN', '81', '1.00', '1', '2018-01-27 10:04:11', '2018-01-27 10:04:11'),
(92, 'Jordan', 'JO / JOR', '962', '1.00', '1', '2018-01-27 10:04:11', '2018-01-27 10:04:11'),
(93, 'Kazakhstan', 'KZ / KAZ', '7', '1.00', '1', '2018-01-27 10:04:11', '2018-01-27 10:04:11'),
(94, 'Kenya', 'KE / KEN', '254', '1.00', '1', '2018-01-27 10:04:11', '2018-01-27 10:04:11'),
(95, 'Kiribati', 'KI / KIR', '686', '1.00', '1', '2018-01-27 10:04:11', '2018-01-27 10:04:11'),
(96, 'Kosovo', '/', '381', '1.00', '1', '2018-01-27 10:04:11', '2018-01-27 10:04:11'),
(97, 'Kuwait', 'KW / KWT', '965', '1.00', '1', '2018-01-27 10:04:12', '2018-01-27 10:04:12'),
(98, 'Kyrgyzstan', 'KG / KGZ', '996', '1.00', '1', '2018-01-27 10:04:12', '2018-01-27 10:04:12'),
(99, 'Laos', 'LA / LAO', '856', '1.00', '1', '2018-01-27 10:04:12', '2018-01-27 10:04:12'),
(100, 'Latvia', 'LV / LVA', '371', '1.00', '1', '2018-01-27 10:04:12', '2018-01-27 10:04:12'),
(101, 'Lebanon', 'LB / LBN', '961', '1.00', '1', '2018-01-27 10:04:12', '2018-01-27 10:04:12'),
(102, 'Lesotho', 'LS / LSO', '266', '1.00', '1', '2018-01-27 10:04:12', '2018-01-27 10:04:12'),
(103, 'Liberia', 'LR / LBR', '231', '1.00', '1', '2018-01-27 10:04:12', '2018-01-27 10:04:12'),
(104, 'Libya', 'LY / LBY', '218', '1.00', '1', '2018-01-27 10:04:12', '2018-01-27 10:04:12'),
(105, 'Liechtenstein', 'LI / LIE', '423', '1.00', '1', '2018-01-27 10:04:12', '2018-01-27 10:04:12'),
(106, 'Lithuania', 'LT / LTU', '370', '1.00', '1', '2018-01-27 10:04:12', '2018-01-27 10:04:12'),
(107, 'Luxembourg', 'LU / LUX', '352', '1.00', '1', '2018-01-27 10:04:12', '2018-01-27 10:04:12'),
(108, 'Macau', 'MO / MAC', '853', '1.00', '1', '2018-01-27 10:04:12', '2018-01-27 10:04:12'),
(109, 'Macedonia', 'MK / MKD', '389', '1.00', '1', '2018-01-27 10:04:12', '2018-01-27 10:04:12'),
(110, 'Madagascar', 'MG / MDG', '261', '1.00', '1', '2018-01-27 10:04:12', '2018-01-27 10:04:12'),
(111, 'Malawi', 'MW / MWI', '265', '1.00', '1', '2018-01-27 10:04:12', '2018-01-27 10:04:12'),
(112, 'Malaysia', 'MY / MYS', '60', '1.00', '1', '2018-01-27 10:04:12', '2018-01-27 10:04:12'),
(113, 'Maldives', 'MV / MDV', '960', '1.00', '1', '2018-01-27 10:04:12', '2018-01-27 10:04:12'),
(114, 'Mali', 'ML / MLI', '223', '1.00', '1', '2018-01-27 10:04:12', '2018-01-27 10:04:12'),
(115, 'Malta', 'MT / MLT', '356', '1.00', '1', '2018-01-27 10:04:12', '2018-01-27 10:04:12'),
(116, 'Marshall Islands', 'MH / MHL', '692', '1.00', '1', '2018-01-27 10:04:12', '2018-01-27 10:04:12'),
(117, 'Mauritania', 'MR / MRT', '222', '1.00', '1', '2018-01-27 10:04:12', '2018-01-27 10:04:12'),
(118, 'Mauritius', 'MU / MUS', '230', '1.00', '1', '2018-01-27 10:04:13', '2018-01-27 10:04:13'),
(119, 'Mayotte', 'YT / MYT', '262', '1.00', '1', '2018-01-27 10:04:13', '2018-01-27 10:04:13'),
(120, 'Mexico', 'MX / MEX', '52', '1.00', '1', '2018-01-27 10:04:13', '2018-01-27 10:04:13'),
(121, 'Micronesia', 'FM / FSM', '691', '1.00', '1', '2018-01-27 10:04:13', '2018-01-27 10:04:13'),
(122, 'Moldova', 'MD / MDA', '373', '1.00', '1', '2018-01-27 10:04:13', '2018-01-27 10:04:13'),
(123, 'Monaco', 'MC / MCO', '377', '1.00', '1', '2018-01-27 10:04:13', '2018-01-27 10:04:13'),
(124, 'Mongolia', 'MN / MNG', '976', '1.00', '1', '2018-01-27 10:04:13', '2018-01-27 10:04:13'),
(125, 'Montenegro', 'ME / MNE', '382', '1.00', '1', '2018-01-27 10:04:13', '2018-01-27 10:04:13'),
(126, 'Morocco', 'MA / MAR', '212', '1.00', '1', '2018-01-27 10:04:13', '2018-01-27 10:04:13'),
(127, 'Mozambique', 'MZ / MOZ', '258', '1.00', '1', '2018-01-27 10:04:13', '2018-01-27 10:04:13'),
(128, 'Namibia', 'NA / NAM', '264', '1.00', '1', '2018-01-27 10:04:13', '2018-01-27 10:04:13'),
(129, 'Nauru', 'NR / NRU', '674', '1.00', '1', '2018-01-27 10:04:13', '2018-01-27 10:04:13'),
(130, 'Nepal', 'NP / NPL', '977', '1.00', '1', '2018-01-27 10:04:13', '2018-01-27 10:04:13'),
(131, 'Netherlands', 'NL / NLD', '31', '1.00', '1', '2018-01-27 10:04:13', '2018-01-27 10:04:13'),
(132, 'Netherlands Antilles', 'AN / ANT', '599', '1.00', '1', '2018-01-27 10:04:13', '2018-01-27 10:04:13'),
(133, 'New Caledonia', 'NC / NCL', '687', '1.00', '1', '2018-01-27 10:04:13', '2018-01-27 10:04:13'),
(134, 'New Zealand', 'NZ / NZL', '64', '1.00', '1', '2018-01-27 10:04:13', '2018-01-27 10:04:13'),
(135, 'Nicaragua', 'NI / NIC', '505', '1.00', '1', '2018-01-27 10:04:13', '2018-01-27 10:04:13'),
(136, 'Niger', 'NE / NER', '227', '1.00', '1', '2018-01-27 10:04:14', '2018-01-27 10:04:14'),
(137, 'Nigeria', 'NG / NGA', '234', '1.00', '1', '2018-01-27 10:04:14', '2018-01-27 10:04:14'),
(138, 'Niue', 'NU / NIU', '683', '1.00', '1', '2018-01-27 10:04:14', '2018-01-27 10:04:14'),
(139, 'Norfolk Island', '/ NFK', '672', '1.00', '1', '2018-01-27 10:04:14', '2018-01-27 10:04:14'),
(140, 'North Korea', 'KP / PRK', '850', '1.00', '1', '2018-01-27 10:04:14', '2018-01-27 10:04:14'),
(141, 'Norway', 'NO / NOR', '47', '1.00', '1', '2018-01-27 10:04:14', '2018-01-27 10:04:14'),
(142, 'Oman', 'OM / OMN', '968', '1.00', '1', '2018-01-27 10:04:14', '2018-01-27 10:04:14'),
(143, 'Pakistan', 'PK / PAK', '92', '1.00', '1', '2018-01-27 10:04:14', '2018-01-27 10:04:14'),
(144, 'Palau', 'PW / PLW', '680', '1.00', '1', '2018-01-27 10:04:14', '2018-01-27 10:04:14'),
(145, 'Panama', 'PA / PAN', '507', '1.00', '1', '2018-01-27 10:04:14', '2018-01-27 10:04:14'),
(146, 'Papua New Guinea', 'PG / PNG', '675', '1.00', '1', '2018-01-27 10:04:14', '2018-01-27 10:04:14'),
(147, 'Paraguay', 'PY / PRY', '595', '1.00', '1', '2018-01-27 10:04:14', '2018-01-27 10:04:14'),
(148, 'Peru', 'PE / PER', '51', '1.00', '1', '2018-01-27 10:04:14', '2018-01-27 10:04:14'),
(149, 'Philippines', 'PH / PHL', '63', '1.00', '1', '2018-01-27 10:04:14', '2018-01-27 10:04:14'),
(150, 'Pitcairn Islands', 'PN / PCN', '870', '1.00', '1', '2018-01-27 10:04:14', '2018-01-27 10:04:14'),
(151, 'Poland', 'PL / POL', '48', '1.00', '1', '2018-01-27 10:04:14', '2018-01-27 10:04:14'),
(152, 'Portugal', 'PT / PRT', '351', '1.00', '1', '2018-01-27 10:04:14', '2018-01-27 10:04:14'),
(153, 'Puerto Rico', 'PR / PRI', '1', '1.00', '1', '2018-01-27 10:04:14', '2018-01-27 10:04:14'),
(154, 'Qatar', 'QA / QAT', '974', '1.00', '1', '2018-01-27 10:04:14', '2018-01-27 10:04:14'),
(155, 'Republic of the Congo', 'CG / COG', '242', '1.00', '1', '2018-01-27 10:04:15', '2018-01-27 10:04:15'),
(156, 'Romania', 'RO / ROU', '40', '1.00', '1', '2018-01-27 10:04:15', '2018-01-27 10:04:15'),
(157, 'Russia', 'RU / RUS', '7', '1.00', '1', '2018-01-27 10:04:15', '2018-01-27 10:04:15'),
(158, 'Rwanda', 'RW / RWA', '250', '1.00', '1', '2018-01-27 10:04:15', '2018-01-27 10:04:15'),
(159, 'Saint Barthelemy', 'BL / BLM', '590', '1.00', '1', '2018-01-27 10:04:15', '2018-01-27 10:04:15'),
(160, 'Saint Helena', 'SH / SHN', '290', '1.00', '1', '2018-01-27 10:04:15', '2018-01-27 10:04:15'),
(161, 'Saint Pierre and Miquelon', 'PM / SPM', '508', '1.00', '1', '2018-01-27 10:04:15', '2018-01-27 10:04:15'),
(162, 'Samoa', 'WS / WSM', '685', '1.00', '1', '2018-01-27 10:04:15', '2018-01-27 10:04:15'),
(163, 'San Marino', 'SM / SMR', '378', '1.00', '1', '2018-01-27 10:04:15', '2018-01-27 10:04:15'),
(164, 'Sao Tome and Principe', 'ST / STP', '239', '1.00', '1', '2018-01-27 10:04:15', '2018-01-27 10:04:15'),
(165, 'Saudi Arabia', 'SA / SAU', '966', '1.00', '1', '2018-01-27 10:04:15', '2018-01-27 10:04:15'),
(166, 'Senegal', 'SN / SEN', '221', '1.00', '1', '2018-01-27 10:04:15', '2018-01-27 10:04:15'),
(167, 'Serbia', 'RS / SRB', '381', '1.00', '1', '2018-01-27 10:04:15', '2018-01-27 10:04:15'),
(168, 'Seychelles', 'SC / SYC', '248', '1.00', '1', '2018-01-27 10:04:15', '2018-01-27 10:04:15'),
(169, 'Sierra Leone', 'SL / SLE', '232', '1.00', '1', '2018-01-27 10:04:15', '2018-01-27 10:04:15'),
(170, 'Singapore', 'SG / SGP', '65', '1.00', '1', '2018-01-27 10:04:15', '2018-01-27 10:04:15'),
(171, 'Slovakia', 'SK / SVK', '421', '1.00', '1', '2018-01-27 10:04:15', '2018-01-27 10:04:15'),
(172, 'Slovenia', 'SI / SVN', '386', '1.00', '1', '2018-01-27 10:04:15', '2018-01-27 10:04:15'),
(173, 'Solomon Islands', 'SB / SLB', '677', '1.00', '1', '2018-01-27 10:04:16', '2018-01-27 10:04:16'),
(174, 'Somalia', 'SO / SOM', '252', '1.00', '1', '2018-01-27 10:04:16', '2018-01-27 10:04:16'),
(175, 'South Africa', 'ZA / ZAF', '27', '1.00', '1', '2018-01-27 10:04:16', '2018-01-27 10:04:16'),
(176, 'South Korea', 'KR / KOR', '82', '1.00', '1', '2018-01-27 10:04:16', '2018-01-27 10:04:16'),
(177, 'Spain', 'ES / ESP', '34', '1.00', '1', '2018-01-27 10:04:16', '2018-01-27 10:04:16'),
(178, 'Sri Lanka', 'LK / LKA', '94', '1.00', '1', '2018-01-27 10:04:16', '2018-01-27 10:04:16'),
(179, 'Sudan', 'SD / SDN', '249', '1.00', '1', '2018-01-27 10:04:16', '2018-01-27 10:04:16'),
(180, 'Suriname', 'SR / SUR', '597', '1.00', '1', '2018-01-27 10:04:16', '2018-01-27 10:04:16'),
(181, 'Swaziland', 'SZ / SWZ', '268', '1.00', '1', '2018-01-27 10:04:16', '2018-01-27 10:04:16'),
(182, 'Sweden', 'SE / SWE', '46', '1.00', '1', '2018-01-27 10:04:16', '2018-01-27 10:04:16'),
(183, 'Switzerland', 'CH / CHE', '41', '1.00', '1', '2018-01-27 10:04:16', '2018-01-27 10:04:16'),
(184, 'Syria', 'SY / SYR', '963', '1.00', '1', '2018-01-27 10:04:16', '2018-01-27 10:04:16'),
(185, 'Taiwan', 'TW / TWN', '886', '1.00', '1', '2018-01-27 10:04:16', '2018-01-27 10:04:16'),
(186, 'Tajikistan', 'TJ / TJK', '992', '1.00', '1', '2018-01-27 10:04:16', '2018-01-27 10:04:16'),
(187, 'Tanzania', 'TZ / TZA', '255', '1.00', '1', '2018-01-27 10:04:16', '2018-01-27 10:04:16'),
(188, 'Thailand', 'TH / THA', '66', '1.00', '1', '2018-01-27 10:04:16', '2018-01-27 10:04:16'),
(189, 'Timor-Leste', 'TL / TLS', '670', '1.00', '1', '2018-01-27 10:04:16', '2018-01-27 10:04:16'),
(190, 'Togo', 'TG / TGO', '228', '1.00', '1', '2018-01-27 10:04:16', '2018-01-27 10:04:16'),
(191, 'Tokelau', 'TK / TKL', '690', '1.00', '1', '2018-01-27 10:04:16', '2018-01-27 10:04:16'),
(192, 'Tonga', 'TO / TON', '676', '1.00', '1', '2018-01-27 10:04:16', '2018-01-27 10:04:16'),
(193, 'Tunisia', 'TN / TUN', '216', '1.00', '1', '2018-01-27 10:04:16', '2018-01-27 10:04:16'),
(194, 'Turkey', 'TR / TUR', '90', '1.00', '1', '2018-01-27 10:04:17', '2018-01-27 10:04:17'),
(195, 'Turkmenistan', 'TM / TKM', '993', '1.00', '1', '2018-01-27 10:04:17', '2018-01-27 10:04:17'),
(196, 'Tuvalu', 'TV / TUV', '688', '1.00', '1', '2018-01-27 10:04:17', '2018-01-27 10:04:17'),
(197, 'Uganda', 'UG / UGA', '256', '1.00', '1', '2018-01-27 10:04:17', '2018-01-27 10:04:17'),
(198, 'Ukraine', 'UA / UKR', '380', '1.00', '1', '2018-01-27 10:04:17', '2018-01-27 10:04:17'),
(199, 'United Arab Emirates', 'AE / ARE', '971', '1.00', '1', '2018-01-27 10:04:17', '2018-01-27 10:04:17'),
(200, 'United Kingdom', 'GB / GBR', '44', '1.00', '1', '2018-01-27 10:04:17', '2018-01-27 10:04:17'),
(201, 'United States', 'US / USA', '1', '1.00', '1', '2018-01-27 10:04:17', '2018-01-27 10:04:17'),
(202, 'Uruguay', 'UY / URY', '598', '1.00', '1', '2018-01-27 10:04:17', '2018-01-27 10:04:17'),
(203, 'Uzbekistan', 'UZ / UZB', '998', '1.00', '1', '2018-01-27 10:04:17', '2018-01-27 10:04:17'),
(204, 'Vanuatu', 'VU / VUT', '678', '1.00', '1', '2018-01-27 10:04:17', '2018-01-27 10:04:17'),
(205, 'Venezuela', 'VE / VEN', '58', '1.00', '1', '2018-01-27 10:04:17', '2018-01-27 10:04:17'),
(206, 'Vietnam', 'VN / VNM', '84', '1.00', '1', '2018-01-27 10:04:17', '2018-01-27 10:04:17'),
(207, 'Wallis and Futuna', 'WF / WLF', '681', '1.00', '1', '2018-01-27 10:04:18', '2018-01-27 10:04:18'),
(208, 'West Bank', '/', '970', '1.00', '1', '2018-01-27 10:04:18', '2018-01-27 10:04:18'),
(209, 'Yemen', 'YE / YEM', '967', '1.00', '1', '2018-01-27 10:04:18', '2018-01-27 10:04:18'),
(210, 'Zambia', 'ZM / ZMB', '260', '1.00', '1', '2018-01-27 10:04:18', '2018-01-27 10:04:18'),
(211, 'Zimbabwe', 'ZW / ZWE', '263', '1.00', '1', '2018-01-27 10:04:18', '2018-01-27 10:04:18');

-- --------------------------------------------------------

--
-- Table structure for table `sys_invoices`
--

CREATE TABLE `sys_invoices` (
  `id` int(10) UNSIGNED NOT NULL,
  `cl_id` int(11) NOT NULL,
  `client_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created` date NOT NULL DEFAULT '2018-01-27',
  `duedate` date DEFAULT NULL,
  `datepaid` date DEFAULT NULL,
  `subtotal` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `status` enum('Unpaid','Paid','Partially Paid','Cancelled') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Unpaid',
  `pmethod` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `recurring` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `bill_created` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `note` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sys_invoice_items`
--

CREATE TABLE `sys_invoice_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `inv_id` int(11) NOT NULL,
  `cl_id` int(11) NOT NULL,
  `item` text COLLATE utf8_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `qty` int(11) NOT NULL DEFAULT '0',
  `subtotal` decimal(10,2) NOT NULL DEFAULT '0.00',
  `tax` decimal(5,2) NOT NULL DEFAULT '0.00',
  `discount` decimal(5,2) NOT NULL DEFAULT '0.00',
  `total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sys_language`
--

CREATE TABLE `sys_language` (
  `id` int(10) UNSIGNED NOT NULL,
  `language` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('Active','Inactive') COLLATE utf8_unicode_ci NOT NULL,
  `icon` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `sys_language`
--

INSERT INTO `sys_language` (`id`, `language`, `status`, `icon`, `created_at`, `updated_at`) VALUES
(1, 'English', 'Active', 'us.gif', '2018-01-27 10:04:18', '2018-01-27 10:04:18');

-- --------------------------------------------------------

--
-- Table structure for table `sys_language_data`
--

CREATE TABLE `sys_language_data` (
  `id` int(10) UNSIGNED NOT NULL,
  `lan_id` int(11) NOT NULL,
  `lan_data` text COLLATE utf8_unicode_ci NOT NULL,
  `lan_value` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `sys_language_data`
--

INSERT INTO `sys_language_data` (`id`, `lan_id`, `lan_data`, `lan_value`, `created_at`, `updated_at`) VALUES
(1, 1, 'Admin', 'Admin', '2018-01-27 10:04:19', '2018-01-27 10:04:19'),
(2, 1, 'Login', 'Login', '2018-01-27 10:04:19', '2018-01-27 10:04:19'),
(3, 1, 'Forget Password', 'Forget Password', '2018-01-27 10:04:19', '2018-01-27 10:04:19'),
(4, 1, 'Sign to your account', 'Sign to your account', '2018-01-27 10:04:19', '2018-01-27 10:04:19'),
(5, 1, 'User Name', 'User Name', '2018-01-27 10:04:19', '2018-01-27 10:04:19'),
(6, 1, 'Password', 'Password', '2018-01-27 10:04:19', '2018-01-27 10:04:19'),
(7, 1, 'Remember Me', 'Remember Me', '2018-01-27 10:04:19', '2018-01-27 10:04:19'),
(8, 1, 'Reset your password', 'Reset your password', '2018-01-27 10:04:19', '2018-01-27 10:04:19'),
(9, 1, 'Email', 'Email', '2018-01-27 10:04:19', '2018-01-27 10:04:19'),
(10, 1, 'Add New Client', 'Add New Client', '2018-01-27 10:04:19', '2018-01-27 10:04:19'),
(11, 1, 'First Name', 'First Name', '2018-01-27 10:04:19', '2018-01-27 10:04:19'),
(12, 1, 'Last Name', 'Last Name', '2018-01-27 10:04:19', '2018-01-27 10:04:19'),
(13, 1, 'Company', 'Company', '2018-01-27 10:04:19', '2018-01-27 10:04:19'),
(14, 1, 'Website', 'Website', '2018-01-27 10:04:19', '2018-01-27 10:04:19'),
(15, 1, 'If you leave this, then you can not reset password or can not maintain email related function', 'If you leave this, then you can not reset password or can not maintain email related function', '2018-01-27 10:04:19', '2018-01-27 10:04:19'),
(16, 1, 'Confirm Password', 'Confirm Password', '2018-01-27 10:04:19', '2018-01-27 10:04:19'),
(17, 1, 'Phone', 'Phone', '2018-01-27 10:04:19', '2018-01-27 10:04:19'),
(18, 1, 'Address', 'Address', '2018-01-27 10:04:20', '2018-01-27 10:04:20'),
(19, 1, 'More Address', 'More Address', '2018-01-27 10:04:20', '2018-01-27 10:04:20'),
(20, 1, 'State', 'State', '2018-01-27 10:04:20', '2018-01-27 10:04:20'),
(21, 1, 'City', 'City', '2018-01-27 10:04:20', '2018-01-27 10:04:20'),
(22, 1, 'Postcode', 'Postcode', '2018-01-27 10:04:20', '2018-01-27 10:04:20'),
(23, 1, 'Country', 'Country', '2018-01-27 10:04:20', '2018-01-27 10:04:20'),
(24, 1, 'Api Access', 'Api Access', '2018-01-27 10:04:20', '2018-01-27 10:04:20'),
(25, 1, 'Yes', 'Yes', '2018-01-27 10:04:20', '2018-01-27 10:04:20'),
(26, 1, 'No', 'No', '2018-01-27 10:04:20', '2018-01-27 10:04:20'),
(27, 1, 'Client Group', 'Client Group', '2018-01-27 10:04:20', '2018-01-27 10:04:20'),
(28, 1, 'None', 'None', '2018-01-27 10:04:20', '2018-01-27 10:04:20'),
(29, 1, 'SMS Gateway', 'SMS Gateway', '2018-01-27 10:04:20', '2018-01-27 10:04:20'),
(30, 1, 'SMS Limit', 'SMS Limit', '2018-01-27 10:04:20', '2018-01-27 10:04:20'),
(31, 1, 'Avatar', 'Avatar', '2018-01-27 10:04:20', '2018-01-27 10:04:20'),
(32, 1, 'Browse', 'Browse', '2018-01-27 10:04:20', '2018-01-27 10:04:20'),
(33, 1, 'Notify Client with email', 'Notify Client with email', '2018-01-27 10:04:20', '2018-01-27 10:04:20'),
(34, 1, 'Add', 'Add', '2018-01-27 10:04:20', '2018-01-27 10:04:20'),
(35, 1, 'Add New Invoice', 'Add New Invoice', '2018-01-27 10:04:20', '2018-01-27 10:04:20'),
(36, 1, 'Client', 'Client', '2018-01-27 10:04:20', '2018-01-27 10:04:20'),
(37, 1, 'Invoice Type', 'Invoice Type', '2018-01-27 10:04:21', '2018-01-27 10:04:21'),
(38, 1, 'One Time', 'One Time', '2018-01-27 10:04:21', '2018-01-27 10:04:21'),
(39, 1, 'Recurring', 'Recurring', '2018-01-27 10:04:21', '2018-01-27 10:04:21'),
(40, 1, 'Invoice Date', 'Invoice Date', '2018-01-27 10:04:21', '2018-01-27 10:04:21'),
(41, 1, 'Due Date', 'Due Date', '2018-01-27 10:04:21', '2018-01-27 10:04:21'),
(42, 1, 'Paid Date', 'Paid Date', '2018-01-27 10:04:21', '2018-01-27 10:04:21'),
(43, 1, 'Repeat Every', 'Repeat Every', '2018-01-27 10:04:21', '2018-01-27 10:04:21'),
(44, 1, 'Week', 'Week', '2018-01-27 10:04:21', '2018-01-27 10:04:21'),
(45, 1, '2 Weeks', '2 Weeks', '2018-01-27 10:04:21', '2018-01-27 10:04:21'),
(46, 1, 'Month', 'Month', '2018-01-27 10:04:21', '2018-01-27 10:04:21'),
(47, 1, '2 Months', '2 Months', '2018-01-27 10:04:21', '2018-01-27 10:04:21'),
(48, 1, '3 Months', '3 Months', '2018-01-27 10:04:21', '2018-01-27 10:04:21'),
(49, 1, '6 Months', '6 Months', '2018-01-27 10:04:21', '2018-01-27 10:04:21'),
(50, 1, 'Year', 'Year', '2018-01-27 10:04:21', '2018-01-27 10:04:21'),
(51, 1, '2 Years', '2 Years', '2018-01-27 10:04:21', '2018-01-27 10:04:21'),
(52, 1, '3 Years', '3 Years', '2018-01-27 10:04:21', '2018-01-27 10:04:21'),
(53, 1, 'Item Name', 'Item Name', '2018-01-27 10:04:21', '2018-01-27 10:04:21'),
(54, 1, 'Price', 'Price', '2018-01-27 10:04:21', '2018-01-27 10:04:21'),
(55, 1, 'Qty', 'Qty', '2018-01-27 10:04:21', '2018-01-27 10:04:21'),
(56, 1, 'Quantity', 'Quantity', '2018-01-27 10:04:21', '2018-01-27 10:04:21'),
(57, 1, 'Tax', 'Tax', '2018-01-27 10:04:21', '2018-01-27 10:04:21'),
(58, 1, 'Discount', 'Discount', '2018-01-27 10:04:21', '2018-01-27 10:04:21'),
(59, 1, 'Per Item Total', 'Per Item Total', '2018-01-27 10:04:22', '2018-01-27 10:04:22'),
(60, 1, 'Add Item', 'Add Item', '2018-01-27 10:04:22', '2018-01-27 10:04:22'),
(61, 1, 'Item', 'Item', '2018-01-27 10:04:22', '2018-01-27 10:04:22'),
(62, 1, 'Delete', 'Delete', '2018-01-27 10:04:22', '2018-01-27 10:04:22'),
(63, 1, 'Total', 'Total', '2018-01-27 10:04:22', '2018-01-27 10:04:22'),
(64, 1, 'Invoice Note', 'Invoice Note', '2018-01-27 10:04:22', '2018-01-27 10:04:22'),
(65, 1, 'Create Invoice', 'Create Invoice', '2018-01-27 10:04:22', '2018-01-27 10:04:22'),
(66, 1, 'Add Plan Feature', 'Add Plan Feature', '2018-01-27 10:04:22', '2018-01-27 10:04:22'),
(67, 1, 'Show In Client', 'Show In Client', '2018-01-27 10:04:22', '2018-01-27 10:04:22'),
(68, 1, 'Feature Name', 'Feature Name', '2018-01-27 10:04:22', '2018-01-27 10:04:22'),
(69, 1, 'Feature Value', 'Feature Value', '2018-01-27 10:04:22', '2018-01-27 10:04:22'),
(70, 1, 'Action', 'Action', '2018-01-27 10:04:22', '2018-01-27 10:04:22'),
(71, 1, 'Add More', 'Add More', '2018-01-27 10:04:22', '2018-01-27 10:04:22'),
(72, 1, 'Save', 'Save', '2018-01-27 10:04:22', '2018-01-27 10:04:22'),
(73, 1, 'Add SMS Price Plan', 'Add SMS Price Plan', '2018-01-27 10:04:22', '2018-01-27 10:04:22'),
(74, 1, 'Plan Name', 'Plan Name', '2018-01-27 10:04:22', '2018-01-27 10:04:22'),
(75, 1, 'Mark Popular', 'Mark Popular', '2018-01-27 10:04:22', '2018-01-27 10:04:22'),
(76, 1, 'Popular', 'Popular', '2018-01-27 10:04:22', '2018-01-27 10:04:22'),
(77, 1, 'Show', 'Show', '2018-01-27 10:04:22', '2018-01-27 10:04:22'),
(78, 1, 'Hide', 'Hide', '2018-01-27 10:04:22', '2018-01-27 10:04:22'),
(79, 1, 'Add Plan', 'Add Plan', '2018-01-27 10:04:23', '2018-01-27 10:04:23'),
(80, 1, 'Add Sender ID', 'Add Sender ID', '2018-01-27 10:04:23', '2018-01-27 10:04:23'),
(81, 1, 'All', 'All', '2018-01-27 10:04:23', '2018-01-27 10:04:23'),
(82, 1, 'Status', 'Status', '2018-01-27 10:04:23', '2018-01-27 10:04:23'),
(83, 1, 'Block', 'Block', '2018-01-27 10:04:23', '2018-01-27 10:04:23'),
(84, 1, 'Unblock', 'Unblock', '2018-01-27 10:04:23', '2018-01-27 10:04:23'),
(85, 1, 'Sender ID', 'Sender ID', '2018-01-27 10:04:23', '2018-01-27 10:04:23'),
(86, 1, 'Add SMS Gateway', 'Add SMS Gateway', '2018-01-27 10:04:23', '2018-01-27 10:04:23'),
(87, 1, 'Gateway Name', 'Gateway Name', '2018-01-27 10:04:23', '2018-01-27 10:04:23'),
(88, 1, 'Gateway API Link', 'Gateway API Link', '2018-01-27 10:04:23', '2018-01-27 10:04:23'),
(89, 1, 'Api link execute like', 'Api link execute like', '2018-01-27 10:04:23', '2018-01-27 10:04:23'),
(90, 1, 'Active', 'Active', '2018-01-27 10:04:23', '2018-01-27 10:04:23'),
(91, 1, 'Inactive', 'Inactive', '2018-01-27 10:04:23', '2018-01-27 10:04:23'),
(92, 1, 'Parameter', 'Parameter', '2018-01-27 10:04:23', '2018-01-27 10:04:23'),
(93, 1, 'Value', 'Value', '2018-01-27 10:04:23', '2018-01-27 10:04:23'),
(94, 1, 'Add On URL', 'Add On URL', '2018-01-27 10:04:23', '2018-01-27 10:04:23'),
(95, 1, 'Username_Key', 'Username/Key', '2018-01-27 10:04:23', '2018-01-27 10:04:23'),
(96, 1, 'Set Blank', 'Set Blank', '2018-01-27 10:04:23', '2018-01-27 10:04:23'),
(97, 1, 'Add on parameter', 'Add on parameter', '2018-01-27 10:04:24', '2018-01-27 10:04:24'),
(98, 1, 'Source', 'Source', '2018-01-27 10:04:24', '2018-01-27 10:04:24'),
(99, 1, 'Destination', 'Destination', '2018-01-27 10:04:24', '2018-01-27 10:04:24'),
(100, 1, 'Message', 'Message', '2018-01-27 10:04:24', '2018-01-27 10:04:24'),
(101, 1, 'Unicode', 'Unicode', '2018-01-27 10:04:24', '2018-01-27 10:04:24'),
(102, 1, 'Type_Route', 'Type/Route', '2018-01-27 10:04:24', '2018-01-27 10:04:24'),
(103, 1, 'Language', 'Language', '2018-01-27 10:04:24', '2018-01-27 10:04:24'),
(104, 1, 'Custom Value 1', 'Custom Value 1', '2018-01-27 10:04:24', '2018-01-27 10:04:24'),
(105, 1, 'Custom Value 2', 'Custom Value 2', '2018-01-27 10:04:24', '2018-01-27 10:04:24'),
(106, 1, 'Custom Value 3', 'Custom Value 3', '2018-01-27 10:04:24', '2018-01-27 10:04:24'),
(107, 1, 'Administrator Roles', 'Administrator Roles', '2018-01-27 10:04:24', '2018-01-27 10:04:24'),
(108, 1, 'Add Administrator Role', 'Add Administrator Role', '2018-01-27 10:04:24', '2018-01-27 10:04:24'),
(109, 1, 'Role Name', 'Role Name', '2018-01-27 10:04:24', '2018-01-27 10:04:24'),
(110, 1, 'SL', 'SL', '2018-01-27 10:04:24', '2018-01-27 10:04:24'),
(111, 1, 'Set Roles', 'Set Roles', '2018-01-27 10:04:24', '2018-01-27 10:04:24'),
(112, 1, 'Administrators', 'Administrators', '2018-01-27 10:04:24', '2018-01-27 10:04:24'),
(113, 1, 'Add New Administrator', 'Add New Administrator', '2018-01-27 10:04:24', '2018-01-27 10:04:24'),
(114, 1, 'Role', 'Role', '2018-01-27 10:04:24', '2018-01-27 10:04:24'),
(115, 1, 'Notify Administrator with email', 'Notify Administrator with email', '2018-01-27 10:04:25', '2018-01-27 10:04:25'),
(116, 1, 'Name', 'Name', '2018-01-27 10:04:25', '2018-01-27 10:04:25'),
(117, 1, 'All Clients', 'All Clients', '2018-01-27 10:04:25', '2018-01-27 10:04:25'),
(118, 1, 'Clients', 'Clients', '2018-01-27 10:04:25', '2018-01-27 10:04:25'),
(119, 1, 'Created', 'Created', '2018-01-27 10:04:25', '2018-01-27 10:04:25'),
(120, 1, 'Created By', 'Created By', '2018-01-27 10:04:25', '2018-01-27 10:04:25'),
(121, 1, 'Manage', 'Manage', '2018-01-27 10:04:25', '2018-01-27 10:04:25'),
(122, 1, 'Closed', 'Closed', '2018-01-27 10:04:25', '2018-01-27 10:04:25'),
(123, 1, 'All Invoices', 'All Invoices', '2018-01-27 10:04:25', '2018-01-27 10:04:25'),
(124, 1, 'Client Name', 'Client Name', '2018-01-27 10:04:25', '2018-01-27 10:04:25'),
(125, 1, 'Amount', 'Amount', '2018-01-27 10:04:25', '2018-01-27 10:04:25'),
(126, 1, 'Type', 'Type', '2018-01-27 10:04:25', '2018-01-27 10:04:25'),
(127, 1, 'Unpaid', 'Unpaid', '2018-01-27 10:04:25', '2018-01-27 10:04:25'),
(128, 1, 'Paid', 'Paid', '2018-01-27 10:04:25', '2018-01-27 10:04:25'),
(129, 1, 'Cancelled', 'Cancelled', '2018-01-27 10:04:25', '2018-01-27 10:04:25'),
(130, 1, 'Partially Paid', 'Partially Paid', '2018-01-27 10:04:25', '2018-01-27 10:04:25'),
(131, 1, 'Onetime', 'Onetime', '2018-01-27 10:04:25', '2018-01-27 10:04:25'),
(132, 1, 'Recurring', 'Recurring', '2018-01-27 10:04:25', '2018-01-27 10:04:25'),
(133, 1, 'Stop Recurring', 'Stop Recurring', '2018-01-27 10:04:25', '2018-01-27 10:04:25'),
(134, 1, 'View', 'View', '2018-01-27 10:04:25', '2018-01-27 10:04:25'),
(135, 1, 'Change Password', 'Change Password', '2018-01-27 10:04:26', '2018-01-27 10:04:26'),
(136, 1, 'Current Password', 'Current Password', '2018-01-27 10:04:26', '2018-01-27 10:04:26'),
(137, 1, 'New Password', 'New Password', '2018-01-27 10:04:26', '2018-01-27 10:04:26'),
(138, 1, 'Update', 'Update', '2018-01-27 10:04:26', '2018-01-27 10:04:26'),
(139, 1, 'Edit', 'Edit', '2018-01-27 10:04:26', '2018-01-27 10:04:26'),
(140, 1, 'Clients Groups', 'Clients Groups', '2018-01-27 10:04:26', '2018-01-27 10:04:26'),
(141, 1, 'Add New Group', 'Add New Group', '2018-01-27 10:04:26', '2018-01-27 10:04:26'),
(142, 1, 'Group Name', 'Group Name', '2018-01-27 10:04:26', '2018-01-27 10:04:26'),
(143, 1, 'Export Clients', 'Export Clients', '2018-01-27 10:04:26', '2018-01-27 10:04:26'),
(144, 1, 'View Profile', 'View Profile', '2018-01-27 10:04:26', '2018-01-27 10:04:26'),
(145, 1, 'Location', 'Location', '2018-01-27 10:04:26', '2018-01-27 10:04:26'),
(146, 1, 'SMS Balance', 'SMS Balance', '2018-01-27 10:04:26', '2018-01-27 10:04:26'),
(147, 1, 'Send SMS', 'Send SMS', '2018-01-27 10:04:26', '2018-01-27 10:04:26'),
(148, 1, 'Update Limit', 'Update Limit', '2018-01-27 10:04:26', '2018-01-27 10:04:26'),
(149, 1, 'Change Image', 'Change Image', '2018-01-27 10:04:26', '2018-01-27 10:04:26'),
(150, 1, 'Edit Profile', 'Edit Profile', '2018-01-27 10:04:26', '2018-01-27 10:04:26'),
(151, 1, 'Support Tickets', 'Support Tickets', '2018-01-27 10:04:26', '2018-01-27 10:04:26'),
(152, 1, 'Change', 'Change', '2018-01-27 10:04:26', '2018-01-27 10:04:26'),
(153, 1, 'Basic Info', 'Basic Info', '2018-01-27 10:04:27', '2018-01-27 10:04:27'),
(154, 1, 'Invoices', 'Invoices', '2018-01-27 10:04:27', '2018-01-27 10:04:27'),
(155, 1, 'SMS Transaction', 'SMS Transaction', '2018-01-27 10:04:27', '2018-01-27 10:04:27'),
(156, 1, 'Leave blank if you do not change', 'Leave blank if you do not change', '2018-01-27 10:04:27', '2018-01-27 10:04:27'),
(157, 1, 'Subject', 'Subject', '2018-01-27 10:04:27', '2018-01-27 10:04:27'),
(158, 1, 'Date', 'Date', '2018-01-27 10:04:27', '2018-01-27 10:04:27'),
(159, 1, 'Pending', 'Pending', '2018-01-27 10:04:27', '2018-01-27 10:04:27'),
(160, 1, 'Answered', 'Answered', '2018-01-27 10:04:27', '2018-01-27 10:04:27'),
(161, 1, 'Customer Reply', 'Customer Reply', '2018-01-27 10:04:27', '2018-01-27 10:04:27'),
(162, 1, 'characters remaining', 'characters remaining', '2018-01-27 10:04:27', '2018-01-27 10:04:27'),
(163, 1, 'Close', 'Close', '2018-01-27 10:04:27', '2018-01-27 10:04:27'),
(164, 1, 'Send', 'Send', '2018-01-27 10:04:27', '2018-01-27 10:04:27'),
(165, 1, 'Update with previous balance. Enter (-) amount for decrease limit', 'Update with previous balance. Enter (-) amount for decrease limit', '2018-01-27 10:04:27', '2018-01-27 10:04:27'),
(166, 1, 'Update Image', 'Update Image', '2018-01-27 10:04:27', '2018-01-27 10:04:27'),
(167, 1, 'Coverage', 'Coverage', '2018-01-27 10:04:27', '2018-01-27 10:04:27'),
(168, 1, 'ISO Code', 'ISO Code', '2018-01-27 10:04:27', '2018-01-27 10:04:27'),
(169, 1, 'Country Code', 'Country Code', '2018-01-27 10:04:27', '2018-01-27 10:04:27'),
(170, 1, 'Tariff', 'Tariff', '2018-01-27 10:04:27', '2018-01-27 10:04:27'),
(171, 1, 'Live', 'Live', '2018-01-27 10:04:27', '2018-01-27 10:04:27'),
(172, 1, 'Offline', 'Offline', '2018-01-27 10:04:27', '2018-01-27 10:04:27'),
(173, 1, 'Create New Ticket', 'Create New Ticket', '2018-01-27 10:04:27', '2018-01-27 10:04:27'),
(174, 1, 'Ticket For Client', 'Ticket For Client', '2018-01-27 10:04:28', '2018-01-27 10:04:28'),
(175, 1, 'Department', 'Department', '2018-01-27 10:04:28', '2018-01-27 10:04:28'),
(176, 1, 'Create Ticket', 'Create Ticket', '2018-01-27 10:04:28', '2018-01-27 10:04:28'),
(177, 1, 'Create SMS Template', 'Create SMS Template', '2018-01-27 10:04:28', '2018-01-27 10:04:28'),
(178, 1, 'SMS Templates', 'SMS Templates', '2018-01-27 10:04:28', '2018-01-27 10:04:28'),
(179, 1, 'Select Template', 'Select Template', '2018-01-27 10:04:28', '2018-01-27 10:04:28'),
(180, 1, 'Template Name', 'Template Name', '2018-01-27 10:04:28', '2018-01-27 10:04:28'),
(181, 1, 'From', 'From', '2018-01-27 10:04:28', '2018-01-27 10:04:28'),
(182, 1, 'Insert Merge Filed', 'Insert Merge Filed', '2018-01-27 10:04:28', '2018-01-27 10:04:28'),
(183, 1, 'Select Merge Field', 'Select Merge Field', '2018-01-27 10:04:28', '2018-01-27 10:04:28'),
(184, 1, 'Phone Number', 'Phone Number', '2018-01-27 10:04:28', '2018-01-27 10:04:28'),
(185, 1, 'Add New', 'Add New', '2018-01-27 10:04:28', '2018-01-27 10:04:28'),
(186, 1, 'Tickets', 'Tickets', '2018-01-27 10:04:28', '2018-01-27 10:04:28'),
(187, 1, 'Invoices History', 'Invoices History', '2018-01-27 10:04:28', '2018-01-27 10:04:28'),
(188, 1, 'Tickets History', 'Tickets History', '2018-01-27 10:04:28', '2018-01-27 10:04:28'),
(189, 1, 'SMS Success History', 'SMS Success History', '2018-01-27 10:04:28', '2018-01-27 10:04:28'),
(190, 1, 'SMS History By Date', 'SMS History By Date', '2018-01-27 10:04:28', '2018-01-27 10:04:28'),
(191, 1, 'Recent 5 Invoices', 'Recent 5 Invoices', '2018-01-27 10:04:28', '2018-01-27 10:04:28'),
(192, 1, 'Recent 5 Support Tickets', 'Recent 5 Support Tickets', '2018-01-27 10:04:28', '2018-01-27 10:04:28'),
(193, 1, 'Edit Invoice', 'Edit Invoice', '2018-01-27 10:04:28', '2018-01-27 10:04:28'),
(194, 1, 'View Invoice', 'View Invoice', '2018-01-27 10:04:29', '2018-01-27 10:04:29'),
(195, 1, 'Send Invoice', 'Send Invoice', '2018-01-27 10:04:29', '2018-01-27 10:04:29'),
(196, 1, 'Access Role', 'Access Role', '2018-01-27 10:04:29', '2018-01-27 10:04:29'),
(197, 1, 'Super Admin', 'Super Admin', '2018-01-27 10:04:29', '2018-01-27 10:04:29'),
(198, 1, 'Personal Details', 'Personal Details', '2018-01-27 10:04:29', '2018-01-27 10:04:29'),
(199, 1, 'Unique For every User', 'Unique For every User', '2018-01-27 10:04:29', '2018-01-27 10:04:29'),
(200, 1, 'Email Templates', 'Email Templates', '2018-01-27 10:04:29', '2018-01-27 10:04:29'),
(201, 1, 'Manage Email Template', 'Manage Email Template', '2018-01-27 10:04:29', '2018-01-27 10:04:29'),
(202, 1, 'Export and Import Clients', 'Export and Import Clients', '2018-01-27 10:04:29', '2018-01-27 10:04:29'),
(203, 1, 'Export Clients', 'Export Clients', '2018-01-27 10:04:29', '2018-01-27 10:04:29'),
(204, 1, 'Export Clients as CSV', 'Export Clients as CSV', '2018-01-27 10:04:29', '2018-01-27 10:04:29'),
(205, 1, 'Sample File', 'Sample File', '2018-01-27 10:04:29', '2018-01-27 10:04:29'),
(206, 1, 'Download Sample File', 'Download Sample File', '2018-01-27 10:04:29', '2018-01-27 10:04:29'),
(207, 1, 'Import Clients', 'Import Clients', '2018-01-27 10:04:29', '2018-01-27 10:04:29'),
(208, 1, 'It will take few minutes. Please do not reload the page', 'It will take few minutes. Please do not reload the page', '2018-01-27 10:04:29', '2018-01-27 10:04:29'),
(209, 1, 'Import', 'Import', '2018-01-27 10:04:29', '2018-01-27 10:04:29'),
(210, 1, 'Reset My Password', 'Reset My Password', '2018-01-27 10:04:30', '2018-01-27 10:04:30'),
(211, 1, 'Back To Sign in', 'Back To Sign in', '2018-01-27 10:04:30', '2018-01-27 10:04:30'),
(212, 1, 'Invoice No', 'Invoice No', '2018-01-27 10:04:30', '2018-01-27 10:04:30'),
(213, 1, 'Invoice', 'Invoice', '2018-01-27 10:04:30', '2018-01-27 10:04:30'),
(214, 1, 'Invoice To', 'Invoice To', '2018-01-27 10:04:30', '2018-01-27 10:04:30'),
(215, 1, 'Printable Version', 'Printable Version', '2018-01-27 10:04:30', '2018-01-27 10:04:30'),
(216, 1, 'Invoice Status', 'Invoice Status', '2018-01-27 10:04:30', '2018-01-27 10:04:30'),
(217, 1, 'Subtotal', 'Subtotal', '2018-01-27 10:04:30', '2018-01-27 10:04:30'),
(218, 1, 'Grand Total', 'Grand Total', '2018-01-27 10:04:30', '2018-01-27 10:04:30'),
(219, 1, 'Amount Due', 'Amount Due', '2018-01-27 10:04:30', '2018-01-27 10:04:30'),
(220, 1, 'Add Language', 'Add Language', '2018-01-27 10:04:30', '2018-01-27 10:04:30'),
(221, 1, 'Flag', 'Flag', '2018-01-27 10:04:30', '2018-01-27 10:04:30'),
(222, 1, 'All Languages', 'All Languages', '2018-01-27 10:04:30', '2018-01-27 10:04:30'),
(223, 1, 'Translate', 'Translate', '2018-01-27 10:04:30', '2018-01-27 10:04:30'),
(224, 1, 'Language Manage', 'Language Manage', '2018-01-27 10:04:30', '2018-01-27 10:04:30'),
(225, 1, 'Language Name', 'Language Name', '2018-01-27 10:04:30', '2018-01-27 10:04:30'),
(226, 1, 'English To', 'English To', '2018-01-27 10:04:30', '2018-01-27 10:04:30'),
(227, 1, 'English', 'English', '2018-01-27 10:04:30', '2018-01-27 10:04:30'),
(228, 1, 'Localization', 'Localization', '2018-01-27 10:04:30', '2018-01-27 10:04:30'),
(229, 1, 'Date Format', 'Date Format', '2018-01-27 10:04:30', '2018-01-27 10:04:30'),
(230, 1, 'Timezone', 'Timezone', '2018-01-27 10:04:30', '2018-01-27 10:04:30'),
(231, 1, 'Default Language', 'Default Language', '2018-01-27 10:04:30', '2018-01-27 10:04:30'),
(232, 1, 'Current Code', 'Current Code', '2018-01-27 10:04:31', '2018-01-27 10:04:31'),
(233, 1, 'Current Symbol', 'Current Symbol', '2018-01-27 10:04:31', '2018-01-27 10:04:31'),
(234, 1, 'Default Country', 'Default Country', '2018-01-27 10:04:31', '2018-01-27 10:04:31'),
(235, 1, 'Manage Administrator', 'Manage Administrator', '2018-01-27 10:04:31', '2018-01-27 10:04:31'),
(236, 1, 'Manage Coverage', 'Manage Coverage', '2018-01-27 10:04:31', '2018-01-27 10:04:31'),
(237, 1, 'Cost for per SMS', 'Cost for per SMS', '2018-01-27 10:04:31', '2018-01-27 10:04:31'),
(238, 1, 'SMS Gateway Manage', 'SMS Gateway Manage', '2018-01-27 10:04:31', '2018-01-27 10:04:31'),
(239, 1, 'Manage Plan Feature', 'Manage Plan Feature', '2018-01-27 10:04:31', '2018-01-27 10:04:31'),
(240, 1, 'SMS Plan Features', 'SMS Plan Features', '2018-01-27 10:04:31', '2018-01-27 10:04:31'),
(241, 1, 'Update Feature', 'Update Feature', '2018-01-27 10:04:31', '2018-01-27 10:04:31'),
(242, 1, 'Manage SMS Price Plan', 'Manage SMS Price Plan', '2018-01-27 10:04:31', '2018-01-27 10:04:31'),
(243, 1, 'SMS Price Plan', 'SMS Price Plan', '2018-01-27 10:04:31', '2018-01-27 10:04:31'),
(244, 1, 'Update Plan', 'Update Plan', '2018-01-27 10:04:31', '2018-01-27 10:04:31'),
(245, 1, 'Msisdn', 'Msisdn', '2018-01-27 10:04:31', '2018-01-27 10:04:31'),
(246, 1, 'Account Sid', 'Account Sid', '2018-01-27 10:04:31', '2018-01-27 10:04:31'),
(247, 1, 'SMS Api', 'SMS Api', '2018-01-27 10:04:31', '2018-01-27 10:04:31'),
(248, 1, 'SMS Api User name', 'SMS Api User name', '2018-01-27 10:04:31', '2018-01-27 10:04:31'),
(249, 1, 'Auth ID', 'Auth ID', '2018-01-27 10:04:31', '2018-01-27 10:04:31'),
(250, 1, 'Auth Token', 'Auth Token', '2018-01-27 10:04:31', '2018-01-27 10:04:31'),
(251, 1, 'SMS Api key', 'SMS Api key', '2018-01-27 10:04:31', '2018-01-27 10:04:31'),
(252, 1, 'SMS Api Password', 'SMS Api Password', '2018-01-27 10:04:31', '2018-01-27 10:04:31'),
(253, 1, 'Extra Value', 'Extra Value', '2018-01-27 10:04:32', '2018-01-27 10:04:32'),
(254, 1, 'Schedule SMS', 'Schedule SMS', '2018-01-27 10:04:32', '2018-01-27 10:04:32'),
(255, 1, 'Manage SMS Template', 'Manage SMS Template', '2018-01-27 10:04:32', '2018-01-27 10:04:32'),
(256, 1, 'Edit Administrator Role', 'Edit Administrator Role', '2018-01-27 10:04:32', '2018-01-27 10:04:32'),
(257, 1, 'Manage Payment Gateway', 'Manage Payment Gateway', '2018-01-27 10:04:32', '2018-01-27 10:04:32'),
(258, 1, 'Publishable Key', 'Publishable Key', '2018-01-27 10:04:32', '2018-01-27 10:04:32'),
(259, 1, 'Bank Details', 'Bank Details', '2018-01-27 10:04:32', '2018-01-27 10:04:32'),
(260, 1, 'Api Login ID', 'Api Login ID', '2018-01-27 10:04:32', '2018-01-27 10:04:32'),
(261, 1, 'Secret_Key_Signature', 'Secret Key/Signature', '2018-01-27 10:04:32', '2018-01-27 10:04:32'),
(262, 1, 'Transaction Key', 'Transaction Key', '2018-01-27 10:04:32', '2018-01-27 10:04:32'),
(263, 1, 'Payment Gateways', 'Payment Gateways', '2018-01-27 10:04:32', '2018-01-27 10:04:32'),
(264, 1, 'Send Bulk SMS', 'Send Bulk SMS', '2018-01-27 10:04:32', '2018-01-27 10:04:32'),
(265, 1, 'Bulk SMS', 'Bulk SMS', '2018-01-27 10:04:32', '2018-01-27 10:04:32'),
(266, 1, 'After click on Send button, do not refresh your browser', 'After click on Send button, do not refresh your browser', '2018-01-27 10:04:32', '2018-01-27 10:04:32'),
(267, 1, 'Schedule Time', 'Schedule Time', '2018-01-27 10:04:32', '2018-01-27 10:04:32'),
(268, 1, 'Import Numbers', 'Import Numbers', '2018-01-27 10:04:32', '2018-01-27 10:04:32'),
(269, 1, 'Set Rules', 'Set Rules', '2018-01-27 10:04:32', '2018-01-27 10:04:32'),
(270, 1, 'Check All', 'Check All', '2018-01-27 10:04:32', '2018-01-27 10:04:32'),
(271, 1, 'Send SMS From File', 'Send SMS From File', '2018-01-27 10:04:32', '2018-01-27 10:04:32'),
(272, 1, 'Schedule SMS From File', 'Schedule SMS From File', '2018-01-27 10:04:32', '2018-01-27 10:04:32'),
(273, 1, 'SMS History', 'SMS History', '2018-01-27 10:04:32', '2018-01-27 10:04:32'),
(274, 1, 'Add Price Plan', 'Add Price Plan', '2018-01-27 10:04:32', '2018-01-27 10:04:32'),
(275, 1, 'Sender ID Management', 'Sender ID Management', '2018-01-27 10:04:33', '2018-01-27 10:04:33'),
(276, 1, 'Support Department', 'Support Department', '2018-01-27 10:04:33', '2018-01-27 10:04:33'),
(277, 1, 'Department Name', 'Department Name', '2018-01-27 10:04:33', '2018-01-27 10:04:33'),
(278, 1, 'Department Email', 'Department Email', '2018-01-27 10:04:33', '2018-01-27 10:04:33'),
(279, 1, 'System Settings', 'System Settings', '2018-01-27 10:04:33', '2018-01-27 10:04:33'),
(280, 1, 'Language Settings', 'Language Settings', '2018-01-27 10:04:33', '2018-01-27 10:04:33'),
(281, 1, 'SMS API Info', 'SMS API Info', '2018-01-27 10:04:33', '2018-01-27 10:04:33'),
(282, 1, 'SMS API URL', 'SMS API URL', '2018-01-27 10:04:33', '2018-01-27 10:04:33'),
(283, 1, 'Generate New', 'Generate New', '2018-01-27 10:04:33', '2018-01-27 10:04:33'),
(284, 1, 'SMS API Details', 'SMS API Details', '2018-01-27 10:04:33', '2018-01-27 10:04:33'),
(285, 1, 'Add Gateway', 'Add Gateway', '2018-01-27 10:04:33', '2018-01-27 10:04:33'),
(286, 1, 'Two Way', 'Two Way', '2018-01-27 10:04:33', '2018-01-27 10:04:33'),
(287, 1, 'Send By', 'Send By', '2018-01-27 10:04:33', '2018-01-27 10:04:33'),
(288, 1, 'Sender', 'Sender', '2018-01-27 10:04:33', '2018-01-27 10:04:33'),
(289, 1, 'Receiver', 'Receiver', '2018-01-27 10:04:33', '2018-01-27 10:04:33'),
(290, 1, 'Inbox', 'Inbox', '2018-01-27 10:04:33', '2018-01-27 10:04:33'),
(291, 1, 'Add Feature', 'Add Feature', '2018-01-27 10:04:33', '2018-01-27 10:04:33'),
(292, 1, 'View Features', 'View Features', '2018-01-27 10:04:33', '2018-01-27 10:04:33'),
(293, 1, 'Create Template', 'Create Template', '2018-01-27 10:04:33', '2018-01-27 10:04:33'),
(294, 1, 'Application Name', 'Application Name', '2018-01-27 10:04:33', '2018-01-27 10:04:33'),
(295, 1, 'Application Title', 'Application Title', '2018-01-27 10:04:33', '2018-01-27 10:04:33'),
(296, 1, 'System Email', 'System Email', '2018-01-27 10:04:34', '2018-01-27 10:04:34'),
(297, 1, 'Remember: All Email Going to the Receiver from this Email', 'Remember: All Email Going to the Receiver from this Email', '2018-01-27 10:04:34', '2018-01-27 10:04:34'),
(298, 1, 'Footer Text', 'Footer Text', '2018-01-27 10:04:34', '2018-01-27 10:04:34'),
(299, 1, 'Application Logo', 'Application Logo', '2018-01-27 10:04:34', '2018-01-27 10:04:34'),
(300, 1, 'Application Favicon', 'Application Favicon', '2018-01-27 10:04:34', '2018-01-27 10:04:34'),
(301, 1, 'API Permission', 'API Permission', '2018-01-27 10:04:34', '2018-01-27 10:04:34'),
(302, 1, 'Allow Client Registration', 'Allow Client Registration', '2018-01-27 10:04:34', '2018-01-27 10:04:34'),
(303, 1, 'Client Registration Verification', 'Client Registration Verification', '2018-01-27 10:04:34', '2018-01-27 10:04:34'),
(304, 1, 'Email Gateway', 'Email Gateway', '2018-01-27 10:04:34', '2018-01-27 10:04:34'),
(305, 1, 'Server Default', 'Server Default', '2018-01-27 10:04:34', '2018-01-27 10:04:34'),
(306, 1, 'SMTP', 'SMTP', '2018-01-27 10:04:34', '2018-01-27 10:04:34'),
(307, 1, 'Host Name', 'Host Name', '2018-01-27 10:04:34', '2018-01-27 10:04:34'),
(308, 1, 'Port', 'Port', '2018-01-27 10:04:34', '2018-01-27 10:04:34'),
(309, 1, 'Secure', 'Secure', '2018-01-27 10:04:34', '2018-01-27 10:04:34'),
(310, 1, 'TLS', 'TLS', '2018-01-27 10:04:34', '2018-01-27 10:04:34'),
(311, 1, 'SSL', 'SSL', '2018-01-27 10:04:34', '2018-01-27 10:04:34'),
(312, 1, 'Mark As', 'Mark As', '2018-01-27 10:04:34', '2018-01-27 10:04:34'),
(313, 1, 'Preview', 'Preview', '2018-01-27 10:04:34', '2018-01-27 10:04:34'),
(314, 1, 'PDF', 'PDF', '2018-01-27 10:04:34', '2018-01-27 10:04:34'),
(315, 1, 'Print', 'Print', '2018-01-27 10:04:35', '2018-01-27 10:04:35'),
(316, 1, 'Ticket Management', 'Ticket Management', '2018-01-27 10:04:35', '2018-01-27 10:04:35'),
(317, 1, 'Ticket Details', 'Ticket Details', '2018-01-27 10:04:35', '2018-01-27 10:04:35'),
(318, 1, 'Ticket Discussion', 'Ticket Discussion', '2018-01-27 10:04:35', '2018-01-27 10:04:35'),
(319, 1, 'Ticket Files', 'Ticket Files', '2018-01-27 10:04:35', '2018-01-27 10:04:35'),
(320, 1, 'Created Date', 'Created Date', '2018-01-27 10:04:35', '2018-01-27 10:04:35'),
(321, 1, 'Created By', 'Created By', '2018-01-27 10:04:35', '2018-01-27 10:04:35'),
(322, 1, 'Department', 'Department', '2018-01-27 10:04:35', '2018-01-27 10:04:35'),
(323, 1, 'Closed By', 'Closed By', '2018-01-27 10:04:35', '2018-01-27 10:04:35'),
(324, 1, 'File Title', 'File Title', '2018-01-27 10:04:35', '2018-01-27 10:04:35'),
(325, 1, 'Select File', 'Select File', '2018-01-27 10:04:35', '2018-01-27 10:04:35'),
(326, 1, 'Files', 'Files', '2018-01-27 10:04:35', '2018-01-27 10:04:35'),
(327, 1, 'Size', 'Size', '2018-01-27 10:04:35', '2018-01-27 10:04:35'),
(328, 1, 'Upload By', 'Upload By', '2018-01-27 10:04:35', '2018-01-27 10:04:35'),
(329, 1, 'Upload', 'Upload', '2018-01-27 10:04:35', '2018-01-27 10:04:35'),
(330, 1, 'Dashboard', 'Dashboard', '2018-01-27 10:04:35', '2018-01-27 10:04:35'),
(331, 1, 'Settings', 'Settings', '2018-01-27 10:04:35', '2018-01-27 10:04:35'),
(332, 1, 'Logout', 'Logout', '2018-01-27 10:04:35', '2018-01-27 10:04:35'),
(333, 1, 'Recent 5 Unpaid Invoices', 'Recent 5 Unpaid Invoices', '2018-01-27 10:04:35', '2018-01-27 10:04:35'),
(334, 1, 'See All Invoices', 'See All Invoices', '2018-01-27 10:04:35', '2018-01-27 10:04:35'),
(335, 1, 'Recent 5 Pending Tickets', 'Recent 5 Pending Tickets', '2018-01-27 10:04:35', '2018-01-27 10:04:35'),
(336, 1, 'See All Tickets', 'See All Tickets', '2018-01-27 10:04:36', '2018-01-27 10:04:36'),
(337, 1, 'Update Profile', 'Update Profile', '2018-01-27 10:04:36', '2018-01-27 10:04:36'),
(338, 1, 'You do not have permission to view this page', 'You do not have permission to view this page', '2018-01-27 10:04:36', '2018-01-27 10:04:36'),
(339, 1, 'This Option is Disable In Demo Mode', 'This Option is Disable In Demo Mode', '2018-01-27 10:04:36', '2018-01-27 10:04:36'),
(340, 1, 'User name already exist', 'User name already exist', '2018-01-27 10:04:36', '2018-01-27 10:04:36'),
(341, 1, 'Email already exist', 'Email already exist', '2018-01-27 10:04:36', '2018-01-27 10:04:36'),
(342, 1, 'Both password does not match', 'Both password does not match', '2018-01-27 10:04:36', '2018-01-27 10:04:36'),
(343, 1, 'Administrator added successfully', 'Administrator added successfully', '2018-01-27 10:04:36', '2018-01-27 10:04:36'),
(344, 1, 'Administrator not found', 'Administrator not found', '2018-01-27 10:04:36', '2018-01-27 10:04:36'),
(345, 1, 'Administrator updated successfully', 'Administrator updated successfully', '2018-01-27 10:04:36', '2018-01-27 10:04:36'),
(346, 1, 'Administrator have support tickets. First delete support ticket', 'Administrator have support tickets. First delete support ticket', '2018-01-27 10:04:36', '2018-01-27 10:04:36'),
(347, 1, 'Administrator have SMS Log. First delete all sms', 'Administrator have SMS Log. First delete all sms', '2018-01-27 10:04:36', '2018-01-27 10:04:36'),
(348, 1, 'Administrator created invoice. First delete all invoice', 'Administrator created invoice. First delete all invoice', '2018-01-27 10:04:36', '2018-01-27 10:04:36'),
(349, 1, 'Administrator delete successfully', 'Administrator delete successfully', '2018-01-27 10:04:36', '2018-01-27 10:04:36'),
(350, 1, 'Administrator Role added successfully', 'Administrator Role added successfully', '2018-01-27 10:04:36', '2018-01-27 10:04:36'),
(351, 1, 'Administrator Role already exist', 'Administrator Role already exist', '2018-01-27 10:04:36', '2018-01-27 10:04:36'),
(352, 1, 'Administrator Role updated successfully', 'Administrator Role updated successfully', '2018-01-27 10:04:36', '2018-01-27 10:04:36'),
(353, 1, 'Administrator Role info not found', 'Administrator Role info not found', '2018-01-27 10:04:36', '2018-01-27 10:04:36'),
(354, 1, 'Permission not assigned', 'Permission not assigned', '2018-01-27 10:04:36', '2018-01-27 10:04:36'),
(355, 1, 'Permission Updated', 'Permission Updated', '2018-01-27 10:04:36', '2018-01-27 10:04:36'),
(356, 1, 'An Administrator contain this role', 'An Administrator contain this role', '2018-01-27 10:04:37', '2018-01-27 10:04:37'),
(357, 1, 'Administrator role deleted successfully', 'Administrator role deleted successfully', '2018-01-27 10:04:37', '2018-01-27 10:04:37'),
(358, 1, 'Invalid User name or Password', 'Invalid User name or Password', '2018-01-27 10:04:37', '2018-01-27 10:04:37'),
(359, 1, 'Please Check your Email Settings', 'Please Check your Email Settings', '2018-01-27 10:04:37', '2018-01-27 10:04:37'),
(360, 1, 'Password Reset Successfully. Please check your email', 'Password Reset Successfully. Please check your email', '2018-01-27 10:04:37', '2018-01-27 10:04:37'),
(361, 1, 'Your Password Already Reset. Please Check your email', 'Your Password Already Reset. Please Check your email', '2018-01-27 10:04:37', '2018-01-27 10:04:37'),
(362, 1, 'Sorry There is no registered user with this email address', 'Sorry There is no registered user with this email address', '2018-01-27 10:04:37', '2018-01-27 10:04:37'),
(363, 1, 'A New Password Generated. Please Check your email.', 'A New Password Generated. Please Check your email.', '2018-01-27 10:04:37', '2018-01-27 10:04:37'),
(364, 1, 'Sorry Password reset Token expired or not exist, Please try again.', 'Sorry Password reset Token expired or not exist, Please try again.', '2018-01-27 10:04:37', '2018-01-27 10:04:37'),
(365, 1, 'Client Added Successfully But Email Not Send', 'Client Added Successfully But Email Not Send', '2018-01-27 10:04:37', '2018-01-27 10:04:37'),
(366, 1, 'Client Added Successfully', 'Client Added Successfully', '2018-01-27 10:04:37', '2018-01-27 10:04:37'),
(367, 1, 'Client info not found', 'Client info not found', '2018-01-27 10:04:37', '2018-01-27 10:04:37'),
(368, 1, 'Limit updated successfully', 'Limit updated successfully', '2018-01-27 10:04:37', '2018-01-27 10:04:37'),
(369, 1, 'Image updated successfully', 'Image updated successfully', '2018-01-27 10:04:37', '2018-01-27 10:04:37'),
(370, 1, 'Please try again', 'Please try again', '2018-01-27 10:04:37', '2018-01-27 10:04:37'),
(371, 1, 'Client updated successfully', 'Client updated successfully', '2018-01-27 10:04:37', '2018-01-27 10:04:37'),
(372, 1, 'SMS gateway not active', 'SMS gateway not active', '2018-01-27 10:04:38', '2018-01-27 10:04:38'),
(373, 1, 'Please check sms history', 'Please check sms history', '2018-01-27 10:04:38', '2018-01-27 10:04:38'),
(374, 1, 'Insert Valid Excel or CSV file', 'Insert Valid Excel or CSV file', '2018-01-27 10:04:38', '2018-01-27 10:04:38'),
(375, 1, 'Client imported successfully', 'Client imported successfully', '2018-01-27 10:04:38', '2018-01-27 10:04:38'),
(376, 1, 'Client Group added successfully', 'Client Group added successfully', '2018-01-27 10:04:38', '2018-01-27 10:04:38'),
(377, 1, 'Client Group updated successfully', 'Client Group updated successfully', '2018-01-27 10:04:38', '2018-01-27 10:04:38'),
(378, 1, 'Client Group not found', 'Client Group not found', '2018-01-27 10:04:38', '2018-01-27 10:04:38'),
(379, 1, 'This Group exist in a client', 'This Group exist in a client', '2018-01-27 10:04:38', '2018-01-27 10:04:38'),
(380, 1, 'Client group deleted successfully', 'Client group deleted successfully', '2018-01-27 10:04:38', '2018-01-27 10:04:38'),
(381, 1, 'Invoice not found', 'Invoice not found', '2018-01-27 10:04:38', '2018-01-27 10:04:38'),
(382, 1, 'Logout Successfully', 'Logout Successfully', '2018-01-27 10:04:38', '2018-01-27 10:04:38'),
(383, 1, 'Profile Updated Successfully', 'Profile Updated Successfully', '2018-01-27 10:04:38', '2018-01-27 10:04:38'),
(384, 1, 'Upload an Image', 'Upload an Image', '2018-01-27 10:04:38', '2018-01-27 10:04:38'),
(385, 1, 'Password Change Successfully', 'Password Change Successfully', '2018-01-27 10:04:38', '2018-01-27 10:04:38'),
(386, 1, 'Current Password Does Not Match', 'Current Password Does Not Match', '2018-01-27 10:04:38', '2018-01-27 10:04:38'),
(387, 1, 'Select a Customer', 'Select a Customer', '2018-01-27 10:04:38', '2018-01-27 10:04:38'),
(388, 1, 'Invoice Created date is required', 'Invoice Created date is required', '2018-01-27 10:04:38', '2018-01-27 10:04:38'),
(389, 1, 'Invoice Paid date is required', 'Invoice Paid date is required', '2018-01-27 10:04:38', '2018-01-27 10:04:38'),
(390, 1, 'Date Parsing Error', 'Date Parsing Error', '2018-01-27 10:04:38', '2018-01-27 10:04:38'),
(391, 1, 'Invoice Due date is required', 'Invoice Due date is required', '2018-01-27 10:04:39', '2018-01-27 10:04:39'),
(392, 1, 'At least one item is required', 'At least one item is required', '2018-01-27 10:04:39', '2018-01-27 10:04:39'),
(393, 1, 'Invoice Updated Successfully', 'Invoice Updated Successfully', '2018-01-27 10:04:39', '2018-01-27 10:04:39'),
(394, 1, 'Invoice Marked as Paid', 'Invoice Marked as Paid', '2018-01-27 10:04:39', '2018-01-27 10:04:39'),
(395, 1, 'Invoice Marked as Unpaid', 'Invoice Marked as Unpaid', '2018-01-27 10:04:39', '2018-01-27 10:04:39'),
(396, 1, 'Invoice Marked as Partially Paid', 'Invoice Marked as Partially Paid', '2018-01-27 10:04:39', '2018-01-27 10:04:39'),
(397, 1, 'Invoice Marked as Cancelled', 'Invoice Marked as Cancelled', '2018-01-27 10:04:39', '2018-01-27 10:04:39'),
(398, 1, 'Invoice Send Successfully', 'Invoice Send Successfully', '2018-01-27 10:04:39', '2018-01-27 10:04:39'),
(399, 1, 'Invoice deleted successfully', 'Invoice deleted successfully', '2018-01-27 10:04:39', '2018-01-27 10:04:39'),
(400, 1, 'Stop Recurring Invoice Successfully', 'Stop Recurring Invoice Successfully', '2018-01-27 10:04:39', '2018-01-27 10:04:39'),
(401, 1, 'Invoice Created Successfully', 'Invoice Created Successfully', '2018-01-27 10:04:39', '2018-01-27 10:04:39'),
(402, 1, 'Reseller Panel', 'Reseller Panel', '2018-01-27 10:04:39', '2018-01-27 10:04:39'),
(403, 1, 'Captcha In Admin Login', 'Captcha In Admin Login', '2018-01-27 10:04:39', '2018-01-27 10:04:39'),
(404, 1, 'Captcha In Client Login', 'Captcha In Client Login', '2018-01-27 10:04:39', '2018-01-27 10:04:39'),
(405, 1, 'Captcha In Client Registration', 'Captcha In Client Registration', '2018-01-27 10:04:39', '2018-01-27 10:04:39'),
(406, 1, 'reCAPTCHA Site Key', 'reCAPTCHA Site Key', '2018-01-27 10:04:39', '2018-01-27 10:04:39'),
(407, 1, 'reCAPTCHA Secret Key', 'reCAPTCHA Secret Key', '2018-01-27 10:04:39', '2018-01-27 10:04:39'),
(408, 1, 'Registration Successful', 'Registration Successful', '2018-01-27 10:04:40', '2018-01-27 10:04:40'),
(409, 1, 'Payment gateway required', 'Payment gateway required', '2018-01-27 10:04:40', '2018-01-27 10:04:40'),
(410, 1, 'Cancelled the Payment', 'Cancelled the Payment', '2018-01-27 10:04:40', '2018-01-27 10:04:40'),
(411, 1, 'Invoice paid successfully', 'Invoice paid successfully', '2018-01-27 10:04:40', '2018-01-27 10:04:40'),
(412, 1, 'Purchase successfully.Wait for administrator response', 'Purchase successfully.Wait for administrator response', '2018-01-27 10:04:40', '2018-01-27 10:04:40'),
(413, 1, 'SMS Not Found', 'SMS Not Found', '2018-01-27 10:04:40', '2018-01-27 10:04:40'),
(414, 1, 'SMS info deleted successfully', 'SMS info deleted successfully', '2018-01-27 10:04:40', '2018-01-27 10:04:40'),
(415, 1, 'Setting Update Successfully', 'Setting Update Successfully', '2018-01-27 10:04:40', '2018-01-27 10:04:40'),
(416, 1, 'Email Template Not Found', 'Email Template Not Found', '2018-01-27 10:04:40', '2018-01-27 10:04:40'),
(417, 1, 'Email Template Update Successfully', 'Email Template Update Successfully', '2018-01-27 10:04:40', '2018-01-27 10:04:40'),
(418, 1, 'Payment Gateway not found', 'Payment Gateway not found', '2018-01-27 10:04:40', '2018-01-27 10:04:40'),
(419, 1, 'Payment Gateway update successfully', 'Payment Gateway update successfully', '2018-01-27 10:04:40', '2018-01-27 10:04:40'),
(420, 1, 'Language Already Exist', 'Language Already Exist', '2018-01-27 10:04:40', '2018-01-27 10:04:40'),
(421, 1, 'Language Added Successfully', 'Language Added Successfully', '2018-01-27 10:04:40', '2018-01-27 10:04:40'),
(422, 1, 'Language Translate Successfully', 'Language Translate Successfully', '2018-01-27 10:04:40', '2018-01-27 10:04:40'),
(423, 1, 'Language not found', 'Language not found', '2018-01-27 10:04:40', '2018-01-27 10:04:40'),
(424, 1, 'Language updated Successfully', 'Language updated Successfully', '2018-01-27 10:04:40', '2018-01-27 10:04:40'),
(425, 1, 'Can not delete active language', 'Can not delete active language', '2018-01-27 10:04:40', '2018-01-27 10:04:40'),
(426, 1, 'Language deleted successfully', 'Language deleted successfully', '2018-01-27 10:04:40', '2018-01-27 10:04:40'),
(427, 1, 'Information not found', 'Information not found', '2018-01-27 10:04:40', '2018-01-27 10:04:40'),
(428, 1, 'Coverage updated successfully', 'Coverage updated successfully', '2018-01-27 10:04:40', '2018-01-27 10:04:40'),
(429, 1, 'Sender Id added successfully', 'Sender Id added successfully', '2018-01-27 10:04:41', '2018-01-27 10:04:41'),
(430, 1, 'Sender Id not found', 'Sender Id not found', '2018-01-27 10:04:41', '2018-01-27 10:04:41'),
(431, 1, 'Sender id updated successfully', 'Sender id updated successfully', '2018-01-27 10:04:41', '2018-01-27 10:04:41'),
(432, 1, 'Sender id deleted successfully', 'Sender id deleted successfully', '2018-01-27 10:04:41', '2018-01-27 10:04:41'),
(433, 1, 'Plan already exist', 'Plan already exist', '2018-01-27 10:04:41', '2018-01-27 10:04:41'),
(434, 1, 'Plan added successfully', 'Plan added successfully', '2018-01-27 10:04:41', '2018-01-27 10:04:41'),
(435, 1, 'Plan not found', 'Plan not found', '2018-01-27 10:04:41', '2018-01-27 10:04:41'),
(436, 1, 'Plan updated successfully', 'Plan updated successfully', '2018-01-27 10:04:41', '2018-01-27 10:04:41'),
(437, 1, 'Plan features added successfully', 'Plan features added successfully', '2018-01-27 10:04:41', '2018-01-27 10:04:41'),
(438, 1, 'Plan feature not found', 'Plan feature not found', '2018-01-27 10:04:41', '2018-01-27 10:04:41'),
(439, 1, 'Feature already exist', 'Feature already exist', '2018-01-27 10:04:41', '2018-01-27 10:04:41'),
(440, 1, 'Feature updated successfully', 'Feature updated successfully', '2018-01-27 10:04:41', '2018-01-27 10:04:41'),
(441, 1, 'Plan feature deleted successfully', 'Plan feature deleted successfully', '2018-01-27 10:04:41', '2018-01-27 10:04:41'),
(442, 1, 'Price Plan deleted successfully', 'Price Plan deleted successfully', '2018-01-27 10:04:41', '2018-01-27 10:04:41'),
(443, 1, 'Gateway already exist', 'Gateway already exist', '2018-01-27 10:04:41', '2018-01-27 10:04:41'),
(444, 1, 'Custom gateway added successfully', 'Custom gateway added successfully', '2018-01-27 10:04:41', '2018-01-27 10:04:41'),
(445, 1, 'Parameter or Value is empty', 'Parameter or Value is empty', '2018-01-27 10:04:41', '2018-01-27 10:04:41'),
(446, 1, 'Gateway information not found', 'Gateway information not found', '2018-01-27 10:04:41', '2018-01-27 10:04:41'),
(447, 1, 'Gateway name required', 'Gateway name required', '2018-01-27 10:04:41', '2018-01-27 10:04:41'),
(448, 1, 'Custom gateway updated successfully', 'Custom gateway updated successfully', '2018-01-27 10:04:41', '2018-01-27 10:04:41'),
(449, 1, 'Client are registered with this gateway', 'Client are registered with this gateway', '2018-01-27 10:04:41', '2018-01-27 10:04:41'),
(450, 1, 'Gateway deleted successfully', 'Gateway deleted successfully', '2018-01-27 10:04:42', '2018-01-27 10:04:42'),
(451, 1, 'Delete option disable for this gateway', 'Delete option disable for this gateway', '2018-01-27 10:04:42', '2018-01-27 10:04:42'),
(452, 1, 'SMS added in queue and will deliver one by one', 'SMS added in queue and will deliver one by one', '2018-01-27 10:04:42', '2018-01-27 10:04:42'),
(453, 1, 'Insert Valid Excel or CSV file', 'Insert Valid Excel or CSV file', '2018-01-27 10:04:42', '2018-01-27 10:04:42'),
(454, 1, 'SMS are scheduled. Deliver in correct time', 'SMS are scheduled. Deliver in correct time', '2018-01-27 10:04:42', '2018-01-27 10:04:42'),
(455, 1, 'Template already exist', 'Template already exist', '2018-01-27 10:04:42', '2018-01-27 10:04:42'),
(456, 1, 'Sms template created successfully', 'Sms template created successfully', '2018-01-27 10:04:42', '2018-01-27 10:04:42'),
(457, 1, 'Sms template not found', 'Sms template not found', '2018-01-27 10:04:42', '2018-01-27 10:04:42'),
(458, 1, 'Sms template updated successfully', 'Sms template updated successfully', '2018-01-27 10:04:42', '2018-01-27 10:04:42'),
(459, 1, 'Sms template delete successfully', 'Sms template delete successfully', '2018-01-27 10:04:42', '2018-01-27 10:04:42'),
(460, 1, 'API information updated successfully', 'API information updated successfully', '2018-01-27 10:04:42', '2018-01-27 10:04:42'),
(461, 1, 'Invalid Access', 'Invalid Access', '2018-01-27 10:04:42', '2018-01-27 10:04:42'),
(462, 1, 'Invalid Captcha', 'Invalid Captcha', '2018-01-27 10:04:42', '2018-01-27 10:04:42'),
(463, 1, 'Invalid Request', 'Invalid Request', '2018-01-27 10:04:42', '2018-01-27 10:04:42'),
(464, 1, 'Verification code send successfully. Please check your email', 'Verification code send successfully. Please check your email', '2018-01-27 10:04:42', '2018-01-27 10:04:42'),
(465, 1, 'Something wrong, Please contact with your provider', 'Something wrong, Please contact with your provider', '2018-01-27 10:04:42', '2018-01-27 10:04:42'),
(466, 1, 'Verification code not found', 'Verification code not found', '2018-01-27 10:04:42', '2018-01-27 10:04:42'),
(467, 1, 'Department Already exist', 'Department Already exist', '2018-01-27 10:04:42', '2018-01-27 10:04:42'),
(468, 1, 'Department Added Successfully', 'Department Added Successfully', '2018-01-27 10:04:42', '2018-01-27 10:04:42'),
(469, 1, 'Department Updated Successfully', 'Department Updated Successfully', '2018-01-27 10:04:43', '2018-01-27 10:04:43'),
(470, 1, 'Support Ticket Created Successfully But Email Not Send', 'Support Ticket Created Successfully But Email Not Send', '2018-01-27 10:04:43', '2018-01-27 10:04:43'),
(471, 1, 'Support Ticket Created Successfully', 'Support Ticket Created Successfully', '2018-01-27 10:04:43', '2018-01-27 10:04:43'),
(472, 1, 'Basic Info Update Successfully', 'Basic Info Update Successfully', '2018-01-27 10:04:43', '2018-01-27 10:04:43'),
(473, 1, 'Ticket Reply Successfully But Email Not Send', 'Ticket Reply Successfully But Email Not Send', '2018-01-27 10:04:43', '2018-01-27 10:04:43'),
(474, 1, 'Ticket Reply Successfully', 'Ticket Reply Successfully', '2018-01-27 10:04:43', '2018-01-27 10:04:43'),
(475, 1, 'File Uploaded Successfully', 'File Uploaded Successfully', '2018-01-27 10:04:43', '2018-01-27 10:04:43'),
(476, 1, 'Please Upload a File', 'Please Upload a File', '2018-01-27 10:04:43', '2018-01-27 10:04:43'),
(477, 1, 'File Deleted Successfully', 'File Deleted Successfully', '2018-01-27 10:04:43', '2018-01-27 10:04:43'),
(478, 1, 'Ticket File not found', 'Ticket File not found', '2018-01-27 10:04:43', '2018-01-27 10:04:43'),
(479, 1, 'Ticket Deleted Successfully', 'Ticket Deleted Successfully', '2018-01-27 10:04:43', '2018-01-27 10:04:43'),
(480, 1, 'Ticket info not found', 'Ticket info not found', '2018-01-27 10:04:43', '2018-01-27 10:04:43'),
(481, 1, 'Department Deleted Successfully', 'Department Deleted Successfully', '2018-01-27 10:04:43', '2018-01-27 10:04:43'),
(482, 1, 'There Have no Department For Delete', 'There Have no Department For Delete', '2018-01-27 10:04:43', '2018-01-27 10:04:43'),
(483, 1, 'You do not have enough sms balance', 'You do not have enough sms balance', '2018-01-27 10:04:43', '2018-01-27 10:04:43'),
(484, 1, 'SMS gateway not active.Contact with Provider', 'SMS gateway not active.Contact with Provider', '2018-01-27 10:04:43', '2018-01-27 10:04:43'),
(485, 1, 'Sender ID required', 'Sender ID required', '2018-01-27 10:04:43', '2018-01-27 10:04:43'),
(486, 1, 'Request send successfully', 'Request send successfully', '2018-01-27 10:04:43', '2018-01-27 10:04:43'),
(487, 1, 'This Sender ID have Blocked By Administrator', 'This Sender ID have Blocked By Administrator', '2018-01-27 10:04:43', '2018-01-27 10:04:43'),
(488, 1, 'Phone Number Coverage are not active', 'Phone Number Coverage are not active', '2018-01-27 10:04:43', '2018-01-27 10:04:43'),
(489, 1, 'SMS plan not found', 'SMS plan not found', '2018-01-27 10:04:44', '2018-01-27 10:04:44'),
(490, 1, 'Schedule feature not supported', 'Schedule feature not supported', '2018-01-27 10:04:44', '2018-01-27 10:04:44'),
(491, 1, 'Need Account', 'Need Account', '2018-01-27 10:04:44', '2018-01-27 10:04:44'),
(492, 1, 'Sign up', 'Sign up', '2018-01-27 10:04:44', '2018-01-27 10:04:44'),
(493, 1, 'here', 'here', '2018-01-27 10:04:44', '2018-01-27 10:04:44'),
(494, 1, 'User Registration', 'User Registration', '2018-01-27 10:04:44', '2018-01-27 10:04:44'),
(495, 1, 'Already have an Account', 'Already have an Account', '2018-01-27 10:04:44', '2018-01-27 10:04:44'),
(496, 1, 'Request New Sender ID', 'Request New Sender ID', '2018-01-27 10:04:44', '2018-01-27 10:04:44'),
(497, 1, 'Purchase Now', 'Purchase Now', '2018-01-27 10:04:44', '2018-01-27 10:04:44'),
(498, 1, 'Purchase SMS Plan', 'Purchase SMS Plan', '2018-01-27 10:04:44', '2018-01-27 10:04:44'),
(499, 1, 'Select Payment Method', 'Select Payment Method', '2018-01-27 10:04:44', '2018-01-27 10:04:44'),
(500, 1, 'Pay with Credit Card', 'Pay with Credit Card', '2018-01-27 10:04:44', '2018-01-27 10:04:44'),
(501, 1, 'User Registration Verification', 'User Registration Verification', '2018-01-27 10:04:44', '2018-01-27 10:04:44'),
(502, 1, 'Verify Your Account', 'Verify Your Account', '2018-01-27 10:04:44', '2018-01-27 10:04:44'),
(503, 1, 'Send Verification Email', 'Send Verification Email', '2018-01-27 10:04:44', '2018-01-27 10:04:44'),
(504, 1, 'Pay', 'Pay', '2018-01-27 10:04:44', '2018-01-27 10:04:44'),
(505, 1, 'Pay Invoice', 'Pay Invoice', '2018-01-27 10:04:44', '2018-01-27 10:04:44'),
(506, 1, 'Reply Ticket', 'Reply Ticket', '2018-01-27 10:04:44', '2018-01-27 10:04:44'),
(507, 1, 'Whoops! Page Not Found, Go To', 'Whoops! Page Not Found, Go To', '2018-01-27 10:04:44', '2018-01-27 10:04:44'),
(508, 1, 'Home Page', 'Home Page', '2018-01-27 10:04:45', '2018-01-27 10:04:45'),
(509, 1, 'Error', 'Error', '2018-01-27 10:04:45', '2018-01-27 10:04:45'),
(510, 1, 'Client contain in', 'Client contain in', '2018-01-27 10:04:45', '2018-01-27 10:04:45'),
(511, 1, 'Client sms limit not empty', 'Client sms limit not empty', '2018-01-27 10:04:45', '2018-01-27 10:04:45'),
(512, 1, 'This client have some customer', 'This client have some customer', '2018-01-27 10:04:45', '2018-01-27 10:04:45'),
(513, 1, 'Client delete successfully', 'Client delete successfully', '2018-01-27 10:04:45', '2018-01-27 10:04:45'),
(514, 1, 'Client Group is empty', 'Client Group is empty', '2018-01-27 10:04:45', '2018-01-27 10:04:45');
INSERT INTO `sys_language_data` (`id`, `lan_id`, `lan_data`, `lan_value`, `created_at`, `updated_at`) VALUES
(515, 1, 'Country flag required', 'Country flag required', '2018-01-27 10:04:45', '2018-01-27 10:04:45'),
(516, 1, 'Single', 'Single', '2018-01-27 10:04:45', '2018-01-27 10:04:45'),
(517, 1, 'SMS', 'SMS', '2018-01-27 10:04:45', '2018-01-27 10:04:45'),
(518, 1, 'Client ID', 'Client ID', '2018-01-27 10:04:45', '2018-01-27 10:04:45'),
(519, 1, 'Client Secret', 'Client Secret', '2018-01-27 10:04:45', '2018-01-27 10:04:45'),
(520, 1, 'Import Phone Number', 'Import Phone Number', '2018-01-27 10:04:45', '2018-01-27 10:04:45'),
(521, 1, 'Sender ID Verification', 'Sender ID Verification', '2018-01-27 10:04:45', '2018-01-27 10:04:45'),
(522, 1, 'Price Bundles', 'Price Bundles', '2018-01-27 10:04:45', '2018-01-27 10:04:45'),
(523, 1, 'Unit From', 'Unit From', '2018-01-27 10:04:45', '2018-01-27 10:04:45'),
(524, 1, 'Unit To', 'Unit To', '2018-01-27 10:04:45', '2018-01-27 10:04:45'),
(525, 1, 'Transaction Fee', 'Transaction Fee', '2018-01-27 10:04:45', '2018-01-27 10:04:45'),
(526, 1, 'Price Bundles Update Successfully', 'Price Bundles Update Successfully', '2018-01-27 10:04:45', '2018-01-27 10:04:45'),
(527, 1, 'Buy Unit', 'Buy Unit', '2018-01-27 10:04:45', '2018-01-27 10:04:45'),
(528, 1, 'Recharge your account Online', 'Recharge your account Online', '2018-01-27 10:04:45', '2018-01-27 10:04:45'),
(529, 1, 'Number of Units', 'Number of Units', '2018-01-27 10:04:46', '2018-01-27 10:04:46'),
(530, 1, 'Unit Price', 'Unit Price', '2018-01-27 10:04:46', '2018-01-27 10:04:46'),
(531, 1, 'Amount to Pay', 'Amount to Pay', '2018-01-27 10:04:46', '2018-01-27 10:04:46'),
(532, 1, 'Price Per Unit', 'Price Per Unit', '2018-01-27 10:04:46', '2018-01-27 10:04:46'),
(533, 1, 'Contacts', 'Contacts', '2018-01-27 10:04:46', '2018-01-27 10:04:46'),
(534, 1, 'Phone Book', 'Phone Book', '2018-01-27 10:04:46', '2018-01-27 10:04:46'),
(535, 1, 'Import Contacts', 'Import Contacts', '2018-01-27 10:04:46', '2018-01-27 10:04:46'),
(536, 1, 'Blacklist Contacts', 'Blacklist Contacts', '2018-01-27 10:04:46', '2018-01-27 10:04:46'),
(537, 1, 'Recharge', 'Recharge', '2018-01-27 10:04:46', '2018-01-27 10:04:46'),
(538, 1, 'Reports', 'Reports', '2018-01-27 10:04:46', '2018-01-27 10:04:46'),
(539, 1, 'Add New List', 'Add New List', '2018-01-27 10:04:46', '2018-01-27 10:04:46'),
(540, 1, 'List name', 'List name', '2018-01-27 10:04:46', '2018-01-27 10:04:46'),
(541, 1, 'View Contacts', 'View Contacts', '2018-01-27 10:04:46', '2018-01-27 10:04:46'),
(542, 1, 'Add Contact', 'Add Contact', '2018-01-27 10:04:46', '2018-01-27 10:04:46'),
(543, 1, 'Add New Contact', 'Add New Contact', '2018-01-27 10:04:46', '2018-01-27 10:04:46'),
(544, 1, 'Edit List', 'Edit List', '2018-01-27 10:04:46', '2018-01-27 10:04:46'),
(545, 1, 'Import Contact By File', 'Import Contact By File', '2018-01-27 10:04:46', '2018-01-27 10:04:46'),
(546, 1, 'First Row As Header', 'First Row As Header', '2018-01-27 10:04:46', '2018-01-27 10:04:46'),
(547, 1, 'Column', 'Column', '2018-01-27 10:04:46', '2018-01-27 10:04:46'),
(548, 1, 'Import List into', 'Import List into', '2018-01-27 10:04:46', '2018-01-27 10:04:46'),
(549, 1, 'Import By Numbers', 'Import By Numbers', '2018-01-27 10:04:47', '2018-01-27 10:04:47'),
(550, 1, 'Paste Numbers', 'Paste Numbers', '2018-01-27 10:04:47', '2018-01-27 10:04:47'),
(551, 1, 'Insert number with comma', 'Insert number with comma', '2018-01-27 10:04:47', '2018-01-27 10:04:47'),
(552, 1, 'Numbers', 'Numbers', '2018-01-27 10:04:47', '2018-01-27 10:04:47'),
(553, 1, 'Select Contact Type', 'Select Contact Type', '2018-01-27 10:04:47', '2018-01-27 10:04:47'),
(554, 1, 'Contact List', 'Contact List', '2018-01-27 10:04:47', '2018-01-27 10:04:47'),
(555, 1, 'Recipients', 'Recipients', '2018-01-27 10:04:47', '2018-01-27 10:04:47'),
(556, 1, 'Send Later', 'Send Later', '2018-01-27 10:04:47', '2018-01-27 10:04:47'),
(557, 1, 'Total Number Of Recipients', 'Total Number Of Recipients', '2018-01-27 10:04:47', '2018-01-27 10:04:47'),
(558, 1, 'Direction', 'Direction', '2018-01-27 10:04:47', '2018-01-27 10:04:47'),
(559, 1, 'To', 'To', '2018-01-27 10:04:47', '2018-01-27 10:04:47'),
(560, 1, 'Segments', 'Segments', '2018-01-27 10:04:47', '2018-01-27 10:04:47'),
(561, 1, 'Incoming', 'Incoming', '2018-01-27 10:04:47', '2018-01-27 10:04:47'),
(562, 1, 'Outgoing', 'Outgoing', '2018-01-27 10:04:47', '2018-01-27 10:04:47'),
(563, 1, 'Message Details', 'Message Details', '2018-01-27 10:04:47', '2018-01-27 10:04:47'),
(564, 1, 'Sending User', 'Sending User', '2018-01-27 10:04:47', '2018-01-27 10:04:47'),
(565, 1, 'Created At', 'Created At', '2018-01-27 10:04:47', '2018-01-27 10:04:47'),
(566, 1, 'Background Jobs', 'Background Jobs', '2018-01-27 10:04:47', '2018-01-27 10:04:47'),
(567, 1, 'Please specify the PHP executable path on your system', 'Please specify the PHP executable path on your system', '2018-01-27 10:04:48', '2018-01-27 10:04:48'),
(568, 1, 'Edit Contact', 'Edit Contact', '2018-01-27 10:04:48', '2018-01-27 10:04:48'),
(569, 1, 'Bulk Delete', 'Bulk Delete', '2018-01-27 10:04:48', '2018-01-27 10:04:48'),
(570, 1, 'File Uploading.. Please wait', 'File Uploading.. Please wait', '2018-01-27 10:04:48', '2018-01-27 10:04:48'),
(571, 1, 'Contact importing.. Please wait', 'Contact importing.. Please wait', '2018-01-27 10:04:48', '2018-01-27 10:04:48'),
(572, 1, 'Send Quick SMS', 'Send Quick SMS', '2018-01-27 10:04:48', '2018-01-27 10:04:48'),
(573, 1, 'Remove Duplicate', 'Remove Duplicate', '2018-01-27 10:04:48', '2018-01-27 10:04:48'),
(574, 1, 'Message Type', 'Message Type', '2018-01-27 10:04:48', '2018-01-27 10:04:48'),
(575, 1, 'Plain', 'Plain', '2018-01-27 10:04:48', '2018-01-27 10:04:48'),
(576, 1, 'Unicode', 'Unicode', '2018-01-27 10:04:48', '2018-01-27 10:04:48'),
(577, 1, 'Message adding in Queue.. Please wait', 'Message adding in Queue.. Please wait', '2018-01-27 10:04:48', '2018-01-27 10:04:48'),
(578, 1, 'Purchase Code', 'Purchase Code', '2018-01-27 10:04:48', '2018-01-27 10:04:48'),
(579, 1, 'Search Condition', 'Search Condition', '2018-01-27 10:04:48', '2018-01-27 10:04:48'),
(580, 1, 'Receive SMS', 'Receive SMS', '2018-01-27 10:04:48', '2018-01-27 10:04:48'),
(581, 1, 'API SMS', 'API SMS', '2018-01-27 10:04:48', '2018-01-27 10:04:48'),
(582, 1, 'Search', 'Search', '2018-01-27 10:04:48', '2018-01-27 10:04:48');

-- --------------------------------------------------------

--
-- Table structure for table `sys_payment_gateways`
--

CREATE TABLE `sys_payment_gateways` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci NOT NULL,
  `settings` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `extra_value` text COLLATE utf8_unicode_ci,
  `password` text COLLATE utf8_unicode_ci,
  `status` enum('Active','Inactive') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `sys_payment_gateways`
--

INSERT INTO `sys_payment_gateways` (`id`, `name`, `value`, `settings`, `extra_value`, `password`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Paypal', 'apiemail@paypal.com', 'paypal', 'api_secret', 'api_password', 'Active', '2018-01-27 10:04:04', '2018-01-27 10:04:04'),
(2, 'Stripe', 'pk_test_ARblMczqDw61NusMMs7o1RVK', 'stripe', 'sk_test_BQokikJOvBiI2HlWgH4olfQ2', NULL, 'Active', '2018-01-27 10:04:04', '2018-01-27 10:04:04'),
(3, '2CheckOut', 'Client_ID', '2checkout', '', NULL, 'Active', '2018-01-27 10:04:04', '2018-01-27 10:04:04'),
(4, 'Paystack', 'pk_test_25bdb768e32586e8d125b8eb8ddd71754296b310', 'paystack', 'sk_test_46823d69fa1990c3b1bfcb4b75ead975472164bf', NULL, 'Active', '2018-01-27 10:04:04', '2018-01-27 10:04:04'),
(5, 'PayU', '300046', 'payu', 'c8d4b7ac61758704f38ed5564d8c0ae0', NULL, 'Active', '2018-01-27 10:04:04', '2018-01-27 10:04:04'),
(6, 'Slydepay', 'merchantEmail', 'slydepay', 'merchantSecretKey', NULL, 'Active', '2018-01-27 10:04:04', '2018-01-27 10:04:04'),
(7, 'Paynow', 'Integration_ID', 'paynow', 'Integration_Key', NULL, 'Active', '2018-01-27 10:04:04', '2018-01-27 10:04:04'),
(8, 'Pagopar', 'public_key', 'pagopar', 'private_key', NULL, 'Active', '2018-01-27 10:04:04', '2018-01-27 10:04:04'),
(9, 'Bank', 'Make a Payment to Our Bank Account &lt;br&gt;Bank Name: Bank Name &lt;br&gt;Account Name: Account Holder Name &lt;br&gt;Account Number: Account Number &lt;br&gt;', 'manualpayment', '', NULL, 'Active', '2018-01-27 10:04:04', '2018-01-27 10:04:04');

-- --------------------------------------------------------

--
-- Table structure for table `sys_schedule_sms`
--

CREATE TABLE `sys_schedule_sms` (
  `id` int(10) UNSIGNED NOT NULL,
  `userid` int(11) NOT NULL,
  `sender` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `receiver` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `amount` int(11) NOT NULL,
  `message` text COLLATE utf8_unicode_ci NOT NULL,
  `use_gateway` int(11) NOT NULL,
  `type` enum('plain','unicode') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'plain',
  `submit_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sys_sender_id_management`
--

CREATE TABLE `sys_sender_id_management` (
  `id` int(10) UNSIGNED NOT NULL,
  `sender_id` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `cl_id` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `status` enum('pending','block','unblock') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'block',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sys_sms_bundles`
--

CREATE TABLE `sys_sms_bundles` (
  `id` int(10) UNSIGNED NOT NULL,
  `unit_from` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `unit_to` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `price` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `trans_fee` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sys_sms_gateways`
--

CREATE TABLE `sys_sms_gateways` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `api_link` longtext COLLATE utf8_unicode_ci,
  `username` longtext COLLATE utf8_unicode_ci NOT NULL,
  `password` longtext COLLATE utf8_unicode_ci,
  `api_id` longtext COLLATE utf8_unicode_ci,
  `schedule` enum('No','Yes') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Yes',
  `custom` enum('No','Yes') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'No',
  `type` enum('http','smpp') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'http',
  `status` enum('Active','Inactive') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Active',
  `two_way` enum('Yes','No') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Yes',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `sys_sms_gateways`
--

INSERT INTO `sys_sms_gateways` (`id`, `name`, `api_link`, `username`, `password`, `api_id`, `schedule`, `custom`, `type`, `status`, `two_way`, `created_at`, `updated_at`) VALUES
(1, 'Twilio', '', 'username', 'auth_token', '', 'Yes', 'No', 'http', 'Inactive', 'Yes', '2018-01-27 10:03:59', '2018-01-27 10:03:59'),
(2, 'Clickatell', 'http://api.clickatell.com', 'API_TOKEN', '', '', 'Yes', 'No', 'http', 'Inactive', 'Yes', '2018-01-27 10:04:00', '2018-01-27 10:04:00'),
(3, 'Asterisk', 'http://127.0.0.1', 'username', 'secret', '5038', 'Yes', 'No', 'http', 'Inactive', 'No', '2018-01-27 10:04:00', '2018-01-27 10:04:00'),
(4, 'Text Local', 'http://api.textlocal.in/send/', 'username', 'apihash', '', 'Yes', 'No', 'http', 'Inactive', 'Yes', '2018-01-27 10:04:00', '2018-01-27 10:04:00'),
(5, 'Top10sms', 'http://trans.websmsapp.com/API/', 'username', 'api_key', '', 'Yes', 'No', 'http', 'Inactive', 'No', '2018-01-27 10:04:00', '2018-01-27 10:04:00'),
(6, 'msg91', 'http://api.msg91.com/api/sendhttp.php', 'username', 'auth_key', '', 'Yes', 'No', 'http', 'Inactive', 'No', '2018-01-27 10:04:00', '2018-01-27 10:04:00'),
(7, 'Plivo', 'https://api.plivo.com/v1/Account/', 'auth_id', 'auth_token', '', 'Yes', 'No', 'http', 'Inactive', 'Yes', '2018-01-27 10:04:00', '2018-01-27 10:04:00'),
(8, 'SMSGlobal', 'http://www.smsglobal.com/http-api.php', 'username', 'Password', '', 'Yes', 'No', 'http', 'Inactive', 'Yes', '2018-01-27 10:04:00', '2018-01-27 10:04:00'),
(9, 'Bulk SMS', 'https://bulksms.vsms.net/eapi', 'username', 'Password', '', 'Yes', 'No', 'http', 'Inactive', 'Yes', '2018-01-27 10:04:00', '2018-01-27 10:04:00'),
(10, 'Nexmo', 'https://rest.nexmo.com/sms/json', 'api_key', 'api_secret', '', 'Yes', 'No', 'http', 'Inactive', 'Yes', '2018-01-27 10:04:00', '2018-01-27 10:04:00'),
(11, 'Route SMS', 'http://smsplus1.routesms.com:8080', 'username', 'Password', '', 'Yes', 'No', 'http', 'Inactive', 'No', '2018-01-27 10:04:00', '2018-01-27 10:04:00'),
(12, 'SMSKaufen', 'http://www.smskaufen.com/sms/gateway/sms.php', 'API User Name', 'SMS API Key', '', 'Yes', 'No', 'http', 'Inactive', 'No', '2018-01-27 10:04:00', '2018-01-27 10:04:00'),
(13, 'Kapow', 'http://www.kapow.co.uk/scripts/sendsms.php', 'username', 'Password', '', 'Yes', 'No', 'http', 'Inactive', 'No', '2018-01-27 10:04:00', '2018-01-27 10:04:00'),
(14, 'Zang', '', 'account_sid', 'auth_token', '', 'Yes', 'No', 'http', 'Inactive', 'No', '2018-01-27 10:04:00', '2018-01-27 10:04:00'),
(15, 'InfoBip', 'https://api.infobip.com/sms/1/text/advanced', 'username', 'Password', '', 'Yes', 'No', 'http', 'Inactive', 'Yes', '2018-01-27 10:04:00', '2018-01-27 10:04:00'),
(16, 'RANNH', 'http://rannh.com/sendsms.php', 'username', 'Password', '', 'Yes', 'No', 'http', 'Inactive', 'No', '2018-01-27 10:04:00', '2018-01-27 10:04:00'),
(17, 'SMSIndiaHub', 'http://cloud.smsindiahub.in/vendorsms/pushsms.aspx', 'username', 'Password', '', 'Yes', 'No', 'http', 'Inactive', 'No', '2018-01-27 10:04:00', '2018-01-27 10:04:00'),
(18, 'ShreeWeb', 'http://sms.shreeweb.com/sendsms/sendsms.php', 'username', 'Password', '', 'Yes', 'No', 'http', 'Inactive', 'No', '2018-01-27 10:04:00', '2018-01-27 10:04:00'),
(19, 'SmsGatewayMe', 'http://smsgateway.me/api/v3/messages/send', 'email', 'Password', 'device_id', 'Yes', 'No', 'http', 'Inactive', 'No', '2018-01-27 10:04:00', '2018-01-27 10:04:00'),
(20, 'Elibom', 'https://www.elibom.com/messages', 'your_elibom_email', 'your_api_passwrod', '', 'Yes', 'No', 'http', 'Inactive', 'No', '2018-01-27 10:04:01', '2018-01-27 10:04:01'),
(21, 'Hablame', 'https://api.hablame.co/sms/envio', 'client_id', 'api_secret', '', 'Yes', 'No', 'http', 'Inactive', 'No', '2018-01-27 10:04:01', '2018-01-27 10:04:01'),
(22, 'Wavecell', 'https://api.wavecell.com/sms/v1/', 'sub_account_id', 'api_password', '', 'Yes', 'No', 'http', 'Inactive', 'No', '2018-01-27 10:04:01', '2018-01-27 10:04:01'),
(23, 'SIPTraffic', 'https://www.siptraffic.com', 'sub_account_id', 'api_password', '', 'Yes', 'No', 'http', 'Inactive', 'No', '2018-01-27 10:04:01', '2018-01-27 10:04:01'),
(24, 'SMSMKT', 'http://member.smsmkt.com/SMSLink/SendMsg/main.php', 'username', 'password', '', 'Yes', 'No', 'http', 'Inactive', 'No', '2018-01-27 10:04:01', '2018-01-27 10:04:01'),
(25, 'MLat', 'https://m-lat.net:8443/axis2/services/SMSServiceWS', 'user', 'password', '', 'Yes', 'No', 'http', 'Inactive', 'No', '2018-01-27 10:04:01', '2018-01-27 10:04:01'),
(26, 'NRSGateway', 'https://gateway.plusmms.net/send.php', 'tu_user', 'tu_login', '', 'Yes', 'No', 'http', 'Inactive', 'No', '2018-01-27 10:04:01', '2018-01-27 10:04:01'),
(27, 'Orange', 'http://api.orange.com', 'client_id', 'client_secret', '', 'Yes', 'No', 'http', 'Inactive', 'No', '2018-01-27 10:04:01', '2018-01-27 10:04:01'),
(28, 'GlobexCam', 'http://panel.globexcamsms.com/api/mt/SendSMS', 'user', 'password', 'api_key', 'Yes', 'No', 'http', 'Inactive', 'No', '2018-01-27 10:04:01', '2018-01-27 10:04:01'),
(29, 'Camoo', 'https://api.camoo.cm/v1/sms.json', 'api_key', 'api_secret', '', 'Yes', 'No', 'http', 'Inactive', 'No', '2018-01-27 10:04:01', '2018-01-27 10:04:01'),
(30, 'Kannel', 'http://127.0.0.1:14002/cgi-bin/sendsms', 'username', 'password', '', 'Yes', 'No', 'http', 'Inactive', 'No', '2018-01-27 10:04:01', '2018-01-27 10:04:01'),
(31, 'Semysms', 'https://semysms.net/api/3/sms.php', 'token', 'device', '', 'Yes', 'No', 'http', 'Inactive', 'No', '2018-01-27 10:04:01', '2018-01-27 10:04:01'),
(32, 'Smsvitrini', 'http://api.smsvitrini.com/main.php', 'user_id', 'password', '', 'Yes', 'No', 'http', 'Inactive', 'No', '2018-01-27 10:04:01', '2018-01-27 10:04:01'),
(33, 'Semaphore', 'http://api.semaphore.co/api/v4/messages', 'api_key', 'N/A', '', 'Yes', 'No', 'http', 'Inactive', 'No', '2018-01-27 10:04:01', '2018-01-27 10:04:01'),
(34, 'Itexmo', 'https://www.itexmo.com/php_api/api.php', 'api_key', 'N/A', '', 'Yes', 'No', 'http', 'Inactive', 'No', '2018-01-27 10:04:01', '2018-01-27 10:04:01'),
(35, 'Chikka', 'https://post.chikka.com/smsapi/request', 'client_id', 'Secret_key', '', 'Yes', 'No', 'http', 'Inactive', 'No', '2018-01-27 10:04:01', '2018-01-27 10:04:01'),
(36, '1s2u', 'https://1s2u.com/sms/sendsms/sendsms.asp', 'user_name', 'password', 'ipcl', 'Yes', 'No', 'http', 'Inactive', 'No', '2018-01-27 10:04:01', '2018-01-27 10:04:01'),
(37, 'Kaudal', 'http://keudal.com/assmsserver/assmsserver', 'user_name', 'password', '', 'Yes', 'No', 'http', 'Inactive', 'No', '2018-01-27 10:04:02', '2018-01-27 10:04:02'),
(38, 'CMSMS', 'https://sgw01.cm.nl/gateway.ashx', 'product_token', 'N/A', '', 'Yes', 'No', 'http', 'Inactive', 'No', '2018-01-27 10:04:02', '2018-01-27 10:04:02'),
(39, 'SendOut', 'https://www.sendoutapp.com/api/v2/envia', 'YOUR_NUMBER', 'API_TOKEN', '', 'Yes', 'No', 'http', 'Inactive', 'No', '2018-01-27 10:04:02', '2018-01-27 10:04:02'),
(40, 'ViralThrob', 'http://cmsprodbe.viralthrob.com/api/sms_outbounds/send_message', 'API_ACCESS_TOKEN', 'SAAS_ACCOUNT', '', 'Yes', 'No', 'http', 'Inactive', 'No', '2018-01-27 10:04:02', '2018-01-27 10:04:02'),
(41, 'Masterksnetworks', 'http://api.masterksnetworks.com/sendsms/bulksms.php', 'Username', 'Password', '', 'Yes', 'No', 'http', 'Inactive', 'No', '2018-01-27 10:04:02', '2018-01-27 10:04:02'),
(42, 'MessageBird', 'https://rest.messagebird.com/messages', 'Access_Key', 'N/A', '', 'Yes', 'No', 'http', 'Inactive', 'Yes', '2018-01-27 10:04:02', '2018-01-27 10:04:02'),
(43, 'FortDigital', 'https://mx.fortdigital.net/http/send-message', 'username', 'password', '', 'Yes', 'No', 'http', 'Inactive', 'No', '2018-01-27 10:04:02', '2018-01-27 10:04:02'),
(44, 'SMSPRO', 'http://smspro.mtn.ci/bms/soap/messenger.asmx/HTTP_SendSms', 'userName', 'userPassword', 'customerID', 'Yes', 'No', 'http', 'Inactive', 'No', '2018-01-27 10:04:02', '2018-01-27 10:04:02'),
(45, 'CNIDCOM', 'http://www.cnid.com.py/api/api_cnid.php', 'api_key', 'api_secret', '', 'Yes', 'No', 'http', 'Inactive', 'No', '2018-01-27 10:04:02', '2018-01-27 10:04:02'),
(46, 'Dialog', 'https://cpsolutions.dialog.lk/main.php/cbs/sms/send', 'API_Password', 'N/A', '', 'Yes', 'No', 'http', 'Inactive', 'No', '2018-01-27 10:04:02', '2018-01-27 10:04:02'),
(47, 'VoiceTrading', 'https://www.voicetrading.com/myaccount/sendsms.php', 'user_name', 'password', '', 'Yes', 'No', 'http', 'Inactive', 'No', '2018-01-27 10:04:02', '2018-01-27 10:04:02'),
(48, 'AmazonSNS', NULL, 'Access_key_ID', 'Secret_Access_Key', 'Region', 'Yes', 'No', 'http', 'Inactive', 'No', '2018-01-27 10:04:02', '2018-01-27 10:04:02'),
(49, 'NusaSMS', 'http://api.nusasms.com/api/v3/sendsms/plain', 'username', 'password', '', 'Yes', 'No', 'http', 'Inactive', 'No', '2018-01-27 10:04:02', '2018-01-27 10:04:02'),
(50, 'SMS4Brands', 'http://sms4brands.com//api/sms-api.php', 'username', 'password', '', 'Yes', 'No', 'http', 'Inactive', 'No', '2018-01-27 10:04:02', '2018-01-27 10:04:02'),
(51, 'CheapGlobalSMS', 'http://cheapglobalsms.com/api_v1', 'sub_account', 'sub_account_pass', '', 'Yes', 'No', 'http', 'Inactive', 'No', '2018-01-27 10:04:02', '2018-01-27 10:04:02'),
(52, 'ExpertTexting', 'https://www.experttexting.com/ExptRestApi/sms/json/Message/Send', 'username', 'password', 'api_key', 'Yes', 'No', 'http', 'Inactive', 'No', '2018-01-27 10:04:02', '2018-01-27 10:04:02'),
(53, 'LightSMS', 'https://www.lightsms.com/external/get/send.php', 'Login', 'API_KEY', '', 'Yes', 'No', 'http', 'Inactive', 'No', '2018-01-27 10:04:02', '2018-01-27 10:04:02'),
(54, 'Adicis', 'http://bs1.adicis.cd/gw0/tuma.php', 'username', 'password', '', 'Yes', 'No', 'http', 'Inactive', 'No', '2018-01-27 10:04:02', '2018-01-27 10:04:02'),
(55, 'Smsconnexion', 'http://smsc.smsconnexion.com/api/gateway.aspx', 'username', 'passphrase', '', 'Yes', 'No', 'http', 'Inactive', 'No', '2018-01-27 10:04:02', '2018-01-27 10:04:02'),
(56, 'BrandedSMS', 'http://www.brandedsms.net//api/sms-api.php', 'username', 'password', '', 'Yes', 'No', 'http', 'Inactive', 'No', '2018-01-27 10:04:02', '2018-01-27 10:04:02'),
(57, 'Ibrbd', 'http://wdgw.ibrbd.net:8080/bagaduli/apigiso/sender.php', 'username', 'password', '', 'Yes', 'No', 'http', 'Inactive', 'No', '2018-01-27 10:04:03', '2018-01-27 10:04:03'),
(58, 'TxtNation', 'http://client.txtnation.com/gateway.php', 'company', 'ekey', '', 'Yes', 'No', 'http', 'Inactive', 'No', '2018-01-27 10:04:03', '2018-01-27 10:04:03'),
(59, 'TeleSign', '', 'Customer ID', 'API_Key', '', 'Yes', 'No', 'http', 'Inactive', 'No', '2018-01-27 10:04:03', '2018-01-27 10:04:03'),
(60, 'JasminSMS', 'http://127.0.0.1', 'foo', 'bar', '1401', 'Yes', 'No', 'http', 'Inactive', 'No', '2018-01-27 10:04:03', '2018-01-27 10:04:03'),
(61, 'Ezeee', 'http://my.ezeee.pk/sendsms_url.html', 'user_name', 'password', '', 'Yes', 'No', 'http', 'Inactive', 'No', '2018-01-27 10:04:03', '2018-01-27 10:04:03'),
(62, 'InfoBipSMPP', 'smpp3.infobip.com', 'system_id', 'password', '8888', 'Yes', 'No', 'smpp', 'Inactive', 'No', '2018-01-27 10:04:03', '2018-01-27 10:04:03'),
(63, 'SMSGlobalSMPP', 'smpp.smsglobal.com', 'system_id', 'password', '1775', 'Yes', 'No', 'smpp', 'Inactive', 'No', '2018-01-27 10:04:03', '2018-01-27 10:04:03'),
(64, 'ClickatellSMPP', 'smpp.clickatell.com', 'system_id', 'password', '2775', 'Yes', 'No', 'smpp', 'Inactive', 'No', '2018-01-27 10:04:03', '2018-01-27 10:04:03'),
(65, 'JasminSmsSMPP', 'host_name', 'system_id', 'password', 'port', 'Yes', 'No', 'smpp', 'Inactive', 'No', '2018-01-27 10:04:03', '2018-01-27 10:04:03'),
(66, 'WavecellSMPP', 'smpp.wavecell.com', 'system_id', 'password', '2775', 'Yes', 'No', 'smpp', 'Inactive', 'No', '2018-01-27 10:04:03', '2018-01-27 10:04:03'),
(67, 'Moreify', 'https://mapi.moreify.com/api/v1/sendSms', 'project_id', 'your_token', '', 'Yes', 'No', 'http', 'Inactive', 'No', '2018-01-27 10:04:03', '2018-01-27 10:04:03'),
(68, 'Digitalreachapi', 'https://digitalreachapi.dialog.lk/camp_req.php', 'user_name', 'password', '', 'Yes', 'No', 'http', 'Inactive', 'No', '2018-01-27 10:04:03', '2018-01-27 10:04:03'),
(69, 'Tropo', 'https://api.tropo.com/1.0/sessions', 'api_token', '', '', 'Yes', 'No', 'http', 'Inactive', 'No', '2018-01-27 10:04:03', '2018-01-27 10:04:03'),
(70, 'CheapSMS', 'http://198.24.149.4/API/pushsms.aspx', 'loginID', 'password', '', 'Yes', 'No', 'http', 'Inactive', 'No', '2018-01-27 10:04:03', '2018-01-27 10:04:03'),
(71, 'CCSSMS', 'http://193.58.235.30:8001/api', 'Username', 'Password', '', 'Yes', 'No', 'http', 'Inactive', 'No', '2018-01-27 10:04:03', '2018-01-27 10:04:03'),
(72, 'MyCoolSMS', 'http://www.my-cool-sms.com/api-socket.php', 'Username', 'Password', '', 'Yes', 'No', 'http', 'Inactive', 'No', '2018-01-27 10:04:03', '2018-01-27 10:04:03'),
(73, 'SmsBump', 'https://api.smsbump.com/send', 'API_KEY', '', '', 'Yes', 'No', 'http', 'Inactive', 'No', '2018-01-27 10:04:03', '2018-01-27 10:04:03'),
(74, 'BSG', '', 'API_KEY', '', '', 'Yes', 'No', 'http', 'Inactive', 'No', '2018-01-27 10:04:03', '2018-01-27 10:04:03'),
(75, 'SmsBroadcast', 'https://api.smsbroadcast.co.uk/api-adv.php', 'username', 'password', '', 'Yes', 'No', 'http', 'Inactive', 'No', '2018-01-27 10:04:03', '2018-01-27 10:04:03'),
(76, 'BullSMS', 'http://portal.bullsms.com/vendorsms/pushsms.aspx', 'user', 'password', '', 'Yes', 'No', 'http', 'Inactive', 'No', '2018-01-27 10:04:03', '2018-01-27 10:04:03'),
(77, 'Skebby', 'https://api.skebby.it/API/v1.0/REST/sms', 'User_key', 'Access_Token', '', 'Yes', 'No', 'http', 'Inactive', 'No', '2018-01-27 10:04:03', '2018-01-27 10:04:03');

-- --------------------------------------------------------

--
-- Table structure for table `sys_sms_history`
--

CREATE TABLE `sys_sms_history` (
  `id` int(10) UNSIGNED NOT NULL,
  `userid` int(11) NOT NULL,
  `sender` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `receiver` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `message` text COLLATE utf8_unicode_ci NOT NULL,
  `amount` int(11) NOT NULL,
  `use_gateway` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `api_key` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` text COLLATE utf8_unicode_ci NOT NULL,
  `send_by` enum('receiver','sender','api') COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sys_sms_plan_feature`
--

CREATE TABLE `sys_sms_plan_feature` (
  `id` int(10) UNSIGNED NOT NULL,
  `pid` int(11) NOT NULL,
  `feature_name` text COLLATE utf8_unicode_ci NOT NULL,
  `feature_value` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` enum('Active','Inactive') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sys_sms_price_plan`
--

CREATE TABLE `sys_sms_price_plan` (
  `id` int(10) UNSIGNED NOT NULL,
  `plan_name` text COLLATE utf8_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `popular` enum('Yes','No') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'No',
  `status` enum('Active','Inactive') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sys_sms_templates`
--

CREATE TABLE `sys_sms_templates` (
  `id` int(10) UNSIGNED NOT NULL,
  `cl_id` int(11) NOT NULL,
  `template_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `from` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8_unicode_ci NOT NULL,
  `global` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `status` enum('active','inactive') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sys_sms_transaction`
--

CREATE TABLE `sys_sms_transaction` (
  `id` int(10) UNSIGNED NOT NULL,
  `cl_id` int(11) NOT NULL,
  `amount` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sys_support_departments`
--

CREATE TABLE `sys_support_departments` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` text COLLATE utf8_unicode_ci NOT NULL,
  `email` text COLLATE utf8_unicode_ci NOT NULL,
  `order` int(11) NOT NULL,
  `show` enum('Yes','No') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Yes',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sys_tickets`
--

CREATE TABLE `sys_tickets` (
  `id` int(10) UNSIGNED NOT NULL,
  `did` int(11) NOT NULL,
  `cl_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `name` text COLLATE utf8_unicode_ci NOT NULL,
  `email` text COLLATE utf8_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `subject` text COLLATE utf8_unicode_ci NOT NULL,
  `message` text COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('Pending','Answered','Customer Reply','Closed') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Pending',
  `admin` text COLLATE utf8_unicode_ci NOT NULL,
  `replyby` text COLLATE utf8_unicode_ci,
  `closed_by` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sys_ticket_files`
--

CREATE TABLE `sys_ticket_files` (
  `id` int(10) UNSIGNED NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `cl_id` int(11) NOT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `admin` text COLLATE utf8_unicode_ci,
  `file_title` text COLLATE utf8_unicode_ci NOT NULL,
  `file_size` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `file` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sys_ticket_replies`
--

CREATE TABLE `sys_ticket_replies` (
  `id` int(10) UNSIGNED NOT NULL,
  `tid` int(11) NOT NULL,
  `cl_id` int(11) NOT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `admin` text COLLATE utf8_unicode_ci,
  `name` text COLLATE utf8_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `message` text COLLATE utf8_unicode_ci NOT NULL,
  `image` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_reserved_at_index` (`queue`,`reserved_at`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sys_admins`
--
ALTER TABLE `sys_admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sys_admin_role`
--
ALTER TABLE `sys_admin_role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sys_admin_role_perm`
--
ALTER TABLE `sys_admin_role_perm`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sys_app_config`
--
ALTER TABLE `sys_app_config`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sys_blacklist_contacts`
--
ALTER TABLE `sys_blacklist_contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sys_bulk_sms`
--
ALTER TABLE `sys_bulk_sms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sys_clients`
--
ALTER TABLE `sys_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sys_client_groups`
--
ALTER TABLE `sys_client_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sys_contact_list`
--
ALTER TABLE `sys_contact_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sys_custom_sms_gateways`
--
ALTER TABLE `sys_custom_sms_gateways`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sys_email_templates`
--
ALTER TABLE `sys_email_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sys_import_phone_number`
--
ALTER TABLE `sys_import_phone_number`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sys_int_country_codes`
--
ALTER TABLE `sys_int_country_codes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sys_invoices`
--
ALTER TABLE `sys_invoices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sys_invoice_items`
--
ALTER TABLE `sys_invoice_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sys_language`
--
ALTER TABLE `sys_language`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sys_language_data`
--
ALTER TABLE `sys_language_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sys_payment_gateways`
--
ALTER TABLE `sys_payment_gateways`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sys_schedule_sms`
--
ALTER TABLE `sys_schedule_sms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sys_sender_id_management`
--
ALTER TABLE `sys_sender_id_management`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sys_sms_bundles`
--
ALTER TABLE `sys_sms_bundles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sys_sms_gateways`
--
ALTER TABLE `sys_sms_gateways`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sys_sms_history`
--
ALTER TABLE `sys_sms_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sys_sms_plan_feature`
--
ALTER TABLE `sys_sms_plan_feature`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sys_sms_price_plan`
--
ALTER TABLE `sys_sms_price_plan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sys_sms_templates`
--
ALTER TABLE `sys_sms_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sys_sms_transaction`
--
ALTER TABLE `sys_sms_transaction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sys_support_departments`
--
ALTER TABLE `sys_support_departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sys_tickets`
--
ALTER TABLE `sys_tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sys_ticket_files`
--
ALTER TABLE `sys_ticket_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sys_ticket_replies`
--
ALTER TABLE `sys_ticket_replies`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=331;
--
-- AUTO_INCREMENT for table `sys_admins`
--
ALTER TABLE `sys_admins`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `sys_admin_role`
--
ALTER TABLE `sys_admin_role`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sys_admin_role_perm`
--
ALTER TABLE `sys_admin_role_perm`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sys_app_config`
--
ALTER TABLE `sys_app_config`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
--
-- AUTO_INCREMENT for table `sys_blacklist_contacts`
--
ALTER TABLE `sys_blacklist_contacts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sys_bulk_sms`
--
ALTER TABLE `sys_bulk_sms`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sys_clients`
--
ALTER TABLE `sys_clients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sys_client_groups`
--
ALTER TABLE `sys_client_groups`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sys_contact_list`
--
ALTER TABLE `sys_contact_list`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sys_custom_sms_gateways`
--
ALTER TABLE `sys_custom_sms_gateways`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sys_email_templates`
--
ALTER TABLE `sys_email_templates`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `sys_import_phone_number`
--
ALTER TABLE `sys_import_phone_number`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sys_int_country_codes`
--
ALTER TABLE `sys_int_country_codes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=212;
--
-- AUTO_INCREMENT for table `sys_invoices`
--
ALTER TABLE `sys_invoices`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sys_invoice_items`
--
ALTER TABLE `sys_invoice_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sys_language`
--
ALTER TABLE `sys_language`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `sys_language_data`
--
ALTER TABLE `sys_language_data`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=583;
--
-- AUTO_INCREMENT for table `sys_payment_gateways`
--
ALTER TABLE `sys_payment_gateways`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `sys_schedule_sms`
--
ALTER TABLE `sys_schedule_sms`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sys_sender_id_management`
--
ALTER TABLE `sys_sender_id_management`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sys_sms_bundles`
--
ALTER TABLE `sys_sms_bundles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sys_sms_gateways`
--
ALTER TABLE `sys_sms_gateways`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;
--
-- AUTO_INCREMENT for table `sys_sms_history`
--
ALTER TABLE `sys_sms_history`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sys_sms_plan_feature`
--
ALTER TABLE `sys_sms_plan_feature`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sys_sms_price_plan`
--
ALTER TABLE `sys_sms_price_plan`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sys_sms_templates`
--
ALTER TABLE `sys_sms_templates`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sys_sms_transaction`
--
ALTER TABLE `sys_sms_transaction`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sys_support_departments`
--
ALTER TABLE `sys_support_departments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sys_tickets`
--
ALTER TABLE `sys_tickets`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sys_ticket_files`
--
ALTER TABLE `sys_ticket_files`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sys_ticket_replies`
--
ALTER TABLE `sys_ticket_replies`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
