-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 14, 2021 at 12:45 PM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 7.4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `books_buying_selling`
--

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `id` int(11) NOT NULL,
  `article_name` varchar(100) NOT NULL,
  `text` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`id`, `article_name`, `text`) VALUES
(1, 'about_us', '<p><strong>&nbsp; &nbsp; &nbsp; &nbsp; Lorem ipsum</strong> dolor sit amet consectetur adipisicing elit. Ea, ullam cupiditate perferendis praesentium rerum sit fugiat magnam laboriosam architecto laudantium. Debitis fugit maxime dolores cum accusantium porro hic sed aliquid? Repellendus velit beatae dignissimos fugiat nobis repudiandae non quia minima possimus laboriosam aliquam aliquid vel, qui inventore iusto consequatur ipsa odit similique incidunt corrupti accusantium voluptates adipisci amet laudantium. Deserunt? Reprehenderit praesentium hic voluptate, veritatis nemo nam repellendus quis architecto. Architecto tenetur magni exercitationem natus consectetur, odio pariatur! Eveniet eum necessitatibus quam consequatur ipsum hic est consequuntur deleniti laudantium suscipit. Adipisci, corporis? Enim, dolorum nam, sint repellendus porro reprehenderit non perferendis quia laboriosam exercitationem quasi nemo alias! Soluta, suscipit voluptas tempore est nostrum vitae sit incidunt quibusdam culpa, cupiditate perferendis? Reiciendis incidunt natus nisi quasi, voluptas magni possimus nam similique quos debitis cupiditate doloribus minus ex odio vitae vel esse sequi. Accusamus, qui consequuntur aliquam numquam sequi ratione fugit distinctio! Culpa debitis ratione, architecto, recusandae excepturi inventore commodi aperiam perspiciatis, eligendi explicabo nulla nemo hic? Velit expedita alias soluta. Veniam perferendis in voluptatibus asperiores saepe repellat quaerat illum velit itaque! Tenetur facere tempore corporis eligendi et officiis deserunt atque ducimus fugiat asperiores? Eius, autem quo modi a sequi quod aliquid non ex vitae consequuntur consectetur enim temporibus dolor placeat veritatis. Ipsa nobis, doloremque at magnam, reiciendis reprehenderit earum sed aliquid aliquam modi quo impedit praesentium, laudantium odio mollitia officiis itaque voluptas est? Provident enim vitae, sit aut mollitia ducimus exercitationem? Itaque sint cum, recusandae placeat nisi aliquid rerum quibusdam distinctio architecto asperiores ratione totam, aspernatur facilis unde, dignissimos delectus vitae hic magni temporibus sapiente? Consectetur facere nulla nesciunt provident reprehenderit. Obcaecati esse consequuntur, eveniet quos fugiat fuga dolores molestiae blanditiis dolore ea. Dolorum, earum tempore reiciendis similique repellendus voluptas culpa excepturi voluptate delectus eveniet tempora minus vel ullam eum deleniti! Libero quo debitis officiis. Suscipit nobis vero soluta, dolore excepturi sapiente fugit recusandae libero earum, eligendi totam quasi praesentium. Atque doloribus similique maxime quibusdam fugiat doloremque eaque facilis quo molestias? Repellendus quibusdam odio deleniti doloremque ipsa enim itaque, voluptate, tempora cum laudantium, excepturi officiis ullam saepe odit! Eaque ducimus provident amet molestiae reprehenderit quasi. Voluptatibus rem nisi repudiandae ratione quibusdam. Explicabo ipsa eius maxime consequatur fugiat illum dignissimos nostrum at dicta magni totam numquam, quas accusamus eveniet consequuntur dolores aliquam unde soluta autem vero cum placeat deleniti! Minus, aliquid accusamus. Ipsa nulla at facilis ipsam, dolorum commodi saepe numquam impedit aperiam fugiat quis nesciunt, iusto suscipit tenetur ex! Tenetur culpa, modi amet officiis numquam libero ex molestiae nihil quasi? A? Molestias ratione dignissimos, blanditiis voluptates exercitationem esse non mollitia temporibus? Quidem consequatur nemo earum excepturi nobis minima autem obcaecati incidunt! Nam, perspiciatis! Corrupti labore sequi sint molestias sit consectetur perspiciatis.</p>');

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `user_id` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `name`) VALUES
(1, 'Gujranwla,Pakistan'),
(2, 'Lahore,Pakistan'),
(3, 'Karachi,Pakistan'),
(4, 'Islamabad,Pakistan');

-- --------------------------------------------------------

--
-- Table structure for table `featured_items`
--

CREATE TABLE `featured_items` (
  `feature_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `landing_page_visibility` tinyint(4) NOT NULL,
  `slider_visibility` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `featured_items`
--

INSERT INTO `featured_items` (`feature_id`, `item_id`, `landing_page_visibility`, `slider_visibility`) VALUES
(14, 22, 1, 0),
(15, 21, 1, 1),
(16, 25, 1, 0),
(17, 26, 1, 1),
(18, 24, 1, 1),
(19, 23, 1, 1),
(20, 28, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `invoice_id` int(11) NOT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `title` varchar(40) NOT NULL,
  `publisher_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `image_url` varchar(100) DEFAULT NULL,
  `stock_quantity` int(11) NOT NULL,
  `unit_price` int(11) NOT NULL,
  `visibility_status` tinyint(4) NOT NULL,
  `city` varchar(40) DEFAULT NULL,
  `country` varchar(40) DEFAULT NULL,
  `apply_details` text DEFAULT NULL,
  `seller_id` varchar(100) NOT NULL,
  `author` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `title`, `publisher_id`, `category_id`, `description`, `image_url`, `stock_quantity`, `unit_price`, `visibility_status`, `city`, `country`, `apply_details`, `seller_id`, `author`) VALUES
(22, 'The Midnight Library', 13, 9, '<p><span style=\"text-decoration: underline;\"><em><strong>Chosen from bi</strong></em></span>rth to usher in a new era, Poppy&rsquo;s life has never been her own. The life of the Maiden is solitary. Never to be touched. Never to be looked upon. Never to be spoken to. Never to experience pleasure. Waiting for the day of her Ascension, she would rather be with the guards, fighting back the evil that took her family, than preparing to be found worthy by the gods. But the choice has never been hers.</p>', 'uploads/posts/post_img_15771093.png', 35, 1500, 1, 'Lahore', 'Pakistan', NULL, 'feroza', NULL),
(23, 'The Vanishing Half', 21, 6, '<p>The Vignes twin sisters will always be identical. But after growing up together in a small, southern black community and running away at age sixteen, it\'s not just the shape of their daily lives that is different as adults, it\'s everything: their families, their communities, their racial identities. Many years later, one sister lives with her black daughter in the same southern town she once tried to escape. The other passes for white, and her white husband knows nothing of her past. Still, even separated by so many miles and just as many lies, the fates of the twins remain intertwined. What will happen to the next generation, when their own daughters\' storylines intersect?</p>', 'uploads/posts/post_img_83105990.png', 33, 2100, 1, 'Lahore', 'Pakistan', NULL, 'MC190405263', NULL),
(24, 'House of Earth and Blood', 16, 11, '<p>Bryce Quinlan had the perfect life&mdash;working hard all day and partying all night&mdash;until a demon murdered her closest friends, leaving her bereft, wounded, and alone. When the accused is behind bars but the crimes start up again, Bryce finds herself at the heart of the investigation. She&rsquo;ll do whatever it takes to avenge their deaths.</p>', 'uploads/posts/post_img_18109479.png', 55, 3100, 1, 'Karachi', 'Pakistan', NULL, 'MC190405263', NULL),
(25, 'From Blood and Ash', 15, 5, '<p>Chosen from birth to usher in a new era, Poppy&rsquo;s life has never been her own. The life of the Maiden is solitary. Never to be touched. Never to be looked upon. Never to be spoken to. Never to experience pleasure. Waiting for the day of her Ascension, she would rather be with the guards, fighting back the evil that took her family, than preparing to be found worthy by the gods. But the choice has never been hers.</p>', 'uploads/posts/post_img_35343596.png', 42, 2200, 1, 'Islamabad', 'Pakistan', NULL, 'MC190405263', NULL),
(26, 'To Sleep in a Sea of Stars', 14, 6, '<p>Kira Nav&aacute;rez dreamed of life on new worlds. Now she\'s awakened a nightmare. During a routine survey mission on an uncolonized planet, Kira finds an alien relic. At first she\'s delighted, but elation turns to terror when the ancient dust around her begins to move.</p>', 'uploads/posts/post_img_12727923.png', 32, 1100, 1, 'Islamabad', 'Pakistan', NULL, 'feroza', NULL),
(28, 'Mexican Goth', 19, 11, '<p>After receiving a frantic letter from her newly-wed cousin begging for someone to save her from a mysterious doom, Noem&iacute; Taboada heads to High Place, a distant house in the Mexican countryside. She&rsquo;s not sure what she will find&mdash;her cousin&rsquo;s husband, a handsome Englishman, is a stranger, and Noem&iacute; knows little about the region.</p>', 'uploads/posts/post_img_62125519.png', 23, 1600, 1, 'Lahore', 'Pakistan', NULL, 'MC190405263', NULL),
(29, 'Ubuntu Beginners Guide', 9, 8, '<p>A complete beginner\'s guide to Up and running with Ubuntu Studio&nbsp;</p>', 'uploads/posts/post_img_1589048.jpg', 25, 2500, 0, 'Lahore', 'Pakistan', NULL, 'MC200201266', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `item_categories`
--

CREATE TABLE `item_categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(40) NOT NULL,
  `parent_category` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `item_categories`
--

INSERT INTO `item_categories` (`category_id`, `category_name`, `parent_category`) VALUES
(5, 'Not Thriller', NULL),
(6, 'Fiction', NULL),
(7, 'Motivational Stories', NULL),
(8, 'Self Help ', NULL),
(9, 'Novels ', NULL),
(10, 'Science Fiction', NULL),
(11, 'Horror', NULL),
(12, 'History', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `buyer_id` varchar(100) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`buyer_id`, `invoice_id`, `item_id`, `order_id`, `quantity`, `status`, `time_stamp`) VALUES
('saimabibi', 760964, 26, 7, 3, 1, '2021-10-20 11:44:46'),
('saimabibi', 221075, 26, 8, 3, 1, '2021-10-20 11:47:31'),
('saimabibi', 333364, 25, 9, 4, 1, '2021-11-03 15:05:59'),
('saimabibi', 881699, 24, 10, 2, 1, '2021-11-03 15:05:59');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_otp`
--

CREATE TABLE `password_reset_otp` (
  `id` int(11) NOT NULL,
  `otp` int(9) NOT NULL,
  `username` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `password_reset_otp`
--

INSERT INTO `password_reset_otp` (`id`, `otp`, `username`) VALUES
(9, 686292142, 'lubna');

-- --------------------------------------------------------

--
-- Table structure for table `publishers`
--

CREATE TABLE `publishers` (
  `publisher_id` int(11) NOT NULL,
  `publisher_name` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `publishers`
--

INSERT INTO `publishers` (`publisher_id`, `publisher_name`) VALUES
(9, 'Wiley'),
(10, 'Scholastic'),
(11, 'Apress'),
(12, 'N/A'),
(13, 'Doubleday Canada'),
(14, 'Flatiron Books'),
(15, 'Simon and Schuster UK'),
(16, 'St. Martin\'s Press'),
(17, 'Henry Holt and Company'),
(18, 'Tor Books'),
(19, 'Del Rey'),
(20, 'Morrow Gift'),
(21, 'Little, Brown Books');

-- --------------------------------------------------------

--
-- Table structure for table `resume`
--

CREATE TABLE `resume` (
  `username` varchar(100) NOT NULL,
  `resume` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `resume`
--

INSERT INTO `resume` (`username`, `resume`) VALUES
('lubna', '<p>This is Lubna\'s Resume...</p>'),
('MC190400568', '<p>This is&nbsp;Admin\'s&nbsp;resume!!!</p>'),
('MC200202202', '<h1 style=\"text-align: center;\"><span style=\"color: #0000ff;\">My Resume</span></h1>\r\n<p>This is a sample resume with the following points:</p>\r\n<ul>\r\n<li>Point One</li>\r\n<li>Point Two</li>\r\n<li>Point Three</li>\r\n</ul>'),
('saadahmed', '<p>This is Saad\'s Resume</p>'),
('saeedali', '<h1 style=\"text-align: center;\">My Resume</h1>\r\n<p>This is my resume.</p>\r\n<p>Some resons to hire me:</p>\r\n<ul>\r\n<li>Reason 1</li>\r\n<li>Reason 2</li>\r\n<li>Reason 3</li>\r\n</ul>');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `approval` tinyint(4) NOT NULL,
  `join_on` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `passwordHash` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `user_type` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`approval`, `join_on`, `passwordHash`, `username`, `user_type`) VALUES
(1, '2021-11-03 14:46:18', '1d1fd0d223700e4cc3ea2f19f836d367', 'feroza', 3),
(1, '2021-10-17 10:02:33', '1ca2a4b7a35276a98f29b0c4daa6851f', 'lubna', 2),
(1, '2021-10-22 06:57:13', '1d1fd0d223700e4cc3ea2f19f836d367', 'MC200201266', 1),
(1, '2021-10-17 09:58:25', '1ca2a4b7a35276a98f29b0c4daa6851f', 'saadahmed', 3),
(1, '2021-10-18 05:05:28', '1d1fd0d223700e4cc3ea2f19f836d367', 'saeedali', 3),
(1, '2021-10-19 14:57:54', '1d1fd0d223700e4cc3ea2f19f836d367', 'saimabibi', 2),
(1, '2021-11-14 06:11:06', '1d1fd0d223700e4cc3ea2f19f836d367', 'salmanahmed', 3),
(1, '2021-10-18 07:14:42', '1d1fd0d223700e4cc3ea2f19f836d367', 'shahidhameed', 3);

-- --------------------------------------------------------

--
-- Stand-in structure for view `user_details`
-- (See below for the actual view)
--
CREATE TABLE `user_details` (
`Approval` tinyint(4)
,`username` varchar(100)
,`First Name` varchar(40)
,`Last Name` varchar(40)
,`User Type` varchar(40)
,`Joining Date` timestamp
,`Date of Birth` date
,`CNIC Number` varchar(40)
,`Street Address` text
,`City` varchar(40)
,`Country` varchar(40)
,`user_type_id` int(11)
,`display_pic_url` varchar(100)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `user_details_t`
-- (See below for the actual view)
--
CREATE TABLE `user_details_t` (
`Approval` tinyint(4)
,`username` varchar(100)
,`passwordHash` varchar(100)
,`First Name` varchar(40)
,`Last Name` varchar(40)
,`User Type` varchar(40)
,`Joining Date` timestamp
,`Date of Birth` date
,`CNIC Number` varchar(40)
,`Street Address` text
,`City` varchar(40)
,`Country` varchar(40)
,`user_type_id` int(11)
,`display_pic_url` varchar(100)
);

-- --------------------------------------------------------

--
-- Table structure for table `user_info`
--

CREATE TABLE `user_info` (
  `cell_no` varchar(40) NOT NULL,
  `city` varchar(40) NOT NULL,
  `cnic` varchar(40) DEFAULT NULL,
  `country` varchar(40) NOT NULL,
  `date_of_birth` date NOT NULL,
  `display_pic_url` varchar(100) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `firstname` varchar(40) NOT NULL,
  `gender` varchar(40) DEFAULT NULL,
  `lastname` varchar(40) NOT NULL,
  `street_address` text NOT NULL,
  `username` varchar(100) NOT NULL,
  `email_alerts` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_info`
--

INSERT INTO `user_info` (`cell_no`, `city`, `cnic`, `country`, `date_of_birth`, `display_pic_url`, `email`, `firstname`, `gender`, `lastname`, `street_address`, `username`, `email_alerts`) VALUES
('03001234567', 'Karachi', '3410298875263', 'Pakistan', '2000-11-18', NULL, 'feroza@gmail.com', 'Feroza', 'female', 'Hassan', 'Street#1', 'feroza', 1),
('03001234567', 'Lahore', '3410298875263', 'Pakistan', '2000-11-18', NULL, 'lubnashaheen@gmail.com', 'Lubna', 'female', 'Shaheen', 'Street#2', 'lubna', 1),
('03001234567', 'Lahore', '3410107733559', 'Pakistan', '2011-12-01', NULL, 'ehtisham@gmail.com', 'Ehtisham A', 'female', 'Haider', 'street#1', 'MC200201266', 0),
('03001234567', 'Islamabad', '3410298875263', 'Pakistan', '2003-11-16', 'uploads/display_pics/saadahmed.jpg', 'saadahmed@gmail.com', 'Saad', 'male', 'Ahmed', 'Street#3', 'saadahmed', 0),
('03001234567', 'Lahore', '3410298875263', 'Pakistan', '2003-11-16', 'uploads/display_pics/saeedali.jpg', 'saeedali@gmail.com', 'Saeed', 'male', 'Ali', 'Street#1', 'saeedali', 0),
('03001234567', 'Lahore', '3410107733559', 'Pakistan', '2008-01-01', NULL, 'saima@gmail.com', 'Saima', 'female', 'Bibi', 'street#1', 'saimabibi', 0),
('03001234567', 'Islamabad', '3410107733559', 'Pakistan', '2001-01-01', 'uploads/display_pics/salmanahmed.jpg', 'salmanah@gmail.com', 'Salman', 'male', 'Ahmed', 'street#1', 'salmanahmed', 0),
('03001234567', 'Karachi', '3410107733559', 'Pakistan', '1997-01-01', 'uploads/display_pics/shahidhameed.jpg', 'shahidhameed@gmail.com', 'Shahid', 'male', 'Hameed', 'street#1', 'shahidhameed', 0);

-- --------------------------------------------------------

--
-- Stand-in structure for view `user_list`
-- (See below for the actual view)
--
CREATE TABLE `user_list` (
`username` varchar(100)
,`fullname` varchar(81)
,`user_type_title` varchar(40)
,`join_on` timestamp
,`display_pic_url` varchar(100)
);

-- --------------------------------------------------------

--
-- Table structure for table `user_types`
--

CREATE TABLE `user_types` (
  `user_type_id` int(11) NOT NULL,
  `user_type_title` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_types`
--

INSERT INTO `user_types` (`user_type_id`, `user_type_title`) VALUES
(1, 'admin'),
(2, 'buyer'),
(3, 'seller');

-- --------------------------------------------------------

--
-- Structure for view `user_details`
--
DROP TABLE IF EXISTS `user_details`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `user_details`  AS SELECT `users`.`approval` AS `Approval`, `user_info`.`username` AS `username`, `user_info`.`firstname` AS `First Name`, `user_info`.`lastname` AS `Last Name`, `user_types`.`user_type_title` AS `User Type`, `users`.`join_on` AS `Joining Date`, `user_info`.`date_of_birth` AS `Date of Birth`, `user_info`.`cnic` AS `CNIC Number`, `user_info`.`street_address` AS `Street Address`, `user_info`.`city` AS `City`, `user_info`.`country` AS `Country`, `users`.`user_type` AS `user_type_id`, `user_info`.`display_pic_url` AS `display_pic_url` FROM ((`users` join `user_info`) join `user_types`) WHERE `users`.`username` = `user_info`.`username` AND `users`.`user_type` = `user_types`.`user_type_id` ;

-- --------------------------------------------------------

--
-- Structure for view `user_details_t`
--
DROP TABLE IF EXISTS `user_details_t`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `user_details_t`  AS SELECT `user_details`.`Approval` AS `Approval`, `user_details`.`username` AS `username`, `users`.`passwordHash` AS `passwordHash`, `user_details`.`First Name` AS `First Name`, `user_details`.`Last Name` AS `Last Name`, `user_details`.`User Type` AS `User Type`, `user_details`.`Joining Date` AS `Joining Date`, `user_details`.`Date of Birth` AS `Date of Birth`, `user_details`.`CNIC Number` AS `CNIC Number`, `user_details`.`Street Address` AS `Street Address`, `user_details`.`City` AS `City`, `user_details`.`Country` AS `Country`, `user_details`.`user_type_id` AS `user_type_id`, `user_details`.`display_pic_url` AS `display_pic_url` FROM (`users` join `user_details`) WHERE `users`.`username` = `user_details`.`username` ;

-- --------------------------------------------------------

--
-- Structure for view `user_list`
--
DROP TABLE IF EXISTS `user_list`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `user_list`  AS SELECT `users`.`username` AS `username`, concat(`user_info`.`firstname`,' ',`user_info`.`lastname`) AS `fullname`, `user_types`.`user_type_title` AS `user_type_title`, `users`.`join_on` AS `join_on`, `user_info`.`display_pic_url` AS `display_pic_url` FROM ((`users` join `user_info`) join `user_types`) WHERE `users`.`username` = `user_info`.`username` AND `users`.`user_type` = `user_types`.`user_type_id` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `featured_items`
--
ALTER TABLE `featured_items`
  ADD PRIMARY KEY (`feature_id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`invoice_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_categories`
--
ALTER TABLE `item_categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `password_reset_otp`
--
ALTER TABLE `password_reset_otp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `publishers`
--
ALTER TABLE `publishers`
  ADD PRIMARY KEY (`publisher_id`);

--
-- Indexes for table `resume`
--
ALTER TABLE `resume`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `user_info`
--
ALTER TABLE `user_info`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `user_types`
--
ALTER TABLE `user_types`
  ADD PRIMARY KEY (`user_type_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `featured_items`
--
ALTER TABLE `featured_items`
  MODIFY `feature_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `invoice_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `item_categories`
--
ALTER TABLE `item_categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `password_reset_otp`
--
ALTER TABLE `password_reset_otp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `publishers`
--
ALTER TABLE `publishers`
  MODIFY `publisher_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `user_types`
--
ALTER TABLE `user_types`
  MODIFY `user_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
