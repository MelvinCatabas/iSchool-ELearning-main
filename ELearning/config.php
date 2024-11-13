<?php
$db_host = "localhost";
$db_user = "root";
$db_password = "";
$db_name = "lms_db";

// Create Connection
$conn = new mysqli($db_host, $db_user, $db_password, $db_name);

// Check Connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$db_selected = mysqli_select_db($conn, $db_name);

// If the database does not exist, create it
if (!$db_selected) {
    $sql = "CREATE DATABASE $db_name";
    if ($conn->query($sql) === TRUE) {
        $conn->select_db($db_name);
    } else {
        die("Error creating database: " . $conn->error);
    }
}

// SQL statements to create tables and insert data
$sql = "
SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO';
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = '+00:00';

-- Instructor Table
CREATE TABLE IF NOT EXISTS `instructor` (
  `instructor_id` INT(11) NOT NULL AUTO_INCREMENT,
  `instructor_fname` VARCHAR(255) COLLATE utf8_bin NOT NULL,
  `instructor_lname` VARCHAR(255) COLLATE utf8_bin NOT NULL,
  `instructor_dob` DATE NOT NULL,
  `instructor_sex` VARCHAR(10) COLLATE utf8_bin NOT NULL,
  `instructor_email` VARCHAR(255) COLLATE utf8_bin NOT NULL,
  `instructor_pass` VARCHAR(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`instructor_id`)
);

-- Course Table (with instructor_id)
CREATE TABLE IF NOT EXISTS `course` (
  `course_id` INT(11) NOT NULL AUTO_INCREMENT,
  `instructor_id` INT(11) NOT NULL,
  `course_name` TEXT COLLATE utf8_bin NOT NULL,
  `course_desc` TEXT COLLATE utf8_bin NOT NULL,
  `course_date` DATE NOT NULL,  -- Added course date
  `course_img` TEXT COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`course_id`),
  FOREIGN KEY (`instructor_id`) REFERENCES `instructor`(`instructor_id`)
);

-- Admin Table
CREATE TABLE IF NOT EXISTS `admin` (
  `admin_id` INT(11) NOT NULL AUTO_INCREMENT,
  `admin_name` VARCHAR(255) COLLATE utf8_bin NOT NULL,
  `admin_email` VARCHAR(255) COLLATE utf8_bin NOT NULL,
  `admin_pass` VARCHAR(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`admin_id`)
);

-- Student Table
CREATE TABLE IF NOT EXISTS `student` (
  `stu_id` INT(11) NOT NULL AUTO_INCREMENT,
  `stu_name` VARCHAR(255) COLLATE utf8_bin NOT NULL,
  `stu_email` VARCHAR(255) COLLATE utf8_bin NOT NULL,
  `stu_pass` VARCHAR(255) COLLATE utf8_bin NOT NULL,
  `stu_occ` VARCHAR(255) COLLATE utf8_bin NOT NULL,
  `stu_img` TEXT COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`stu_id`)
);

-- Enrollees Table (student enrolls in course)
CREATE TABLE IF NOT EXISTS `enrollees` (
  `enrollee_id` INT(11) NOT NULL AUTO_INCREMENT,
  `stu_id` INT(11) NOT NULL,
  `course_id` INT(11) NOT NULL,
  `enrolment_date` DATE NOT NULL,
  PRIMARY KEY (`enrollee_id`),
  FOREIGN KEY (`stu_id`) REFERENCES `student`(`stu_id`),
  FOREIGN KEY (`course_id`) REFERENCES `course`(`course_id`)
);

-- Lesson Table (course lessons)
CREATE TABLE IF NOT EXISTS `lesson` (
  `lesson_id` INT(11) NOT NULL AUTO_INCREMENT,
  `lesson_name` TEXT COLLATE utf8_bin NOT NULL,
  `lesson_desc` TEXT COLLATE utf8_bin NOT NULL,
  `lesson_link` TEXT COLLATE utf8_bin NOT NULL,
  `course_id` INT(11) NOT NULL,
  PRIMARY KEY (`lesson_id`),
  FOREIGN KEY (`course_id`) REFERENCES `course`(`course_id`)
);

-- Activity Table (course activities)
CREATE TABLE IF NOT EXISTS `activity` (
  `activity_id` INT(11) NOT NULL AUTO_INCREMENT,
  `course_id` INT(11) NOT NULL,
  `activity_title` VARCHAR(255) COLLATE utf8_bin NOT NULL,
  `activity_link` TEXT COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`activity_id`),
  FOREIGN KEY (`course_id`) REFERENCES `course`(`course_id`)
);

COMMIT;

-- Inserting Admin
INSERT INTO `admin` (`admin_name`, `admin_email`, `admin_pass`) VALUES 
('Admin John', 'admin.john@example.com', 'adminpass123');

-- Inserting Instructor
INSERT INTO `instructor` (`instructor_fname`, `instructor_lname`, `instructor_dob`, `instructor_sex`, `instructor_email`, `instructor_pass`) VALUES 
('Alice', 'Smith', '1985-04-15', 'Female', 'alice.smith@example.com', 'instructor123');

-- Inserting Course (with instructor_id)
INSERT INTO `course` (`instructor_id`, `course_name`, `course_desc`, `course_date`, `course_img`) VALUES
(1, 'Advanced PHP Programming', 'Learn advanced techniques for PHP programming including OOP, MVC, and more.', '2024-01-01', 'php_course_image.jpg');

-- Inserting Student
INSERT INTO `student` (`stu_name`, `stu_email`, `stu_pass`, `stu_occ`, `stu_img`) VALUES
('John Doe', 'johndoe@example.com', 'password123', 'Software Developer', 'student_image.jpg');

-- Inserting Enrollee (linking Student with Course)
INSERT INTO `enrollees` (`stu_id`, `course_id`, `enrolment_date`) VALUES
(1, 1, '2024-01-05');

-- Inserting Lesson
INSERT INTO `lesson` (`lesson_name`, `lesson_desc`, `lesson_link`, `course_id`) VALUES
('Introduction to PHP', 'Learn the basics of PHP programming language.', 'lesson1_video.mp4', 1);

-- Inserting Activity
INSERT INTO `activity` (`course_id`, `activity_title`, `activity_link`) VALUES
(1, 'PHP Practice Assignment', 'activity1_link.pdf');
";

// Execute the SQL statements
if ($conn->multi_query($sql)) {
    // echo "<div id='successMessage'>Database $db_name created successfully.</div>";
} else {
    echo "Error creating tables: " . $conn->error;
}

// Close the connection
$conn->close();
?>

<script>
    setTimeout(function() {
        var messageDiv = document.getElementById('successMessage');
        if (messageDiv) {
            messageDiv.style.display = 'none';
        }
    }, 2000);
</script>
