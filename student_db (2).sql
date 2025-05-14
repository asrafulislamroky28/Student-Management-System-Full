-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 12, 2025 at 06:01 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `student_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `admin_id` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `username`, `password`) VALUES
('213', 'admin1', '$2y$10$S4DKnasdEDhVcFyXx1/cHORKJaE9ow4iAPOZwZX6VCJEvHo8dGm.u');

-- --------------------------------------------------------

--
-- Table structure for table `class_routine`
--

CREATE TABLE `class_routine` (
  `id` int(11) NOT NULL,
  `class` varchar(20) NOT NULL,
  `section` varchar(5) NOT NULL,
  `day` varchar(15) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `room` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `class_routine`
--

INSERT INTO `class_routine` (`id`, `class`, `section`, `day`, `subject`, `start_time`, `end_time`, `room`) VALUES
(1, '10', 'A', 'Sunday', 'Mathematics', '08:00:00', '09:00:00', 'Room 102'),
(2, '10', 'A', 'Sunday', 'English', '09:15:00', '10:15:00', 'Room 102'),
(3, '10', 'A', 'Monday', 'Physics', '08:00:00', '09:00:00', 'Room 101'),
(4, '10', 'A', 'Monday', 'Chemistry', '09:15:00', '10:15:00', 'Room 102'),
(5, '6', 'A', 'Sunday', 'Bangla', '08:00:00', '09:00:00', 'Room 201'),
(6, '6', 'A', 'Sunday', 'English', '09:15:00', '10:15:00', 'Room 202'),
(7, '6', 'A', 'Monday', 'Mathematics', '08:00:00', '09:00:00', 'Room 201'),
(8, '6', 'A', 'Monday', 'Science', '09:15:00', '10:15:00', 'Room 202'),
(9, '7', 'A', 'Sunday', 'Mathematics', '08:00:00', '09:00:00', 'Room 203'),
(10, '7', 'A', 'Sunday', 'Geography', '09:15:00', '10:15:00', 'Room 204'),
(11, '7', 'A', 'Monday', 'Bangla', '08:00:00', '09:00:00', 'Room 203'),
(12, '7', 'A', 'Monday', 'English', '09:15:00', '10:15:00', 'Room 204'),
(13, '8', 'A', 'Sunday', 'Science', '08:00:00', '09:00:00', 'Room 205'),
(14, '8', 'A', 'Sunday', 'History', '09:15:00', '10:15:00', 'Room 206'),
(15, '8', 'A', 'Monday', 'Mathematics', '08:00:00', '09:00:00', 'Room 205'),
(16, '8', 'A', 'Monday', 'English', '09:15:00', '10:15:00', 'Room 206'),
(17, '9', 'A', 'Sunday', 'Physics', '08:00:00', '09:00:00', 'Room 301'),
(18, '9', 'A', 'Sunday', 'Chemistry', '09:15:00', '10:15:00', 'Room 302'),
(19, '9', 'A', 'Monday', 'Biology', '08:00:00', '09:00:00', 'Room 301'),
(20, '9', 'A', 'Monday', 'Mathematics', '09:15:00', '10:15:00', 'Room 302');

-- --------------------------------------------------------

--
-- Table structure for table `exam_routine`
--

CREATE TABLE `exam_routine` (
  `id` int(11) NOT NULL,
  `class` varchar(20) NOT NULL,
  `section` varchar(5) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `exam_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `room` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exam_routine`
--

INSERT INTO `exam_routine` (`id`, `class`, `section`, `subject`, `exam_date`, `start_time`, `end_time`, `room`) VALUES
(3, '6', 'A', 'Bangla', '2025-06-01', '09:00:00', '11:00:00', 'Exam Hall 1'),
(4, '6', 'A', 'English', '2025-06-02', '09:00:00', '11:00:00', 'Exam Hall 1'),
(5, '6', 'A', 'Mathematics', '2025-06-03', '09:00:00', '11:00:00', 'Exam Hall 2'),
(6, '6', 'A', 'Science', '2025-06-04', '09:00:00', '11:00:00', 'Exam Hall 2'),
(7, '7', 'A', 'Mathematics', '2025-06-01', '09:00:00', '11:00:00', 'Exam Hall 3'),
(8, '7', 'A', 'Geography', '2025-06-02', '09:00:00', '11:00:00', 'Exam Hall 3'),
(9, '7', 'A', 'Bangla', '2025-06-03', '09:00:00', '11:00:00', 'Exam Hall 4'),
(10, '7', 'A', 'English', '2025-06-04', '09:00:00', '11:00:00', 'Exam Hall 4'),
(11, '8', 'A', 'Science', '2025-06-01', '09:00:00', '11:00:00', 'Exam Hall 5'),
(12, '8', 'A', 'History', '2025-06-02', '09:00:00', '11:00:00', 'Exam Hall 5'),
(13, '8', 'A', 'Mathematics', '2025-06-03', '09:00:00', '11:00:00', 'Exam Hall 6'),
(14, '8', 'A', 'English', '2025-06-04', '09:00:00', '11:00:00', 'Exam Hall 6'),
(15, '9', 'A', 'Physics', '2025-06-01', '09:00:00', '11:00:00', 'Exam Hall 7'),
(16, '9', 'A', 'Chemistry', '2025-06-02', '09:00:00', '11:00:00', 'Exam Hall 7'),
(17, '9', 'A', 'Biology', '2025-06-03', '09:00:00', '11:00:00', 'Exam Hall 8'),
(18, '9', 'A', 'Mathematics', '2025-06-04', '09:00:00', '11:00:00', 'Exam Hall 8'),
(19, '10', 'A', 'Mathematics', '2025-06-01', '09:00:00', '11:00:00', 'Exam Hall 9'),
(20, '10', 'A', 'English', '2025-06-02', '09:00:00', '11:00:00', 'Exam Hall 9'),
(21, '10', 'A', 'Physics', '2025-06-03', '09:00:00', '11:00:00', 'Exam Hall 10'),
(22, '10', 'A', 'Chemistry', '2025-06-04', '09:00:00', '11:00:00', 'Exam Hall 10');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `class` varchar(10) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `status` enum('Paid','Unpaid') DEFAULT 'Unpaid'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `student_id`, `class`, `amount`, `status`) VALUES
(1, 21303001, '6', 5000.00, 'Unpaid'),
(2, 21303042, '10', 5000.00, 'Unpaid'),
(3, 21303043, '10', 5000.00, 'Unpaid'),
(4, 21303157, '9', 5000.00, 'Unpaid');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `class` varchar(20) DEFAULT NULL,
  `section` varchar(10) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `name`, `email`, `password`, `class`, `section`, `gender`, `date_of_birth`) VALUES
(21303001, 'Mithi', '21303001@iubat.edu', '$2y$10$9axE7/SR1a579gdCWdjahuS/k4y7lbnpNLUJbVxipJv0vj/xQ5GFW', '6', 'A', 'Female', '2025-04-28'),
(21303042, 'Md Srabon Chowdhury ', 'fenixdy47@gmail.com', '$2y$10$EmZ8BH9.hYpymh3aX16dpumwRMf4qvIXOUZukk8Fy34IKLkZytNJS', '10', 'A', 'Male', '2025-05-09'),
(21303043, 'Asraful Islam', 'asrafulislamroky11@gmail.com', '$2y$10$3t5Z3WwJMCGWDe2mlhVZ3ewcOkSQBW.H4wDzAp9BhcYfU1sduy9AS', '10', 'A', 'Male', '2025-05-11'),
(21303157, 'Elma monsura', 'elma11@gmail.com', '$2y$10$2ZKhXR9TRMVggYXFnQv6MO5338T.GP5KkAmvzY.Wn3M.EXAmybfKC', '9', 'A', 'Male', '2025-05-11'),
(22103192, 'Shefa', 'shefa11@gmail.com', '$2y$10$fed3BCW57sd.YqO67EvN8upP9WXh0MW1.lNNBmTMnPy6qZvb4l3R6', '8', 'A', 'Female', '2025-04-17');

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `name`, `email`, `password`) VALUES
(1, 'Asraful Islam', 'asrafulislamroky11@gmail.com', '$2y$10$/F2jPHO./yQ7jb7gan0W7OtNoKaXeiKX5dLn9.MAGnjSu1rdLi1la'),
(2, 'Asif khan', '21303043@iubat.edu', '$2y$10$Y/j9iHoYbCxF17C/DPP4K.xiWQ8ZCFymaWVegCNOhdgeFqVeEWsoK'),
(3, 'Zihad Parvez', 'zihad11@gmail.com', '$2y$10$opEN/sVjPEiKI921RKi3wO7rzwYnlSIcinuLpW7bANEmzlf1mOcg.');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `class_routine`
--
ALTER TABLE `class_routine`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exam_routine`
--
ALTER TABLE `exam_routine`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `class_routine`
--
ALTER TABLE `class_routine`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `exam_routine`
--
ALTER TABLE `exam_routine`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
