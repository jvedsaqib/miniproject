-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 29, 2024 at 08:13 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `miniproject`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `username` varchar(255) NOT NULL,
  `password` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`username`, `password`) VALUES
('ADMIN', 'ADMIN');

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `application_id` int(11) NOT NULL,
  `student_roll` int(11) DEFAULT NULL,
  `job_post_id` int(11) DEFAULT NULL,
  `application_date` date DEFAULT NULL,
  `application_status` enum('Applied','Shortlisted','Rejected','Selected') DEFAULT 'Applied',
  `resume_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`application_id`, `student_roll`, `job_post_id`, `application_date`, `application_status`, `resume_path`) VALUES
(1, 2382031, 2, '2024-08-23', 'Applied', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `issues`
--

CREATE TABLE `issues` (
  `IssueID` int(11) NOT NULL,
  `StudentRoll` int(11) NOT NULL,
  `Issues` text NOT NULL,
  `Description` text DEFAULT NULL,
  `DateRaised` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Triggers `issues`
--
-- DELIMITER $$
-- CREATE TRIGGER `before_issue_delete` BEFORE DELETE ON `issues` FOR EACH ROW BEGIN
--     INSERT INTO issue_history (IssueID, StudentRoll, Issues, Description, DateRaised)
--     VALUES (OLD.IssueID, OLD.StudentRoll, OLD.Issues, OLD.Description, OLD.DateRaised);
-- END
-- $$
-- DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `issue_history`
--

CREATE TABLE `issue_history` (
  `IssueID` int(11) NOT NULL,
  `StudentRoll` int(11) NOT NULL,
  `Issues` text NOT NULL,
  `Description` text DEFAULT NULL,
  `DateRaised` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `issue_history`
--

INSERT INTO `issue_history` (`IssueID`, `StudentRoll`, `Issues`, `Description`, `DateRaised`) VALUES
(1, 2382031, 'StudentPhoneNo', 'It should be - 6291526612 Thank you ', '2024-08-23 03:11:29'),
(2, 2382031, 'StudentPhoneNo', '', '2024-08-23 09:32:16');

-- --------------------------------------------------------

--
-- Table structure for table `job_posting`
--

CREATE TABLE `job_posting` (
  `id` int(11) NOT NULL,
  `reference_number` varchar(255) NOT NULL,
  `post_date` date NOT NULL,
  `batch_year` year(4) NOT NULL,
  `recruiting_company` varchar(255) NOT NULL,
  `streams` text DEFAULT NULL,
  `backlogs` int(11) NOT NULL,
  `minimum_cgpa` float NOT NULL,
  `eligibility_description` text DEFAULT NULL,
  `selection_mode` varchar(255) NOT NULL,
  `selection_mode_description` text DEFAULT NULL,
  `selection_process` varchar(255) NOT NULL,
  `selection_date` varchar(255) DEFAULT NULL,
  `designation` varchar(255) NOT NULL,
  `remuneration` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `job_link` varchar(255) NOT NULL,
  `class_x_percentage` float NOT NULL,
  `class_xii_percentage` float NOT NULL,
  `graduation_cgpa` float NOT NULL,
  `postgraduation_cgpa` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `job_posting`
--

INSERT INTO `job_posting` (`id`, `reference_number`, `post_date`, `batch_year`, `recruiting_company`, `streams`, `backlogs`, `minimum_cgpa`, `eligibility_description`, `selection_mode`, `selection_mode_description`, `selection_process`, `selection_date`, `designation`, `remuneration`, `location`, `job_link`, `class_x_percentage`, `class_xii_percentage`, `graduation_cgpa`, `postgraduation_cgpa`) VALUES
(1, 'HITK/1021/0001', '2024-08-13', '2025', 'ABCS', 'Btech, AEIE, CSBS, MCA, MTECH', 2, 7, '', 'On-campus', '', 'INTERVIEW', '10/09/2024', 'SWE INTERN', '7 LPA', 'Pan India', 'https://jobportal.com/job/HITK-1021-0001', 80, 85, 7.5, NULL),
(2, 'HITK/1021/0002', '2024-08-13', '2025', 'XYZ Corp', 'Btech, CSE, IT', 1, 6.5, '', 'Virtual-Mode', '', 'ASSESSMENT', '10/10/2024', 'Software Engineer', '6 LPA', 'Remote', 'https://jobportal.com/job/HITK-1021-0002', 75, 78, 7, NULL),
(3, 'HITK/1021/0003', '2024-08-13', '2025', 'Tech Innovations', 'Btech, DS, AIML', 0, 8, '', 'On-campus', '', 'INTERVIEW', '15/09/2024', 'Data Scientist', '8 LPA', 'Mumbai', 'https://jobportal.com/job/HITK-1021-0003', 85, 90, 8.5, NULL),
(4, 'HITK/1021/0004', '2024-08-14', '2025', 'Future Tech', 'MCA, MTECH', 1, 7.5, '', 'On-campus', '', 'GROUP DISCUSSION', '20/09/2024', 'Product Manager', '10 LPA', 'Bangalore', 'https://jobportal.com/job/HITK-1021-0004', 70, 75, 7.8, 8),
(5, 'HITK/1021/0005', '2024-08-15', '2025', 'Innovatech', 'Btech, ECE', 0, 8.5, '', 'Virtual-Mode', '', 'ASSESSMENT', '25/09/2024', 'Embedded Engineer', '9 LPA', 'Hyderabad', 'https://jobportal.com/job/HITK-1021-0005', 85, 88, 8, NULL),
(6, 'HITK/1021/0006', '2024-08-16', '2025', 'Data Solutions', 'Btech, IT, CE', 3, 6, '', 'On-campus', '', 'INTERVIEW', '30/09/2024', 'Database Administrator', '5 LPA', 'Delhi', 'https://jobportal.com/job/HITK-1021-0006', 70, 72, 6.5, NULL),
(7, 'HITK/1021/0007', '2024-08-17', '2025', 'NextGen Solutions', 'Btech, CSE, DS', 0, 7, '', 'Virtual-Mode', '', 'TECHNICAL ROUND', '05/10/2024', 'Cloud Engineer', '8.5 LPA', 'Chennai', 'https://jobportal.com/job/HITK-1021-0007', 78, 80, 7.5, NULL),
(8, 'HITK/1021/0008', '2024-08-18', '2025', 'Global Tech', 'MCA, MTECH, CSE', 2, 6.5, '', 'On-campus', '', 'PANEL INTERVIEW', '10/10/2024', 'Software Tester', '7.5 LPA', 'Pune', 'https://jobportal.com/job/HITK-1021-0008', 75, 77, 7.5, 7.5),
(9, 'HITK/1021/0009', '2024-08-19', '2025', 'ABC Technologies', 'Btech, AEIE, ECE', 1, 7, '', 'On-campus', '', 'ASSESSMENT', '15/10/2024', 'Network Engineer', '6.5 LPA', 'Kolkata', 'https://jobportal.com/job/HITK-1021-0009', 80, 82, 7.5, NULL),
(10, 'HITK/1021/0010', '2024-08-20', '2025', 'Future Innovations', 'Btech, CSBS, CSE', 0, 8, '', 'Virtual-Mode', '', 'INTERVIEW', '20/10/2024', 'UX Designer', '9 LPA', 'Gurgaon', 'https://jobportal.com/job/HITK-1021-0010', 85, 87, 8.2, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `placements`
--

CREATE TABLE `placements` (
  `placement_id` int(11) NOT NULL,
  `student_roll` int(11) DEFAULT NULL,
  `StudentDept` enum('BTech','MCA','MTech','BE') DEFAULT NULL,
  `StudentSpecialisation` enum('AEIE','CSBS','CSE','DS','AIML','CE','IT','ECE','EE') DEFAULT NULL,
  `job_post_id` int(11) DEFAULT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `designation` varchar(255) DEFAULT NULL,
  `salary_package` float DEFAULT NULL,
  `placement_date` date DEFAULT NULL,
  `placement_status` enum('Placed','Rejected') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `placements`
--

INSERT INTO `placements` (`placement_id`, `student_roll`, `StudentDept`, `StudentSpecialisation`, `job_post_id`, `company_name`, `designation`, `salary_package`, `placement_date`, `placement_status`) VALUES
(1, 22001, 'BTech', 'CSE', NULL, 'Tech Innovators', 'Software Engineer', 6.5, '2022-05-12', 'Placed'),
(2, 22002, 'BTech', 'DS', NULL, 'Data Analytics Inc.', 'Data Analyst', 7, '2022-06-18', 'Placed'),
(3, 22003, 'BTech', 'ECE', NULL, 'Global Solutions', 'Network Engineer', 5.5, '2022-07-20', 'Placed'),
(4, 22004, 'BTech', 'IT', NULL, 'Creative Tech', 'UI/UX Designer', 6, '2022-08-20', 'Placed'),
(5, 22005, 'BTech', 'AEIE', NULL, 'NextGen Robotics', 'Embedded Engineer', 7.5, '2022-09-15', 'Placed'),
(6, 22006, 'MCA', NULL, NULL, 'Innovatech', 'Product Manager', 8, '2022-10-10', 'Placed'),
(7, 22007, 'MTech', 'CSE', NULL, 'Alpha Systems', 'Cloud Engineer', 7, '2022-11-05', 'Placed'),
(8, 22008, 'BE', 'ECE', NULL, 'Delta Dynamics', 'Software Tester', 6.2, '2022-12-01', 'Placed'),
(9, 22009, 'BTech', 'CSBS', NULL, 'Beta Tech', 'Database Administrator', 5.8, '2022-12-20', 'Placed'),
(10, 22010, 'BTech', 'AIML', NULL, 'Gamma Enterprises', 'AI Engineer', 8.5, '2022-01-15', 'Placed'),
(11, 22011, 'MCA', NULL, NULL, 'XYZ Corp', 'Software Engineer', 6.7, '2022-02-18', 'Placed'),
(12, 22012, 'MTech', 'DS', NULL, 'ABCS', 'SWE Intern', 7, '2022-03-10', 'Placed'),
(13, 22013, 'BTech', 'CSE', NULL, 'Tech Innovations', 'Data Scientist', 8.2, '2022-04-12', 'Placed'),
(14, 22014, 'BE', 'IT', NULL, 'Future Tech', 'Product Manager', 8.5, '2022-05-15', 'Placed'),
(15, 22015, 'MCA', NULL, NULL, 'Innovatech', 'Embedded Engineer', 7, '2022-06-20', 'Placed'),
(16, 22016, 'BTech', 'AIML', NULL, 'NextGen Solutions', 'Cloud Engineer', 7.8, '2022-07-20', 'Placed'),
(17, 22017, 'BTech', 'CSE', NULL, 'Global Tech', 'Software Tester', 7.2, '2022-08-18', 'Placed'),
(18, 22018, 'MTech', 'ECE', NULL, 'ABC Technologies', 'Network Engineer', 6.9, '2022-09-12', 'Placed'),
(19, 22019, 'BE', 'IT', NULL, 'Future Innovations', 'UX Designer', 7.5, '2022-10-05', 'Placed'),
(20, 22020, 'BTech', 'CSE', NULL, 'Creative Solutions', 'Software Engineer', 7, '2022-11-02', 'Placed'),
(21, 21001, 'BTech', 'CSBS', NULL, 'Tech Innovators', 'Software Engineer', 6.8, '2021-05-10', 'Placed'),
(22, 21002, 'BTech', 'DS', NULL, 'Data Analytics Inc.', 'Data Analyst', 7.2, '2021-06-15', 'Placed'),
(23, 21003, 'BTech', 'ECE', NULL, 'Global Solutions', 'Network Engineer', 5.6, '2021-07-20', 'Placed'),
(24, 21004, 'BTech', 'IT', NULL, 'Creative Tech', 'UI/UX Designer', 6.1, '2021-08-30', 'Placed'),
(25, 21005, 'BTech', 'AEIE', NULL, 'NextGen Robotics', 'Embedded Engineer', 7.4, '2021-09-18', 'Placed'),
(26, 21006, 'MCA', NULL, NULL, 'Innovatech', 'Product Manager', 8.1, '2021-10-20', 'Placed'),
(27, 21007, 'MTech', 'CSE', NULL, 'Alpha Systems', 'Cloud Engineer', 7.3, '2021-11-15', 'Placed'),
(28, 21008, 'BE', 'ECE', NULL, 'Delta Dynamics', 'Software Tester', 6.4, '2021-12-20', 'Placed'),
(29, 21009, 'BTech', 'CSBS', NULL, 'Beta Tech', 'Database Administrator', 5.9, '2021-12-29', 'Placed'),
(30, 21010, 'BTech', 'AIML', NULL, 'Gamma Enterprises', 'AI Engineer', 8.3, '2021-01-10', 'Placed'),
(31, 21011, 'MCA', NULL, NULL, 'Tech Innovators', 'Software Engineer', 6.5, '2022-04-15', 'Rejected'),
(32, 21012, 'MTech', 'DS', NULL, 'Data Analytics Inc.', 'Data Analyst', 6.7, '2022-05-20', 'Rejected'),
(33, 21013, 'BE', 'ECE', NULL, 'Global Solutions', 'Network Engineer', 5.4, '2022-06-18', 'Rejected'),
(34, 21014, 'BTech', 'IT', NULL, 'Creative Tech', 'UI/UX Designer', 5.8, '2022-07-22', 'Rejected'),
(35, 21015, 'MCA', NULL, NULL, 'NextGen Robotics', 'Embedded Engineer', 6.5, '2022-08-20', 'Rejected'),
(36, 21016, 'BTech', 'AEIE', NULL, 'Innovatech', 'Product Manager', 7.2, '2022-09-30', 'Rejected'),
(37, 21017, 'MTech', 'CSE', NULL, 'Alpha Systems', 'Cloud Engineer', 6.3, '2022-10-12', 'Rejected'),
(38, 21018, 'BE', 'ECE', NULL, 'Delta Dynamics', 'Software Tester', 5.7, '2022-11-20', 'Rejected'),
(39, 21019, 'BTech', 'CSBS', NULL, 'Beta Tech', 'Database Administrator', 5.2, '2022-12-18', 'Rejected'),
(40, 21020, 'BTech', 'AIML', NULL, 'Gamma Enterprises', 'AI Engineer', 7, '2021-01-20', 'Rejected'),
(41, 20001, 'BTech', 'CSE', NULL, 'Tech Innovators', 'Software Engineer', 6.9, '2021-02-05', 'Placed'),
(42, 20002, 'BTech', 'DS', NULL, 'Data Analytics Inc.', 'Data Analyst', 7.1, '2021-03-12', 'Placed'),
(43, 20003, 'BTech', 'ECE', NULL, 'Global Solutions', 'Network Engineer', 5.7, '2021-04-15', 'Placed'),
(44, 20004, 'BTech', 'IT', NULL, 'Creative Tech', 'UI/UX Designer', 6.3, '2021-05-20', 'Placed'),
(45, 20005, 'BTech', 'AEIE', NULL, 'NextGen Robotics', 'Embedded Engineer', 7.2, '2021-06-10', 'Placed'),
(46, 20006, 'MCA', NULL, NULL, 'Innovatech', 'Product Manager', 8.3, '2021-07-15', 'Placed'),
(47, 20007, 'MTech', 'CSE', NULL, 'Alpha Systems', 'Cloud Engineer', 7.1, '2021-08-20', 'Placed'),
(48, 20008, 'BE', 'ECE', NULL, 'Delta Dynamics', 'Software Tester', 6.5, '2021-09-10', 'Placed'),
(49, 20009, 'BTech', 'CSBS', NULL, 'Beta Tech', 'Database Administrator', 5.6, '2021-10-05', 'Placed'),
(50, 20010, 'BTech', 'AIML', NULL, 'Gamma Enterprises', 'AI Engineer', 8.2, '2021-11-15', 'Placed'),
(51, 20011, 'MCA', NULL, NULL, 'Tech Innovators', 'Software Engineer', 6.8, '2021-12-10', 'Placed'),
(52, 20012, 'MTech', 'DS', NULL, 'Data Analytics Inc.', 'Data Analyst', 6.9, '2021-01-05', 'Placed'),
(53, 20013, 'BE', 'ECE', NULL, 'Global Solutions', 'Network Engineer', 5.8, '2021-02-15', 'Placed'),
(54, 20014, 'BTech', 'IT', NULL, 'Creative Tech', 'UI/UX Designer', 6.4, '2021-03-20', 'Placed'),
(55, 20015, 'MCA', NULL, NULL, 'NextGen Robotics', 'Embedded Engineer', 7, '2021-04-10', 'Placed'),
(56, 20016, 'BTech', 'AEIE', NULL, 'Innovatech', 'Product Manager', 8, '2021-05-15', 'Placed'),
(57, 20017, 'MTech', 'CSE', NULL, 'Alpha Systems', 'Cloud Engineer', 7.2, '2021-06-20', 'Placed'),
(58, 20018, 'BE', 'ECE', NULL, 'Delta Dynamics', 'Software Tester', 6.1, '2021-07-10', 'Placed'),
(59, 20019, 'BTech', 'CSBS', NULL, 'Beta Tech', 'Database Administrator', 5.7, '2021-08-05', 'Placed'),
(60, 20020, 'BTech', 'AIML', NULL, 'Gamma Enterprises', 'AI Engineer', 8.4, '2021-09-15', 'Placed'),
(61, 20021, 'BTech', 'CSE', NULL, 'Tech Innovators', 'Software Engineer', 6.6, '2021-10-10', 'Rejected'),
(62, 20022, 'BTech', 'DS', NULL, 'Data Analytics Inc.', 'Data Analyst', 6.8, '2021-11-15', 'Rejected'),
(63, 20022, 'BTech', 'ECE', NULL, 'Global Solutions', 'Network Engineer', 5.5, '2021-12-20', 'Rejected'),
(64, 20021, 'BTech', 'IT', NULL, 'Creative Tech', 'UI/UX Designer', 5.9, '2020-01-10', 'Rejected'),
(65, 20020, 'BTech', 'AEIE', NULL, 'NextGen Robotics', 'Embedded Engineer', 6.7, '2020-02-05', 'Rejected'),
(66, 20022, 'MCA', NULL, NULL, 'Innovatech', 'Product Manager', 7.5, '2020-03-10', 'Rejected'),
(67, 20027, 'MTech', 'CSE', NULL, 'Alpha Systems', 'Cloud Engineer', 6.9, '2020-04-15', 'Rejected'),
(68, 20028, 'BE', 'ECE', NULL, 'Delta Dynamics', 'Software Tester', 5.8, '2020-05-20', 'Rejected'),
(69, 20029, 'BTech', 'CSBS', NULL, 'Beta Tech', 'Database Administrator', 5.6, '2020-06-10', 'Rejected'),
(70, 20030, 'BTech', 'AIML', NULL, 'Gamma Enterprises', 'AI Engineer', 7.8, '2020-07-15', 'Rejected'),
(71, 20031, 'MCA', NULL, NULL, 'Tech Innovators', 'Software Engineer', 6.9, '2020-08-20', 'Rejected'),
(72, 20032, 'MTech', 'DS', NULL, 'Data Analytics Inc.', 'Data Analyst', 6.6, '2020-09-15', 'Rejected'),
(73, 20033, 'BE', 'ECE', NULL, 'Global Solutions', 'Network Engineer', 5.7, '2020-10-10', 'Rejected'),
(74, 20034, 'BTech', 'IT', NULL, 'Creative Tech', 'UI/UX Designer', 6, '2020-11-05', 'Rejected'),
(75, 20035, 'MCA', NULL, NULL, 'NextGen Robotics', 'Embedded Engineer', 7, '2020-12-10', 'Rejected'),
(76, 20036, 'BTech', 'AEIE', NULL, 'Innovatech', 'Product Manager', 7.3, '2020-01-20', 'Rejected'),
(77, 20037, 'MTech', 'CSE', NULL, 'Alpha Systems', 'Cloud Engineer', 6.8, '2020-02-20', 'Rejected'),
(78, 20038, 'BE', 'ECE', NULL, 'Delta Dynamics', 'Software Tester', 5.9, '2020-03-15', 'Rejected'),
(79, 20039, 'BTech', 'CSBS', NULL, 'Beta Tech', 'Database Administrator', 5.8, '2020-04-10', 'Rejected'),
(80, 20040, 'BTech', 'AIML', NULL, 'Gamma Enterprises', 'AI Engineer', 7.9, '2020-05-15', 'Rejected'),
(81, 20041, 'BTech', 'CSE', NULL, 'Tech Innovators', 'Software Engineer', 6.4, '2020-06-20', 'Rejected'),
(82, 20042, 'BTech', 'DS', NULL, 'Data Analytics Inc.', 'Data Analyst', 6.5, '2020-07-20', 'Rejected'),
(83, 20043, 'BTech', 'ECE', NULL, 'Global Solutions', 'Network Engineer', 5.6, '2020-08-30', 'Rejected'),
(84, 20044, 'BTech', 'IT', NULL, 'Creative Tech', 'UI/UX Designer', 6.2, '2020-09-20', 'Rejected'),
(85, 20045, 'MCA', NULL, NULL, 'NextGen Robotics', 'Embedded Engineer', 6.8, '2020-10-20', 'Rejected'),
(86, 20046, 'BTech', 'AEIE', NULL, 'Innovatech', 'Product Manager', 7.4, '2020-11-15', 'Rejected'),
(87, 20047, 'MTech', 'CSE', NULL, 'Alpha Systems', 'Cloud Engineer', 6.7, '2020-12-10', 'Rejected'),
(88, 20048, 'BE', 'ECE', NULL, 'Delta Dynamics', 'Software Tester', 5.9, '2022-01-05', 'Rejected'),
(89, 20049, 'BTech', 'CSBS', NULL, 'Beta Tech', 'Database Administrator', 5.5, '2022-02-20', 'Rejected'),
(90, 20050, 'BTech', 'AIML', NULL, 'Gamma Enterprises', 'AI Engineer', 7.7, '2022-03-15', 'Rejected');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `StudentName` varchar(100) NOT NULL,
  `StudentRoll` int(11) NOT NULL,
  `StudentEmail` varchar(100) NOT NULL,
  `StudentPassword` varchar(255) NOT NULL,
  `StudentPhoneNo` varchar(15) NOT NULL,
  `StudentAltPhoneNo` varchar(15) DEFAULT NULL,
  `StudentPhotoPath` varchar(255) DEFAULT NULL,
  `StudentSex` enum('M','F') NOT NULL,
  `StudentDOB` date NOT NULL,
  `StudentDept` enum('BTech','MCA','MTech','BE') NOT NULL,
  `StudentSpecialisation` enum('AEIE','CSBS','CSE','DS','AIML','CE','IT','ECE','EE') DEFAULT NULL,
  `ClassXPercentage` float NOT NULL,
  `ClassXIIPercentage` float NOT NULL,
  `UndergraduateCGPA` float DEFAULT NULL,
  `PostgraduateCGPA` float DEFAULT NULL,
  `NumberOfBacklogs` int(11) DEFAULT 0,
  `PassoutYear` year(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`StudentName`, `StudentRoll`, `StudentEmail`, `StudentPassword`, `StudentPhoneNo`, `StudentAltPhoneNo`, `StudentPhotoPath`, `StudentSex`, `StudentDOB`, `StudentDept`, `StudentSpecialisation`, `ClassXPercentage`, `ClassXIIPercentage`, `UndergraduateCGPA`, `PostgraduateCGPA`, `NumberOfBacklogs`, `PassoutYear`) VALUES
('Saqib Javed', 2382031, 'jvedsaqib@gmail.com', 'Saqib123', '6291526612', '9748137660', 'images/MCA/2025/2382031/2382031.JPG', 'M', '2001-02-11', 'MCA', NULL, 80.71, 82.4, 8.12, 9.07, NULL, '2025');

--
-- Triggers `students`
--
-- DELIMITER $$
-- CREATE TRIGGER `after_student_insert` AFTER INSERT ON `students` FOR EACH ROW BEGIN
--     INSERT INTO student_login_credentials (roll, email, password)
--     VALUES (NEW.StudentRoll ,NEW.StudentEmail, NEW.StudentPassword);
-- END
-- $$
-- DELIMITER ;
-- DELIMITER $$
-- CREATE TRIGGER `after_student_password_update` AFTER UPDATE ON `students` FOR EACH ROW BEGIN
--     IF OLD.StudentPassword != NEW.StudentPassword THEN
--         UPDATE student_login_credentials
--         SET password = NEW.StudentPassword
--         WHERE email = NEW.StudentEmail;
--     END IF;
-- END
-- $$
-- DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `student_login_credentials`
--

CREATE TABLE `student_login_credentials` (
  `roll` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_login_credentials`
--

INSERT INTO `student_login_credentials` (`roll`, `email`, `password`) VALUES
(2382031, 'jvedsaqib@gmail.com', 'Saqib123');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`application_id`),
  ADD KEY `student_roll` (`student_roll`),
  ADD KEY `job_post_id` (`job_post_id`);

--
-- Indexes for table `issues`
--
ALTER TABLE `issues`
  ADD PRIMARY KEY (`IssueID`),
  ADD KEY `StudentRoll` (`StudentRoll`);

--
-- Indexes for table `issue_history`
--
ALTER TABLE `issue_history`
  ADD PRIMARY KEY (`IssueID`),
  ADD KEY `StudentRoll` (`StudentRoll`);

--
-- Indexes for table `job_posting`
--
ALTER TABLE `job_posting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `placements`
--
ALTER TABLE `placements`
  ADD PRIMARY KEY (`placement_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`StudentRoll`);

--
-- Indexes for table `student_login_credentials`
--
ALTER TABLE `student_login_credentials`
  ADD PRIMARY KEY (`roll`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `application_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `issues`
--
ALTER TABLE `issues`
  MODIFY `IssueID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `issue_history`
--
ALTER TABLE `issue_history`
  MODIFY `IssueID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `job_posting`
--
ALTER TABLE `job_posting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `placements`
--
ALTER TABLE `placements`
  MODIFY `placement_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `applications`
--
ALTER TABLE `applications`
  ADD CONSTRAINT `applications_ibfk_1` FOREIGN KEY (`student_roll`) REFERENCES `students` (`StudentRoll`),
  ADD CONSTRAINT `applications_ibfk_2` FOREIGN KEY (`job_post_id`) REFERENCES `job_posting` (`id`);

--
-- Constraints for table `issues`
--
ALTER TABLE `issues`
  ADD CONSTRAINT `issues_ibfk_1` FOREIGN KEY (`StudentRoll`) REFERENCES `students` (`StudentRoll`);

--
-- Constraints for table `student_login_credentials`
--
ALTER TABLE `student_login_credentials`
  ADD CONSTRAINT `student_login_credentials_ibfk_1` FOREIGN KEY (`roll`) REFERENCES `students` (`StudentRoll`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
