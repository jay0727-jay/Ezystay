-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/


SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ezystay`
-- User: `ezystay_user`
-- Password:   `password`
--
DROP DATABASE IF EXISTS ezystay;
CREATE DATABASE IF NOT EXISTS ezystay;

DROP USER IF EXISTS'ezystay_user'@'%';
CREATE USER IF NOT EXISTS 'ezystay_user'@'%' IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON ezystay.* TO 'ezystay_user'@'%';
USE ezystay;

-- --------------------------------------------------------

--
-- Table structure for table `emp_login`
--

CREATE TABLE `emp_login` (
  `empid` int(100) NOT NULL,
  `Emp_Email` varchar(50) NOT NULL,
  `Emp_Password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `emp_login`
--

INSERT INTO `emp_login` (`empid`, `Emp_Email`, `Emp_Password`) VALUES
(4, 'admin@gmail.com', '1234');
INSERT INTO `emp_login` (`empid`, `Emp_Email`, `Emp_Password`) VALUES
(2, 'manager@gmail.com', '1234');
INSERT INTO `emp_login` (`empid`, `Emp_Email`, `Emp_Password`) VALUES
(3, 'staff@gmail.com', '1234');
-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `id` int(30) NOT NULL,
  `Name` varchar(30) NOT NULL,
  `Email` varchar(30) NOT NULL,
  `RoomType` varchar(30) NOT NULL,
  `Bed` varchar(30) NOT NULL,
  `NoofRoom` int(30) NOT NULL,
  `cin` date NOT NULL,
  `cout` date NOT NULL,
  `noofdays` int(30) NOT NULL,
  `roomtotal` double(8,2) NOT NULL,
  `bedtotal` double(8,2) NOT NULL,
  `meal` varchar(30) NOT NULL,
  `mealtotal` double(8,2) NOT NULL,
  `finaltotal` double(8,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`id`, `Name`, `Email`, `RoomType`, `Bed`, `NoofRoom`, `cin`, `cout`, `noofdays`, `roomtotal`, `bedtotal`, `meal`, `mealtotal`, `finaltotal`) VALUES
(41, 'Jay', 'jay9@gmail.com', 'Single Room', 'Single', 1, '2022-11-09', '2022-11-10', 1, 1000.00, 10.00, 'Room only', 0.00, 1010.00);

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `id` int(30) NOT NULL,
  `type` varchar(50) NOT NULL,
  `bedding` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`id`, `type`, `bedding`) VALUES
(101, 'Superior Room', 'Single'),
(102, 'Superior Room', 'Triple'),
(103, 'Superior Room', 'Quad'),
(104, 'Deluxe Room', 'Single'),
(105, 'Deluxe Room', 'Double'),
(106, 'Deluxe Room', 'Triple'),
(117, 'Guest House', 'Single'),
(128, 'Guest House', 'Double'),
(132, 'Guest House', 'Triple'),
(142, 'Guest House', 'Quad'),
(163, 'Superior Room', 'Double'),
(204, 'Single Room', 'Single'),
(225, 'Superior Room', 'Single'),
(236, 'Deluxe Room', 'Single'),
(242, 'Deluxe Room', 'Triple'),
(271, 'Guest House', 'Double'),
(305, 'Deluxe Room', 'Single');

-- --------------------------------------------------------

--
-- Table structure for table `roombook`
--

CREATE TABLE `roombook` (
  `id` int(10) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Country` varchar(30) NOT NULL,
  `Phone` varchar(30) NOT NULL,
  `RoomType` varchar(30) NOT NULL,
  `Bed` varchar(30) NOT NULL,
  `Meal` varchar(30) NOT NULL,
  `NoofRoom` varchar(30) NOT NULL,
  `cin` date NOT NULL,
  `cout` date NOT NULL,
  `nodays` int(50) NOT NULL,
  `stat` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
ALTER TABLE roombook ADD user_id INT;
ALTER TABLE roombook ADD status VARCHAR(10) DEFAULT 'Pending';

--
-- Dumping data for table `roombook`
--

INSERT INTO `roombook` (`id`, `Name`, `Email`, `Country`, `Phone`, `RoomType`, `Bed`, `Meal`, `NoofRoom`, `cin`, `cout`, `nodays`, `stat`) VALUES
(41, 'Jay', 'jay9@gmail.com', 'India', '9313346569', 'Single Room', 'Single', 'Room only', '1', '2022-11-09', '2022-11-10', 1, 'Confirm');

-- --------------------------------------------------------

--
-- Table structure for table `signup`
--

CREATE TABLE `signup` (
  `UserID` int(100) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `signup`
--
INSERT INTO `signup` (`UserID`, `Username`, `Email`, `Password`) VALUES
(1, 'Jay', 'tusharpankhaniya2202@gmail.com', '123');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` int(30) NOT NULL,
  `name` varchar(30) NOT NULL,
  `work` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `name`, `work`) VALUES
(1, 'Jay', 'Manager'),
(3, 'rohit patel', 'Cook'),
(4, 'Dipak', 'Cook'),
(5, 'tirth', 'Helper'),
(6, 'mohan', 'Helper'),
(7, 'shyam', 'cleaner'),
(8, 'rohan', 'weighter'),
(9, 'hiren', 'weighter'),
(10, 'nikunj', 'weighter'),
(11, 'rekha', 'Cook');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `emp_login`
--
ALTER TABLE `emp_login`
  ADD PRIMARY KEY (`empid`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roombook`
--
ALTER TABLE `roombook`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `signup`
--
ALTER TABLE `signup`
  ADD PRIMARY KEY (`UserID`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `emp_login`
--
ALTER TABLE `emp_login`
  MODIFY `empid` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `roombook`
--
ALTER TABLE `roombook`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `signup`
--
ALTER TABLE `signup`
  MODIFY `UserID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
CREATE TABLE feedback (
    id INT AUTO_INCREMENT PRIMARY KEY,
    guest_id INT NOT NULL,
    feedback_date DATETIME,
    rating INT,
    comments TEXT,
    category VARCHAR(50),
    status VARCHAR(20)
   
);
ALTER TABLE feedback
ADD COLUMN sentiment VARCHAR(20) AFTER category;


CREATE TABLE schedule (
    id INT AUTO_INCREMENT PRIMARY KEY,
    staff_id INT,
    date DATE,
    shift ENUM('morning', 'afternoon', 'evening', 'night'),
    FOREIGN KEY (staff_id) REFERENCES staff(id)
);

CREATE TABLE occupancy_predictions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    date DATE,
    predicted_occupancy INT
);
CREATE TABLE housekeeping_tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    task VARCHAR(255) NOT NULL,
    room_number INT NOT NULL,
    complexity INT NOT NULL,
    will_complete_on_time TINYINT(1) NOT NULL,
    status VARCHAR(50) DEFAULT 'pending',
    completed_at TIMESTAMP NULL DEFAULT NULL
);

CREATE TABLE tickets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    feedback_id INT NOT NULL,
    Feedback_date date ,
    assigned_staff_id INT NOT NULL,
    issue_description TEXT NOT NULL,
    ticket_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE `notifications` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `message` text NOT NULL,
    `seen` tinyint(1) NOT NULL DEFAULT '0',
    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    name VARCHAR(255) NOT NULL
);

CREATE TABLE reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    room_type VARCHAR(255),
    bed_type VARCHAR(255),
    no_of_rooms INT,
    no_of_people INT,
    meal VARCHAR(255),
    check_in DATE,
    check_out DATE
);

CREATE TABLE tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    category ENUM('todo', 'in-progress', 'completed') NOT NULL DEFAULT 'todo'
); 
