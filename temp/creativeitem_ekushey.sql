-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 10, 2014 at 05:43 PM
-- Server version: 5.6.14
-- PHP Version: 5.5.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `creativeitem_ekushey`
--

-- --------------------------------------------------------

--
-- Table structure for table `account_permission`
--

DROP TABLE IF EXISTS `account_permission`;
CREATE TABLE IF NOT EXISTS `account_permission` (
  `account_permission_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` longtext COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`account_permission_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Dumping data for table `account_permission`
--

INSERT INTO `account_permission` (`account_permission_id`, `name`, `description`) VALUES
(1, 'Manage Assigned Project', 'User can view and manage only assigned projects to him. Project status update, document upload/view, project discussion will be available to assigned projects'),
(2, 'Manage All Projects', ''),
(3, 'Manage Clients', ''),
(4, 'Manage Staffs', ''),
(5, 'Manage Payment', ''),
(6, 'Manage Assigned Support Ticket', ''),
(7, 'Manage All Support Tickets', '');

-- --------------------------------------------------------

--
-- Table structure for table `account_role`
--

DROP TABLE IF EXISTS `account_role`;
CREATE TABLE IF NOT EXISTS `account_role` (
  `account_role_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` longtext COLLATE utf8_unicode_ci NOT NULL,
  `account_permissions` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`account_role_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `account_role`
--

INSERT INTO `account_role` (`account_role_id`, `name`, `account_permissions`) VALUES
(1, 'Manager', '1,3,4,5,6,'),
(4, 'Accountant', '5,'),
(5, 'Support Staff', '6,7,'),
(6, 'Developer', '1,6,');

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` longtext COLLATE utf8_unicode_ci NOT NULL,
  `email` longtext COLLATE utf8_unicode_ci NOT NULL,
  `password` longtext COLLATE utf8_unicode_ci NOT NULL,
  `chat_status` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'offline',
  PRIMARY KEY (`admin_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `name`, `email`, `password`, `chat_status`) VALUES
(1, 'Mr. admin', 'admin@example.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'offline'),
(2, '', 'admin@yahoo.com', '24b01cdbb4ffc4ac2f4129bfb928fcfe3808f64e', 'offline');

-- --------------------------------------------------------

--
-- Table structure for table `bookmark`
--

DROP TABLE IF EXISTS `bookmark`;
CREATE TABLE IF NOT EXISTS `bookmark` (
  `bookmark_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` longtext COLLATE utf8_unicode_ci NOT NULL,
  `url` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`bookmark_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

DROP TABLE IF EXISTS `chat`;
CREATE TABLE IF NOT EXISTS `chat` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `from` varchar(255) NOT NULL DEFAULT '',
  `to` varchar(255) NOT NULL DEFAULT '',
  `message` text NOT NULL,
  `sent` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `recd` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `chat`
--

INSERT INTO `chat` (`id`, `from`, `to`, `message`, `sent`, `recd`) VALUES
(1, 'johndoe', 'janedoe', 'fffffff', '2013-11-18 02:42:55', 0),
(2, 'johndoe', 'janedoe', 'dsfsdf', '2013-11-18 02:43:06', 0),
(3, 'johndoe', 'babydoe', 'zzzzzzz', '2013-11-18 02:43:23', 0),
(4, 'johndoe', 'janedoe', 'aa', '2013-11-18 02:44:02', 0),
(5, 'johndoe', 'janedoe', 'dd', '2013-11-18 02:44:31', 0),
(6, 'johndoe', 'janedoe', 'dddddddddddddd', '2013-11-18 02:44:38', 0),
(7, 'johndoe', 'janedoe', '1', '2013-11-18 02:44:38', 0),
(8, 'johndoe', 'janedoe', '112121', '2013-11-18 02:45:24', 0),
(9, 'johndoe', 'babydoe', 'sss', '2013-11-18 02:48:48', 0);

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

DROP TABLE IF EXISTS `client`;
CREATE TABLE IF NOT EXISTS `client` (
  `client_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` longtext COLLATE utf8_unicode_ci NOT NULL,
  `email` longtext COLLATE utf8_unicode_ci NOT NULL,
  `password` longtext COLLATE utf8_unicode_ci NOT NULL,
  `address` longtext COLLATE utf8_unicode_ci NOT NULL,
  `phone` longtext COLLATE utf8_unicode_ci NOT NULL,
  `company` longtext COLLATE utf8_unicode_ci NOT NULL,
  `website` longtext COLLATE utf8_unicode_ci NOT NULL,
  `skype_id` longtext COLLATE utf8_unicode_ci NOT NULL,
  `facebook_profile_link` longtext COLLATE utf8_unicode_ci NOT NULL,
  `linkedin_profile_link` longtext COLLATE utf8_unicode_ci NOT NULL,
  `twitter_profile_link` longtext COLLATE utf8_unicode_ci NOT NULL,
  `short_note` longtext COLLATE utf8_unicode_ci NOT NULL,
  `chat_status` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'offline',
  PRIMARY KEY (`client_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=127 ;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`client_id`, `name`, `email`, `password`, `address`, `phone`, `company`, `website`, `skype_id`, `facebook_profile_link`, `linkedin_profile_link`, `twitter_profile_link`, `short_note`, `chat_status`) VALUES
(1, 'Brian Powel', 'test@email.com', '1234', '', '987857', '', '', 'pol', '', '', '', '', 'offline'),
(2, 'Joseph Donovan', 'wyni@yahoo.com', '1234', 'malayasia', '+187-29-5565739', 'Douglas and Spears Trading', '0', '0', '0', '0', '0', '', 'offline'),
(4, 'Taylor Hays', 'waxysece@gmail.com', '123456', 'russia', '+478-74-8667579', '', 'http://www.bod.cm', 'wewe', 'Ipsa consequatur sed eaque qui similique irure ducimus magni pariatur Est quis voluptatem', 'Ipsum non minus ipsum perspiciatis maiores labore architecto illum et duis aut soluta', 'Rerum id fuga Libero laboriosam vel qui', '', 'offline'),
(6, 'Pearson Anjolie ', 'tasenunu@hotmail.com', 'Recusandae Reiciendis quisquam iusto dignissimos atque aut impedit velit omnis voluptas a ut nulla id cum dolor aliqua Et', 'india', '+431-54-6450494', '', 'http://www.saxaryjypa.me.uk', 'weer', 'Aliquip ratione consequatur Praesentium aut expedita', 'Vitae fugiat eveniet in unde consectetur molestias aut ut vel consequatur magni proident cupidatat', 'Dolor omnis necessitatibus ut facere natus', '', 'offline'),
(7, 'Guinevere Mooney', 'romi@gmail.com', 'Architecto odio dicta laborum temporibus sit deserunt officiis lorem quo corrupti aute cumque quo cillum quia', 'sweden', '+725-58-2221784', '', '0', '0', '0', '0', '0', '', 'offline'),
(8, 'f', '', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', '', '', '', '', '', '', '', '', '', 'offline'),
(9, 'sd', '', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', '', '', '', '', '', '', '', '', '', 'offline'),
(10, 'mr. client', 'test@email.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'dhaka', '09846', 'envato', 'http://envato.com', 'skype', 'fb', 'link', 'twt', '', 'offline'),
(11, 'f3', '', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', '', '', '', '', '', '', '', '', '', 'offline'),
(13, 'sdsds', '', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', '', '', '', '', '', '', '', '', '', 'offline'),
(14, 'sss', '', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', '', '', '', '', '', '', '', '', '', 'offline'),
(15, 'ssss', '', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', '', '', '', '', '', '', '', '', '', 'offline'),
(17, 'sdsdsds', '', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', '', '', '', '', '', '', '', '', '', 'offline'),
(18, 's33', '', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', '', '', '', '', '', '', '', '', '', 'offline'),
(44, 'Kiayada Leonard', 'saperu@yahoo.com', 'baa8a64efc912a6f274b1695330aa8432b9ce6b4', 'aus', '+263-91-4615475', 'Watts Savage LLC', 'http://www.vapufako.co.uk', 'hghut', 'Facilis labore quidem aut nihil vero laborum In accusantium facere nobis excepturi culpa voluptate quas eu non sed', 'Cumque eum saepe magnam ut labore anim minima laboris fugiat error vitae quae animi quis officiis accusantium aut nulla vitae', 'Qui laudantium adipisci molestiae qui eu consectetur omnis ratione enim laborum Recusandae', '', 'offline'),
(45, 'Emilie Jensen', 'zugiposufu@gmail.com', '75bc35e0c140a06b8083b4c515ac57b3ce9de7c3', 'England', '+242-56-2637012', 'Durham Ford Inc', 'http://www.cowujoj.mobi', 'uiyu', 'http://www.facebook.com/ftwr', 'http://www.linkedin.com/ftwr', 'http://www.twitter.com/ftwr', 'ert\n', 'offline'),
(125, 'Miss. Client', 'client@example.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'sydney', '', '', '', '', '', '', '', '', 'offline'),
(102, 'erer2', '', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', '', '', '', '', '', '', '', '', '', 'offline'),
(103, 'dfdf2', '', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', '', '', '', '', '', '', '', '', '', 'offline'),
(108, 'dc2', '', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', 'dhaka, Bangladesh', '', '', '', '', '', '', '', '', 'offline'),
(109, 'dj', 'email', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', '', '5476', '', '', '234', '', '', '', '', 'offline'),
(124, 'Mr. Hamilton', 'test2@email.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', '', '', '', '', '', '', '', '', '234', 'offline');

-- --------------------------------------------------------

--
-- Table structure for table `currency`
--

DROP TABLE IF EXISTS `currency`;
CREATE TABLE IF NOT EXISTS `currency` (
  `currency_id` int(11) NOT NULL AUTO_INCREMENT,
  `currency_code` longtext COLLATE utf8_unicode_ci NOT NULL,
  `currency_symbol` longtext COLLATE utf8_unicode_ci NOT NULL,
  `currency_name` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`currency_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `currency`
--

INSERT INTO `currency` (`currency_id`, `currency_code`, `currency_symbol`, `currency_name`) VALUES
(1, 'usd', '$', 'US dollar'),
(2, 'gbp', '£', 'Pound'),
(3, 'eur', '€', 'Euro'),
(4, 'aud', '$', 'Australian Dollar');

-- --------------------------------------------------------

--
-- Table structure for table `email_template`
--

DROP TABLE IF EXISTS `email_template`;
CREATE TABLE IF NOT EXISTS `email_template` (
  `email_template_id` int(11) NOT NULL AUTO_INCREMENT,
  `task` longtext COLLATE utf8_unicode_ci NOT NULL,
  `subject` longtext COLLATE utf8_unicode_ci NOT NULL,
  `body` longtext COLLATE utf8_unicode_ci NOT NULL,
  `instruction` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`email_template_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

--
-- Dumping data for table `email_template`
--

INSERT INTO `email_template` (`email_template_id`, `task`, `subject`, `body`, `instruction`) VALUES
(1, 'new_project_opening', 'New project created', '<span>\n<div>Hello [CLIENT_NAME], <br>we have created a new project with your account.<br><br>Project name : [PROJECT_NAME]<br>Please follow the link below to view status and updates of the project.<br>[PROJECT_LINK]</div></span>', ''),
(2, 'new_client_account_opening', 'Client account creation', '<span>\n<div>Hi [CLIENT_NAME],</div>\n</span>Your client account is created !\n<span>Please login to your client account panel here :&nbsp;<br></span>[SYSTEM_URL]<br>Login credential :<br>email : [CLIENT_EMAIL]<br>password : [CLIENT_PASSWORD]', ''),
(3, 'new_staff_account_opening', 'Staff account creation', '<span>\n<div><div>Hi [STAFF_NAME],</div>Your staff account is created !&nbsp;Please login to your staff account panel here :&nbsp;<br>[SYSTEM_URL]<br>Login credential :<br>email : [STAFF_EMAIL]<br>password : [STAFF_PASSWORD]<br></div></span>', ''),
(4, 'payment_completion_notification', 'Payment completion notification', '<span>\n<div>Your payment of invoice [INVOICE_NUMBER] is completed.<br>You can review your payment history here :<br>[SYSTEM_PAYMENT_URL]</div></span>', ''),
(5, 'new_support_ticket_notify_admin', 'New support ticket notification', 'Hi [ADMIN_NAME],<br>A new support ticket is submitted. Ticket code : [TICKET_CODE]<br><br>Review all opened support tickets here :<br>[SYSTEM_OPENED_TICKET_URL]<br>', ''),
(6, 'support_ticket_assign_staff', 'Support ticket assignment notification', 'Hi [STAFF_NAME],<br>A new support ticket is assigned. Ticket code : [TICKET_CODE]<br><br>Review all opened support tickets here :<br>[SYSTEM_OPENED_TICKET_URL]', ''),
(7, 'new_message_notification', 'New message notification.', 'A new message has been sent by [SENDER_NAME].<br><br><span class="wysiwyg-color-silver">[MESSAGE]<br></span><br><span>To reply to this message, login to your account :<br></span>[SYSTEM_URL]', ''),
(8, 'password_reset_confirmation', 'Password reset notification', 'Hi [NAME],<br>Your password is reset. New password : [NEW_PASSWORD]<br>Login here with your new password :<br>[SYSTEM_URL]<br><br>You can change your password after logging in to your account.', '');

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

DROP TABLE IF EXISTS `invoice`;
CREATE TABLE IF NOT EXISTS `invoice` (
  `invoice_id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_number` longtext COLLATE utf8_unicode_ci NOT NULL,
  `client_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `title` longtext COLLATE utf8_unicode_ci NOT NULL,
  `invoice_entries` longtext COLLATE utf8_unicode_ci NOT NULL,
  `creation_timestamp` longtext COLLATE utf8_unicode_ci NOT NULL,
  `due_timestamp` longtext COLLATE utf8_unicode_ci NOT NULL,
  `status` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT 'paid or unpaid',
  `vat_percentage` longtext COLLATE utf8_unicode_ci NOT NULL,
  `discount_amount` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`invoice_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=14 ;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`invoice_id`, `invoice_number`, `client_id`, `project_id`, `title`, `invoice_entries`, `creation_timestamp`, `due_timestamp`, `status`, `vat_percentage`, `discount_amount`) VALUES
(11, '91169', 125, 1, 'test for paypal', '[{"description":"er","amount":"23"},{"description":"e2","amount":"25"}]', '08/28/2014', '', 'unpaid', '6', '7'),
(9, '87119', 1, 1, 'test12', '[{"description":"initial paymenty","amount":"200"},{"description":"intermediate payment","amount":"350"},{"description":"final payment","amount":"650"},{"description":"after sales service","amount":"400"}]', '08/22/2014', '08/12/2014', 'unpaid', '12', '6');

-- --------------------------------------------------------

--
-- Table structure for table `language`
--

DROP TABLE IF EXISTS `language`;
CREATE TABLE IF NOT EXISTS `language` (
  `phrase_id` int(11) NOT NULL AUTO_INCREMENT,
  `phrase` longtext COLLATE utf8_unicode_ci NOT NULL,
  `english` longtext COLLATE utf8_unicode_ci NOT NULL,
  `bengali` longtext COLLATE utf8_unicode_ci NOT NULL,
  `spanish` longtext COLLATE utf8_unicode_ci NOT NULL,
  `arabic` longtext COLLATE utf8_unicode_ci NOT NULL,
  `ytyt` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`phrase_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=231 ;

--
-- Dumping data for table `language`
--

INSERT INTO `language` (`phrase_id`, `phrase`, `english`, `bengali`, `spanish`, `arabic`, `ytyt`) VALUES
(216, 'account', '', '', '', '', ''),
(217, 'profile', '', '', '', '', ''),
(218, 'change_password', '', '', '', '', ''),
(219, 'logout', '', '', '', '', ''),
(220, 'admin', '', '', '', '', ''),
(221, 'panel', '', '', '', '', ''),
(222, 'dashboard_help', '', '', '', '', ''),
(223, 'dashboard', '', '', '', '', ''),
(224, 'student_help', '', '', '', '', ''),
(225, 'student', '', '', '', '', ''),
(226, 'bed_ward_help', '', '', '', '', ''),
(227, 'live_chat', '', '', '', '', ''),
(228, 'client 1', '', '', '', '', ''),
(229, 'profile_help', '', '', '', '', ''),
(230, 'manage_student', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

DROP TABLE IF EXISTS `message`;
CREATE TABLE IF NOT EXISTS `message` (
  `message_id` int(11) NOT NULL AUTO_INCREMENT,
  `message_thread_code` longtext NOT NULL,
  `message` longtext NOT NULL,
  `sender` longtext NOT NULL,
  `timestamp` longtext NOT NULL,
  `read_status` int(11) NOT NULL DEFAULT '0' COMMENT '0 unread 1 read',
  PRIMARY KEY (`message_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`message_id`, `message_thread_code`, `message`, `sender`, `timestamp`, `read_status`) VALUES
(1, 'b85cc924db2b1d6', 'hi admin', 'client-125', '1415387906', 1),
(2, 'b85cc924db2b1d6', '2nd ms', 'client-125', '1415387919', 1),
(3, 'b85cc924db2b1d6', 'hello miss c', 'admin-1', '1415387938', 1),
(4, 'b85cc924db2b1d6', 'i am good', 'admin-1', '1415387951', 1),
(5, 'b85cc924db2b1d6', 'really ? what about the project update ?', 'client-125', '1415387976', 1),
(6, 'eca32892726efc7', 'hello boss', 'staff-5', '1415388039', 1),
(7, 'eca32892726efc7', 'i am sick', 'staff-5', '1415388055', 1),
(8, 'eca32892726efc7', 'ok, take rest for a few days', 'admin-1', '1415388102', 1),
(9, 'eca32892726efc7', 'take care buddy', 'admin-1', '1415388173', 1),
(10, 'eca32892726efc7', 'sure boss', 'staff-5', '1415388187', 0);

-- --------------------------------------------------------

--
-- Table structure for table `message_thread`
--

DROP TABLE IF EXISTS `message_thread`;
CREATE TABLE IF NOT EXISTS `message_thread` (
  `message_thread_id` int(11) NOT NULL AUTO_INCREMENT,
  `message_thread_code` longtext COLLATE utf8_unicode_ci NOT NULL,
  `sender` longtext COLLATE utf8_unicode_ci NOT NULL,
  `reciever` longtext COLLATE utf8_unicode_ci NOT NULL,
  `last_message_timestamp` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`message_thread_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `message_thread`
--

INSERT INTO `message_thread` (`message_thread_id`, `message_thread_code`, `sender`, `reciever`, `last_message_timestamp`) VALUES
(1, 'b85cc924db2b1d6', 'client-125', 'admin-1', ''),
(2, 'eca32892726efc7', 'staff-5', 'admin-1', '');

-- --------------------------------------------------------

--
-- Table structure for table `note`
--

DROP TABLE IF EXISTS `note`;
CREATE TABLE IF NOT EXISTS `note` (
  `note_id` int(11) NOT NULL AUTO_INCREMENT,
  `note` longtext COLLATE utf8_unicode_ci NOT NULL,
  `user_type` longtext COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `color` longtext COLLATE utf8_unicode_ci NOT NULL,
  `timestamp_create` longtext COLLATE utf8_unicode_ci NOT NULL,
  `timestamp_last_update` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`note_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=17 ;

--
-- Dumping data for table `note`
--

INSERT INTO `note` (`note_id`, `note`, `user_type`, `user_id`, `color`, `timestamp_create`, `timestamp_last_update`) VALUES
(1, '\n		\n			\n		\n			\n		\n			\n		\n			\n		\n			\n		\n			\n		\n			\n		\n			\n		\n			\n		\n			\n		\n			\n		\n			\n		\n			\n		\n			\n		\n			\n		\n			\n		\n			\n		\n			\n		\n			\n		\n			\n		\n			\n		\n			\n		\n			\n		\n			\n		\n			\n		\n			\n		\n			\n		\n			\n		\n			\n		\n			\n		\n			\n		\n			\n		\n			\n		\n			\n		\n			\n		\n			\n		\n			\n		\n			\n		\n			\n		\n			\n		\n			\n		\n			\n		\n			\n		\n			\n		\n			\n		\n			\n		\n			\n		\n			<li class="current" style="visibility: inherit; opacity: 1;"><a href="#"><strong>James phone : +9586930239</strong><span>Ronaldo phone : +749204058vnfg</span></a><div class="content">James phone : +9586930239\nRonaldo phone : +749204058vnfg</div><button class="note-close">×</button></li>\n		\n			\n		\n			\n		\n			\n		\n			\n		\n			\n		\n			<li class="" style="visibility: inherit; opacity: 1;"><a href="#"><strong>Yes to do 123456</strong><span>todayknsdf</span></a><div class="content">Yes to do 123456\ntodayknsdf\nsdfns\ndfnds\nn\nsd</div><button class="note-close">×</button></li>\n		\n						\n			\n			\n			\n			\n			\n			<!-- this will be automatically hidden when there are notes in the list -->\n			<li class="no-notes">\n				There are no notes yet!\n			</li>\n					\n			\n			\n			\n			\n			\n			<!-- this will be automatically hidden when there are notes in the list -->\n			<li class="no-notes">\n				There are no notes yet!\n			</li>\n					\n			\n			\n			\n			\n			\n			<!-- this will be automatically hidden when there are notes in the list -->\n			<li class="no-notes">\n				There are no notes yet!\n			</li>\n					\n			\n			\n			\n			\n			\n			<!-- this will be automatically hidden when there are notes in the list -->\n			<li class="no-notes">\n				There are no notes yet!\n			</li>\n					\n			\n			\n			\n			\n			\n			<!-- this will be automatically hidden when there are notes in the list -->\n			<li class="no-notes">\n				There are no notes yet!\n			</li>\n					\n			\n			\n			\n			\n			\n			<!-- this will be automatically hidden when there are notes in the list -->\n			<li class="no-notes">\n				There are no notes yet!\n			</li>\n					\n			\n			\n			\n			\n			\n			<!-- this will be automatically hidden when there are notes in the list -->\n			<li class="no-notes">\n				There are no notes yet!\n			</li>\n					\n			\n			\n			\n			\n			\n			<!-- this will be automatically hidden when there are notes in the list -->\n			<li class="no-notes">\n				There are no notes yet!\n			</li>\n					\n			\n			\n			\n			\n			\n			<!-- this will be automatically hidden when there are notes in the list -->\n			<li class="no-notes">\n				There are no notes yet!\n			</li>\n					\n			\n			\n			\n			\n			\n			<!-- this will be automatically hidden when there are notes in the list -->\n			<li class="no-notes">\n				There are no notes yet!\n			</li>\n					\n			\n			\n			\n			\n			\n			<!-- this will be automatically hidden when there are notes in the list -->\n			<li class="no-notes">\n				There are no notes yet!\n			</li>\n					\n			\n			\n			\n			\n			\n			<!-- this will be automatically hidden when there are notes in the list -->\n			<li class="no-notes">\n				There are no notes yet!\n			</li>\n					\n			\n			\n			\n			\n			\n			<!-- this will be automatically hidden when there are notes in the list -->\n			<li class="no-notes">\n				There are no notes yet!\n			</li>\n					\n			\n			\n			\n			\n			\n			<!-- this will be automatically hidden when there are notes in the list -->\n			<li class="no-notes">\n				There are no notes yet!\n			</li>\n					\n			\n			\n			\n			\n			\n			<!-- this will be automatically hidden when there are notes in the list -->\n			<li class="no-notes">\n				There are no notes yet!\n			</li>\n					\n			\n			\n			\n			\n			\n			<!-- this will be automatically hidden when there are notes in the list -->\n			<li class="no-notes">\n				There are no notes yet!\n			</li>\n					\n			\n			\n			\n			\n			\n			<!-- this will be automatically hidden when there are notes in the list -->\n			<li class="no-notes">\n				There are no notes yet!\n			</li>\n					\n			\n			\n			\n			\n			\n			<!-- this will be automatically hidden when there are notes in the list -->\n			<li class="no-notes">\n				There are no notes yet!\n			</li>\n					\n			\n			\n			\n			\n			\n			<!-- this will be automatically hidden when there are notes in the list -->\n			<li class="no-notes">\n				There are no notes yet!\n			</li>\n					\n			\n			\n			\n			\n			\n			<!-- this will be automatically hidden when there are notes in the list -->\n			<li class="no-notes">\n				There are no notes yet!\n			</li>\n					\n			\n			\n			\n			\n			\n			<!-- this will be automatically hidden when there are notes in the list -->\n			<li class="no-notes">\n				There are no notes yet!\n			</li>\n					\n			\n			\n			\n			\n			\n			<!-- this will be automatically hidden when there are notes in the list -->\n			<li class="no-notes">\n				There are no notes yet!\n			</li>\n					\n			\n			\n			\n			\n			\n			<!-- this will be automatically hidden when there are notes in the list -->\n			<li class="no-notes">\n				There are no notes yet!\n			</li>\n					\n			\n			\n			\n			\n			\n			<!-- this will be automatically hidden when there are notes in the list -->\n			<li class="no-notes">\n				There are no notes yet!\n			</li>\n					\n			\n			\n			\n			\n			\n			<!-- this will be automatically hidden when there are notes in the list -->\n			<li class="no-notes">\n				There are no notes yet!\n			</li>\n					\n			\n			\n			\n			\n			\n			<!-- this will be automatically hidden when there are notes in the list -->\n			<li class="no-notes">\n				There are no notes yet!\n			</li>\n					\n			\n			\n			\n			\n			\n			<!-- this will be automatically hidden when there are notes in the list -->\n			<li class="no-notes">\n				There are no notes yet!\n			</li>\n					\n			\n			\n			\n			\n			\n			<!-- this will be automatically hidden when there are notes in the list -->\n			<li class="no-notes">\n				There are no notes yet!\n			</li>\n					\n			\n			\n			\n			\n			\n			<!-- this will be automatically hidden when there are notes in the list -->\n			<li class="no-notes">\n				There are no notes yet!\n			</li>\n					\n			\n			\n			\n			\n			\n			<!-- this will be automatically hidden when there are notes in the list -->\n			<li class="no-notes">\n				There are no notes yet!\n			</li>\n					\n			\n			\n			\n			\n			\n			<!-- this will be automatically hidden when there are notes in the list -->\n			<li class="no-notes">\n				There are no notes yet!\n			</li>\n					\n			\n			\n			\n			\n			\n			<!-- this will be automatically hidden when there are notes in the list -->\n			<li class="no-notes">\n				There are no notes yet!\n			</li>\n					\n			\n			\n			\n			\n			\n			<!-- this will be automatically hidden when there are notes in the list -->\n			<li class="no-notes">\n				There are no notes yet!\n			</li>\n					\n			\n			\n			\n			\n			\n			<!-- this will be automatically hidden when there are notes in the list -->\n			<li class="no-notes">\n				There are no notes yet!\n			</li>\n					\n			\n			\n			\n			\n			\n			<!-- this will be automatically hidden when there are notes in the list -->\n			<li class="no-notes">\n				There are no notes yet!\n			</li>\n					\n			\n			\n			\n			\n			\n			<!-- this will be automatically hidden when there are notes in the list -->\n			<li class="no-notes">\n				There are no notes yet!\n			</li>\n					\n			\n			\n			\n			\n			\n			<!-- this will be automatically hidden when there are notes in the list -->\n			<li class="no-notes">\n				There are no notes yet!\n			</li>\n					\n			\n			\n			\n			\n			\n			<!-- this will be automatically hidden when there are notes in the list -->\n			<li class="no-notes">\n				There are no notes yet!\n			</li>\n					\n			\n			\n			\n			\n			\n			<!-- this will be automatically hidden when there are notes in the list -->\n			<li class="no-notes">\n				There are no notes yet!\n			</li>\n					\n			\n			\n			\n			\n			\n			<!-- this will be automatically hidden when there are notes in the list -->\n			<li class="no-notes">\n				There are no notes yet!\n			</li>\n					\n			\n			\n			\n			\n			\n			<!-- this will be automatically hidden when there are notes in the list -->\n			<li class="no-notes">\n				There are no notes yet!\n			</li>\n					\n			\n			\n			\n			\n			\n			<!-- this will be automatically hidden when there are notes in the list -->\n			<li class="no-notes">\n				There are no notes yet!\n			</li>\n					\n			\n			\n			\n			\n			\n			<!-- this will be automatically hidden when there are notes in the list -->\n			<li class="no-notes">\n				There are no notes yet!\n			</li>\n					\n			\n			\n			\n			\n			\n			<!-- this will be automatically hidden when there are notes in the list -->\n			<li class="no-notes">\n				There are no notes yet!\n			</li>\n					\n			\n			\n			\n			\n			\n			<!-- this will be automatically hidden when there are notes in the list -->\n			<li class="no-notes">\n				There are no notes yet!\n			</li>\n					\n			\n			\n			\n			\n			\n			<!-- this will be automatically hidden when there are notes in the list -->\n			<li class="no-notes">\n				There are no notes yet!\n			</li>\n					\n			\n			\n			\n			\n			\n			<!-- this will be automatically hidden when there are notes in the list -->\n			<li class="no-notes">\n				There are no notes yet!\n			</li>\n					\n			\n			\n			\n			\n			\n			<!-- this will be automatically hidden when there are notes in the list -->\n			<li class="no-notes">\n				There are no notes yet!\n			</li>\n					\n			\n			\n			\n			\n			\n			<!-- this will be automatically hidden when there are notes in the list -->\n			<li class="no-notes">\n				There are no notes yet!\n			</li>\n					\n			\n			\n			\n			\n			\n			<!-- this will be automatically hidden when there are notes in the list -->\n			<li class="no-notes">\n				There are no notes yet!\n			</li>\n					\n			\n			\n			\n			\n			\n			<!-- this will be automatically hidden when there are notes in the list -->\n			<li class="no-notes">\n				There are no notes yet!\n			</li>\n					\n			\n			\n			\n			\n			\n			<!-- this will be automatically hidden when there are notes in the list -->\n			<li class="no-notes">\n				There are no notes yet!\n			</li>\n					\n			\n			\n			\n			\n			\n			<!-- this will be automatically hidden when there are notes in the list -->\n			<li class="no-notes">\n				There are no notes yet!\n			</li>\n					\n			\n			\n			\n			\n			\n			<!-- this will be automatically hidden when there are notes in the list -->\n			<li class="no-notes">\n				There are no notes yet!\n			</li>\n					\n			\n			\n			\n			\n			\n			<!-- this will be automatically hidden when there are notes in the list -->\n			<li class="no-notes">\n				There are no notes yet!\n			</li>\n		', 'client', 1, '#fffc8c', '0', ''),
(2, 'sample note desc2', '0', 0, '#ccc', '0', ''),
(4, 'rrrrrrrrrrr', 'client', 1, '#b99cfc', '0', ''),
(5, 'notenotenotenotenotenote', '0', 0, '#b99cfc', '0', ''),
(12, 'fffc8cfffc8cfffc8cfffc8', 'client', 1, '#cdcdce', '0', ''),
(9, 'as d', '0', 0, '#f8f8f8', '0', ''),
(13, 'ewf dd', '0', 0, '#9df1fe', '0', ''),
(14, 'afasvdavad', '0', 0, '#76b5fd', '0', ''),
(15, 'df ew we', 'admin', 1, '#9df1fe', '0', ''),
(16, '', 'admin', 1, '#fffc8c', '0', '');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

DROP TABLE IF EXISTS `payment`;
CREATE TABLE IF NOT EXISTS `payment` (
  `payment_id` int(11) NOT NULL AUTO_INCREMENT,
  `type` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT 'income expense',
  `amount` longtext COLLATE utf8_unicode_ci NOT NULL,
  `title` longtext COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `payment_method` longtext COLLATE utf8_unicode_ci NOT NULL,
  `invoice_number` longtext COLLATE utf8_unicode_ci NOT NULL,
  `project_id` int(11) NOT NULL,
  `timestamp` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`payment_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=27 ;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`payment_id`, `type`, `amount`, `title`, `description`, `payment_method`, `invoice_number`, `project_id`, `timestamp`) VALUES
(1, 'income', '995', 'random title39', 'test', 'paypal', '3470', 8, '1412194440'),
(2, 'income', '494', 'random title50', 'test', 'paypal', '6716', 10, '1412280840'),
(3, 'income', '309', 'random title45', 'test', 'paypal', '4812', 7, '1412367240'),
(4, 'income', '36', 'random title11', 'test', 'paypal', '9852', 6, '1412453640'),
(5, 'income', '761', 'random title10', 'test', 'paypal', '2428', 5, '1412540040'),
(6, 'income', '97', 'random title27', 'test', 'paypal', '3635', 9, '1412626440'),
(7, 'income', '121', 'random title22', 'test', 'paypal', '3067', 8, '1412712840'),
(8, 'income', '429', 'random title32', 'test', 'paypal', '3818', 7, '1412799240'),
(9, 'income', '123', 'random title18', 'test', 'paypal', '4480', 6, '1412885640'),
(10, 'income', '784', 'random title15', 'test', 'paypal', '8149', 8, '1412972040'),
(11, 'income', '521', 'random title36', 'test', 'paypal', '4417', 4, '1413058440'),
(12, 'income', '914', 'random title14', 'test', 'paypal', '5378', 9, '1413144840'),
(13, 'income', '74', 'random title11', 'test', 'paypal', '9627', 2, '1413231240'),
(14, 'income', '572', 'random title15', 'test', 'paypal', '2255', 7, '1413317640'),
(15, 'income', '518', 'random title35', 'test', 'paypal', '8860', 5, '1413404040'),
(16, 'income', '501', 'random title6', 'test', 'paypal', '5532', 10, '1413490440'),
(17, 'income', '614', 'random title42', 'test', 'paypal', '8867', 2, '1413576840'),
(18, 'income', '454', 'random title25', 'test', 'paypal', '3956', 5, '1413663240'),
(19, 'income', '113', 'random title20', 'test', 'paypal', '7396', 10, '1413749640'),
(20, 'income', '181', 'random title10', 'test', 'paypal', '4279', 1, '1413836040'),
(21, 'income', '751', 'random title7', 'test', 'paypal', '2199', 7, '1413922440'),
(22, 'income', '428', 'random title47', 'test', 'paypal', '4251', 4, '1414008840'),
(23, 'income', '297', 'random title41', 'test', 'paypal', '9027', 10, '1414095240'),
(24, 'income', '946', 'random title24', 'test', 'paypal', '1620', 1, '1414181640'),
(25, 'income', '485', 'random title8', 'test', 'paypal', '7627', 7, '1414268040'),
(26, 'income', '43.88', 'test for paypal', 'test wu payment', 'wu', '91169', 1, '1415142000');

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

DROP TABLE IF EXISTS `project`;
CREATE TABLE IF NOT EXISTS `project` (
  `project_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` longtext COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `demo_url` longtext COLLATE utf8_unicode_ci NOT NULL,
  `project_category_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `staffs` longtext COLLATE utf8_unicode_ci NOT NULL,
  `budget` longtext COLLATE utf8_unicode_ci NOT NULL,
  `timer_status` int(11) NOT NULL DEFAULT '0' COMMENT '0 running 1stopped',
  `timer_starting_timestamp` longtext COLLATE utf8_unicode_ci NOT NULL,
  `total_time_spent` int(11) NOT NULL DEFAULT '0' COMMENT 'second',
  `progress_status` longtext COLLATE utf8_unicode_ci NOT NULL,
  `timestamp_start` longtext COLLATE utf8_unicode_ci NOT NULL,
  `timestamp_end` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`project_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=37 ;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`project_id`, `title`, `description`, `demo_url`, `project_category_id`, `client_id`, `staffs`, `budget`, `timer_status`, `timer_starting_timestamp`, `total_time_spent`, `progress_status`, `timestamp_start`, `timestamp_end`) VALUES
(1, 'School Management Backend Development', 'The new backend development of the school management system for CBBC.\n\nWe will advance the project in 3 steps. Development and demonstration will be continued in each steps.\n\n-Back-end functionality described in page 2,3 and administrator features in page 4 : $3000\n-Teacher features in page 5 : $1500\n-Student features in page 6 : $1000The new backend development of the school management system for CBBC.\n\nWe will advance the project in 3 steps. Development and demonstration will be continued in each steps.\n\n-Back-end functionality described in page 2,3 and administrator features in page 4 : $3000\n-Teacher features in page 5 : $1500\n-Student features in page 6 : $1000The new backend development of the school management system for CBBC.\n\nWe will advance the project in 3 steps. Development and demonstration will be continued in each steps.\n\n-Back-end functionality described in page 2,3 and administrator features in page 4 : $3000\n-Teacher features in page 5 : $1500\n-Student features in page 6 : $1000The new backend development of the school management system for CBBC.\n\nWe will advance the project in 3 steps. Development and demonstration will be continued in each steps.\n\n-Back-end functionality described in page 2,3 and administrator features in page 4 : $3000\n-Teacher features in page 5 : $1500\n-Student features in page 6 : $1000\nThe new backend development of the school management system for CBBC.\n\nWe will advance the project in 3 steps. Development and demonstration will be continued in each steps.', 'http://google.com', 1, 125, '5,6,', '20', 0, '1163510324', 3505, '23', '12/14/2013', '12/14/2013'),
(2, 'Wordpress Designed website for limousine business', 'implement or create shopping card in wordpress, with optimizepress 2.0 theme.\ni am selling offline one online course with two payment options (1. full payment of CHF 297, 2. four installments CHF 100 each)\nso, office assistant has to capture customer, add product, choose payment type and store in database. for that i need a form where assistant can capture customer from our office.\nat store, member has to be created at optimizpress membership plugin.\nsend email to customer with confirmation and login data.\nsend invoice to customer.\nif payment arrive i have to tell this to shopping card.\nif not after time, automatically send reminder to customer.\nafter two reminder i need to export customer data to a csv.\n\nalso need to connect to my autoresponder provider. maybe first manually export csv every day of new customer, later implement API from provider.', '', 4, 2, '9,10,', '650', 0, '1912950186', 4, '100', '', ''),
(3, 'Create a car rental portal343', 'The new backend development of the school management system for CBBC. We will advance the project in 3 steps. Development and demonstration will be continued in each steps. -Back-end functionality described in page 2,3 and administrator features in page 4 : $3000 -Teacher features in page 5 : $1500 -Student features in page 6 : $1000The new backend development of the school management system for CBBC. We will advance the project in 3 steps. Development and demonstration will be continued in each steps. -Back-end functionality described in page 2,3 and administrator features in page 4 : $3000 -Teacher features in page 5 : $1500 -Student features in page<br>', 'http', 1, 7, '5,6,7,9,10,', '899', 0, '1568453530', 4, '63', '08/21/2014', '09/18/2014'),
(4, 'dummy project', '', '', 2, 7, '', '', 0, '', 0, '5', '', ''),
(5, 'wordpress theme dev', '', '', 3, 4, '', '', 0, '', 0, '', '', ''),
(6, 'woocommerce plugin', '', '', 1, 10, '', '', 0, '', 0, '100', '', ''),
(7, 'Joomla extension task', '', '', 2, 6, '', '', 0, '', 0, '', '', ''),
(8, 'safari browser extension project', 'd2<br><br>', 'http://www.codecanyon.com', 2, 2, '', '230', 0, '1791950801', 156, '35', '08/21/2014', '08/29/2014'),
(9, 'Sed qui mollit aliquid et ', '', 'codecanyon', 4, 7, '5,9,', '345', 0, '', 0, '10', '09-May-2003', '05-Jul-2014'),
(10, 'sample project (done)', 'omjojpoj<br><br>', '', 1, 1, '6,', '', 0, '1442254411', 1912926758, '37', '02/04/2015', '08/10/2014');

-- --------------------------------------------------------

--
-- Table structure for table `project_category`
--

DROP TABLE IF EXISTS `project_category`;
CREATE TABLE IF NOT EXISTS `project_category` (
  `project_category_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` longtext COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`project_category_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `project_category`
--

INSERT INTO `project_category` (`project_category_id`, `name`, `description`) VALUES
(1, 'web application', ''),
(2, 'mobile application', ''),
(3, 'psd 2 html', ''),
(4, 'graphics design', '');

-- --------------------------------------------------------

--
-- Table structure for table `project_file`
--

DROP TABLE IF EXISTS `project_file`;
CREATE TABLE IF NOT EXISTS `project_file` (
  `project_file_id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `name` longtext COLLATE utf8_unicode_ci NOT NULL,
  `visibility_client` int(11) NOT NULL DEFAULT '1' COMMENT '1visible 0hidden',
  `visibility_staff` int(11) NOT NULL DEFAULT '1' COMMENT '1visible 0hidden',
  `size` longtext COLLATE utf8_unicode_ci NOT NULL,
  `type` longtext COLLATE utf8_unicode_ci NOT NULL,
  `type_id` int(11) NOT NULL,
  `timestamp_upload` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`project_file_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=32 ;

--
-- Dumping data for table `project_file`
--

INSERT INTO `project_file` (`project_file_id`, `project_id`, `description`, `name`, `visibility_client`, `visibility_staff`, `size`, `type`, `type_id`, `timestamp_upload`) VALUES
(25, 1, 'sample html', 'iframe.html', 1, 1, '', '', 0, ''),
(18, 2, 'xc', 'banner.jpg', 1, 1, '', '', 0, ''),
(19, 31, 'l', '1.jpg', 1, 1, '', '', 0, ''),
(16, 2, 'r', 'DSC_1095.NEF', 1, 1, '', '', 0, ''),
(15, 2, 'image archive', 'Archive.zip', 1, 1, '', '', 0, ''),
(14, 2, 'lol', 'DSC_1079.NEF', 1, 1, '', '', 0, ''),
(26, 31, 'sql file', 'ekattor_dummy_data.sql', 1, 1, '', '', 0, ''),
(27, 31, 'test pdf', '2Manage Client - Ekushey Project Manager CRM.pdf', 1, 1, '', '', 0, ''),
(28, 31, 'rtgt', '2Manage Client - Ekushey Project Manager CRM.pdf', 1, 1, '', '', 0, ''),
(29, 1, 'sample pdf', '2Manage Client - Ekushey Project Manager CRM.pdf', 1, 1, '', '', 0, ''),
(31, 1, 'dummy jpg', '6N4A9255.jpg', 1, 1, '', '', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `project_message`
--

DROP TABLE IF EXISTS `project_message`;
CREATE TABLE IF NOT EXISTS `project_message` (
  `project_message_id` int(11) NOT NULL AUTO_INCREMENT,
  `message` longtext COLLATE utf8_unicode_ci NOT NULL,
  `project_id` int(11) NOT NULL,
  `date` longtext COLLATE utf8_unicode_ci NOT NULL,
  `user_type` longtext COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`project_message_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=91 ;

--
-- Dumping data for table `project_message`
--

INSERT INTO `project_message` (`project_message_id`, `message`, `project_id`, `date`, `user_type`, `user_id`) VALUES
(1, '', 31, '30 Aug', 'admin', 1),
(2, '', 31, '30 Aug', 'admin', 1),
(3, '', 31, '30 Aug', 'admin', 1),
(4, 'rtr', 31, '30 Aug', 'admin', 1),
(5, 'pop', 31, '30 Aug', 'admin', 1),
(6, 'tgy', 31, '30 Aug', 'admin', 1),
(7, 'i need to know, when the project will be completed', 31, '30 Aug', 'admin', 1),
(8, 'check my previous messages pls', 31, '30 Aug', 'admin', 1),
(9, 'so ?', 31, '30 Aug', 'admin', 1),
(10, 'yes we are going to complete it by next week', 31, '30 Aug', 'admin', 1),
(11, 'stay updated with us', 31, '30 Aug', 'admin', 1),
(12, 'anybody here ?', 30, '30 Aug', 'admin', 1),
(13, 'yreah', 30, '30 Aug', 'admin', 1),
(14, 'so ?', 30, '30 Aug', 'admin', 1),
(15, 'whats our plan guys', 30, '30 Aug', 'admin', 1),
(16, 'do it fast', 30, '30 Aug', 'admin', 1),
(17, 'ok boss', 30, '30 Aug', 'admin', 1),
(18, 'dont worry', 30, '30 Aug', 'admin', 1),
(19, 'we have started the works on this project', 31, '30 Aug', 'admin', 1),
(20, 'so ?', 31, '30 Aug', 'admin', 1),
(21, 'anything more for now ?', 31, '30 Aug', 'admin', 1),
(22, 'nothing yet', 31, '30 Aug', 'admin', 1),
(23, 'will update you when done', 31, '30 Aug', 'admin', 1),
(24, 'hello guys', 1, '30 Aug', 'admin', 1),
(25, 'any update??', 1, '30 Aug', 'admin', 1),
(26, 'helo world', 27, '30 Aug', 'admin', 1),
(27, 'so ?', 27, '30 Aug', 'admin', 1),
(28, 'what our plan today ?', 27, '30 Aug', 'admin', 1),
(29, 'hi', 1, '02 Sep', 'client', 125),
(30, 'anybody here ?', 1, '02 Sep', 'client', 125),
(31, 'so whats the update guys ?', 1, '02 Sep', 'client', 125),
(32, 'i think, we have to move on of this project', 1, '02 Sep', 'client', 125),
(33, 'good job so far', 1, '02 Sep', 'client', 125),
(34, 'ok thanks', 1, '04 Sep', 'admin', 1),
(35, 'did it', 29, '04 Sep', 'staff', 5),
(36, 'um here boss', 1, '04 Sep', 'staff', 5),
(37, 'lol', 1, '04 Sep', 'staff', 5),
(38, 'df', 31, '04 Sep', 'admin', 1),
(39, 'will update you when done', 31, '04 Sep', 'admin', 1),
(40, 'rt', 31, '04 Sep', 'admin', 1),
(41, 'we', 31, '04 Sep', 'admin', 1),
(42, 'weq', 31, '04 Sep', 'admin', 1),
(43, 'ert', 31, '04 Sep', 'admin', 1),
(44, 'df', 31, '04 Sep', 'admin', 1),
(45, 'ert', 31, '04 Sep', 'admin', 1),
(46, 'tyu', 31, '04 Sep', 'admin', 1),
(47, 'rty', 31, '04 Sep', 'admin', 1),
(48, 'popo', 31, '04 Sep', 'admin', 1),
(49, 'g', 31, '04 Sep', 'admin', 1),
(50, 'eeee', 31, '04 Sep', 'admin', 1),
(51, 'jkl', 31, '04 Sep', 'admin', 1),
(52, 'io', 31, '04 Sep', 'admin', 1),
(53, 'lolpp', 31, '04 Sep', 'admin', 1),
(54, 'sd', 31, '04 Sep', 'admin', 1),
(55, 'qwe', 31, '04 Sep', 'admin', 1),
(56, 'erty', 31, '04 Sep', 'admin', 1),
(57, 'lololo', 31, '04 Sep', 'admin', 1),
(58, 'j', 31, '04 Sep', 'admin', 1),
(59, 'h', 31, '04 Sep', 'admin', 1),
(60, 'ui', 31, '04 Sep', 'admin', 1),
(61, 'rty', 31, '04 Sep', 'admin', 1),
(62, 'qw', 31, '04 Sep', 'admin', 1),
(63, 'sd', 1, '04 Sep', 'staff', 5),
(64, 'qw', 1, '04 Sep', 'staff', 5),
(65, 'df', 1, '04 Sep', 'staff', 5),
(66, 'gh', 1, '04 Sep', 'staff', 5),
(67, 'rt', 1, '04 Sep', 'staff', 5),
(68, 'ert', 1, '04 Sep', 'staff', 5),
(69, 'df', 1, '04 Sep', 'staff', 5),
(70, 'rtrtrtyrty', 1, '04 Sep', 'staff', 5),
(71, 'lllll', 1, '04 Sep', 'staff', 5),
(72, 'xcvvxc', 1, '04 Sep', 'staff', 5),
(73, 'asdfg', 1, '04 Sep', 'staff', 5),
(74, 'mnbmmvvbn', 1, '04 Sep', 'staff', 5),
(75, 'lplp', 1, '04 Sep', 'staff', 5),
(76, 'asdf', 1, '04 Sep', 'staff', 5),
(77, 'ok dude', 1, '04 Sep', 'admin', 1),
(78, 'go on', 1, '04 Sep', 'admin', 1),
(79, 'thanks boss', 1, '04 Sep', 'staff', 5),
(80, 'hello all', 32, '05 Sep', 'staff', 5),
(81, 'good job guys', 1, '05 Sep', 'client', 125),
(82, 'thanks', 1, '05 Sep', 'client', 125),
(83, 'so when can i get next upate then', 1, '05 Sep', 'client', 125),
(84, 'ok', 1, '05 Sep', 'client', 125),
(85, 'gd', 1, '06 Sep', 'client', 125),
(86, 'hi guys, whats the update today', 1, '06 Sep', 'client', 125),
(87, 'yes mam, we are working upon it', 1, '06 Sep', 'staff', 5),
(88, 'thanks for your message', 1, '06 Sep', 'staff', 5),
(89, 'fg', 30, '15 Sep', 'admin', 1),
(90, '??', 1, '28 Sep', 'client', 125);

-- --------------------------------------------------------

--
-- Table structure for table `project_task`
--

DROP TABLE IF EXISTS `project_task`;
CREATE TABLE IF NOT EXISTS `project_task` (
  `project_task_id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `title` longtext COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `complete_status` int(11) NOT NULL,
  `status` longtext COLLATE utf8_unicode_ci NOT NULL,
  `timestamp_start` longtext COLLATE utf8_unicode_ci NOT NULL,
  `timestamp_end` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`project_task_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=153 ;

--
-- Dumping data for table `project_task`
--

INSERT INTO `project_task` (`project_task_id`, `project_id`, `title`, `description`, `complete_status`, `status`, `timestamp_start`, `timestamp_end`) VALUES
(148, 32, 'test w', '', 0, '', '', ''),
(151, 22, 'test for paypal', '', 0, '', '', ''),
(56, 1, 'database design', '', 1, '', '', ''),
(57, 1, 'interface plan on paper', '', 1, '', '', ''),
(74, 31, 'qwq', '', 0, '', '', ''),
(62, 30, 'toyota', '', 0, '', '', ''),
(59, 1, 'view coding', '', 0, '', '', ''),
(65, 1, 'gh', '', 0, '', '', ''),
(64, 30, 'bmw', '', 0, '', '', ''),
(145, 31, 'fg', '', 0, '', '', ''),
(58, 1, 'controller coding', '', 1, '', '', ''),
(146, 1, 'df', '', 1, '', '', ''),
(125, 2, 'qqq', '', 0, '', '', ''),
(128, 2, 'hg', '', 0, '', '', ''),
(129, 2, 'de', '', 1, '', '', ''),
(143, 27, 'this is another task', '', 0, '', '', ''),
(137, 31, 'sample task2', '', 1, '', '', ''),
(138, 31, 'sample task3', '', 0, '', '', ''),
(140, 31, 'weert', '', 0, '', '', ''),
(141, 31, 'dfg', '', 0, '', '', ''),
(142, 27, 'this is a new task for you', '', 1, '', '', ''),
(124, 2, 'we', '', 0, '', '', ''),
(152, 10, 'ts', '', 0, '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `quote`
--

DROP TABLE IF EXISTS `quote`;
CREATE TABLE IF NOT EXISTS `quote` (
  `quote_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` longtext COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `timestamp` longtext COLLATE utf8_unicode_ci NOT NULL,
  `amount` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`quote_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

DROP TABLE IF EXISTS `schedule`;
CREATE TABLE IF NOT EXISTS `schedule` (
  `schedule_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_type` longtext COLLATE utf8_unicode_ci NOT NULL,
  `user_id` longtext COLLATE utf8_unicode_ci NOT NULL,
  `title` longtext COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `timestamp` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`schedule_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
CREATE TABLE IF NOT EXISTS `settings` (
  `settings_id` int(11) NOT NULL AUTO_INCREMENT,
  `type` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`settings_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`settings_id`, `type`, `description`) VALUES
(1, 'system_name', 'Ekushey Project Manager CRM'),
(2, 'system_title', 'Ekushey Project Manager CRM'),
(3, 'address', 'Dhaka, Bangladesh'),
(4, 'phone', '+8012654159'),
(5, 'paypal_email', 'payment@creativeitem.com'),
(6, 'currency', 'usd'),
(7, 'system_email', 'admin@example.com'),
(8, 'buyer', '[ your-codecanyon-username-here ]'),
(9, 'purchase_code', '[ your-purchase-code-here ]'),
(11, 'language', 'english'),
(12, 'text_align', 'left-to-right'),
(13, 'system_currency_id', '4');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

DROP TABLE IF EXISTS `staff`;
CREATE TABLE IF NOT EXISTS `staff` (
  `staff_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` longtext COLLATE utf8_unicode_ci NOT NULL,
  `email` longtext COLLATE utf8_unicode_ci NOT NULL,
  `password` longtext COLLATE utf8_unicode_ci NOT NULL,
  `account_role_id` int(11) NOT NULL,
  `phone` longtext COLLATE utf8_unicode_ci NOT NULL,
  `skype_id` longtext COLLATE utf8_unicode_ci NOT NULL,
  `facebook_profile_link` longtext COLLATE utf8_unicode_ci NOT NULL,
  `twitter_profile_link` longtext COLLATE utf8_unicode_ci NOT NULL,
  `linkedin_profile_link` longtext COLLATE utf8_unicode_ci NOT NULL,
  `chat_status` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'offline',
  PRIMARY KEY (`staff_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=12 ;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staff_id`, `name`, `email`, `password`, `account_role_id`, `phone`, `skype_id`, `facebook_profile_link`, `twitter_profile_link`, `linkedin_profile_link`, `chat_status`) VALUES
(5, 'Craig Bryant', 'staff@example.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 1, '324234', 'rty', '', '', '', 'offline'),
(6, 'Lola House', 'fyva@gmail.com', '12345', 5, '', '', '', '', '', 'online'),
(7, 'Amal Barry', 'vumiwib@yahoo.com', 'Tempora quam accusamus dolore non nisi soluta aliquam facere obcaecati rerum iusto velit qui', 6, '+453-12-6798400', 'test_skype', '', '', '', 'offline'),
(9, 'lrtyuiopoo', 'i', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', 5, '', '', '', '', '', 'offline'),
(10, 'der23', '', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', 1, '', '', '', '', '', 'offline');

-- --------------------------------------------------------

--
-- Table structure for table `ticket`
--

DROP TABLE IF EXISTS `ticket`;
CREATE TABLE IF NOT EXISTS `ticket` (
  `ticket_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` longtext COLLATE utf8_unicode_ci NOT NULL,
  `ticket_code` longtext COLLATE utf8_unicode_ci NOT NULL,
  `status` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT 'opened closed',
  `priority` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT 'high medium low',
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `client_id` int(11) NOT NULL,
  `assigned_staff_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `timestamp` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ticket_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;

--
-- Dumping data for table `ticket`
--

INSERT INTO `ticket` (`ticket_id`, `title`, `ticket_code`, `status`, `priority`, `description`, `client_id`, `assigned_staff_id`, `project_id`, `timestamp`) VALUES
(1, '07-Apr-1998', '572106', 'closed', 'low', '', 1, 5, 0, '0'),
(2, '07-Aug-1997', '426196', 'closed', 'high', '', 1, 0, 0, '0'),
(3, '23-Oct-1979', '410544', 'opened', 'medium', '', 1, 0, 0, '0'),
(4, 'ert', '974629632833dbe', 'opened', '0', '', 125, 0, 0, '06 Sep,2014'),
(5, 'installation problem', '26e7b64f4488280', 'opened', '0', '', 125, 0, 0, '06 Sep,2014'),
(6, 'another support', '04d46da8f394b39', 'opened', 'medium', '', 125, 5, 1, '06 Sep,2014'),
(7, 'good support', 'cd0f789c8ecbdfb', 'closed', 'high', '', 125, 5, 1, '06 Sep,2014'),
(8, 'আজকের দিনটি কেমন যাবে', '091dd9e85a43fd0', 'closed', 'low', '', 125, 5, 0, '06 Sep,2014'),
(9, '0', '1e1648f59aab682', 'opened', '0', '', 125, 0, 0, '07 Nov,2014');

-- --------------------------------------------------------

--
-- Table structure for table `ticket_message`
--

DROP TABLE IF EXISTS `ticket_message`;
CREATE TABLE IF NOT EXISTS `ticket_message` (
  `ticket_message_id` int(11) NOT NULL AUTO_INCREMENT,
  `ticket_code` longtext COLLATE utf8_unicode_ci NOT NULL,
  `message` longtext COLLATE utf8_unicode_ci NOT NULL,
  `file` longtext COLLATE utf8_unicode_ci NOT NULL,
  `sender_type` longtext COLLATE utf8_unicode_ci NOT NULL,
  `sender_id` int(11) NOT NULL,
  `timestamp` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ticket_message_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=27 ;

--
-- Dumping data for table `ticket_message`
--

INSERT INTO `ticket_message` (`ticket_message_id`, `ticket_code`, `message`, `file`, `sender_type`, `sender_id`, `timestamp`) VALUES
(1, '974629632833dbe', '', '', 'client', 125, '06 Sep,2014'),
(2, '26e7b64f4488280', 'hellow guys, help me pls', '', 'client', 125, '06 Sep,2014'),
(3, '04d46da8f394b39', 'ok got it.', '', 'client', 125, '06 Sep,2014'),
(4, 'cd0f789c8ecbdfb', '', '', 'client', 125, '06 Sep,2014'),
(5, '091dd9e85a43fd0', '', '', 'client', 125, '06 Sep,2014'),
(6, 'cd0f789c8ecbdfb', 'fgfg', '', 'client', 125, '06 Sep,2014'),
(7, 'cd0f789c8ecbdfb', 'ok good', '', 'client', 125, '06 Sep,2014'),
(8, '091dd9e85a43fd0', 'ভালো অবশ্যই', '', 'client', 125, '06 Sep,2014'),
(9, '091dd9e85a43fd0', 'এক্সচ', '', 'client', 125, '06 Sep,2014'),
(10, '091dd9e85a43fd0', 'যক্স', '', 'client', 125, '06 Sep,2014'),
(11, '091dd9e85a43fd0', 'জাঁক', '', 'client', 125, '06 Sep,2014'),
(12, '091dd9e85a43fd0', 'কওয়ের', '', 'client', 125, '06 Sep,2014'),
(13, '091dd9e85a43fd0', 'zxcwer', '', 'client', 125, '06 Sep,2014'),
(14, '091dd9e85a43fd0', 'df', '', 'admin', 1, '06 Sep,2014'),
(15, '091dd9e85a43fd0', 'okkzz', '', 'admin', 1, '06 Sep,2014'),
(16, '26e7b64f4488280', 'pls send us your \n-purchase code\n-cpanel login info\n-the software name', '', 'admin', 1, '06 Sep,2014'),
(17, '26e7b64f4488280', 'thanks for quick reply', '', 'client', 125, '06 Sep,2014'),
(18, 'cd0f789c8ecbdfb', 'Thank you :)', '', 'admin', 1, '06 Sep,2014'),
(19, 'cd0f789c8ecbdfb', 'c', '', 'admin', 1, '06 Sep,2014'),
(20, 'cd0f789c8ecbdfb', 'asd', '', 'admin', 1, '06 Sep,2014'),
(21, '26e7b64f4488280', 'ok, i will check it ASAP', '', 'staff', 5, '06 Sep,2014'),
(22, '572106', '??', '', 'staff', 5, '06 Sep,2014'),
(23, '091dd9e85a43fd0', 'adad', '', 'admin', 1, '15 Sep,2014'),
(24, '091dd9e85a43fd0', 'uvuv', '', 'admin', 1, '19 Sep,2014'),
(25, '091dd9e85a43fd0', 'ok will do', '', 'staff', 5, '28 Sep,2014'),
(26, '1e1648f59aab682', '0', '', 'client', 125, '07 Nov,2014');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
