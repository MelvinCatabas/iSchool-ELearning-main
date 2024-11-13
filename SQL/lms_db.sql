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

// Start a new transaction
$conn->begin_transaction();

try {
    // Create Instructor Table
    $instructor_sql = "
    CREATE TABLE IF NOT EXISTS `instructor` (
        `instructor_id` INT(11) NOT NULL AUTO_INCREMENT,
        `instructor_fname` VARCHAR(255) COLLATE utf8_bin NOT NULL,
        `instructor_lname` VARCHAR(255) COLLATE utf8_bin NOT NULL,
        `instructor_dob` DATE NOT NULL,
        `instructor_sex` VARCHAR(10) COLLATE utf8_bin NOT NULL,
        `instructor_email` VARCHAR(255) COLLATE utf8_bin NOT NULL,
        `instructor_pass` VARCHAR(255) COLLATE utf8_bin NOT NULL,
        `instructor_img` VARCHAR(255) COLLATE utf8_bin NOT NULL,
        PRIMARY KEY (`instructor_id`)
    );
    ";
    if (!$conn->query($instructor_sql)) {
        throw new Exception("Error creating instructor table: " . $conn->error);
    }

    // Create Course Table
    $course_sql = "
    CREATE TABLE IF NOT EXISTS `course` (
        `course_id` INT(11) NOT NULL AUTO_INCREMENT,
        `instructor_id` INT(11) NOT NULL,
        `course_name` TEXT COLLATE utf8_bin NOT NULL,
        `course_desc` TEXT COLLATE utf8_bin NOT NULL,
        `course_date` DATE NOT NULL,
        `course_img` TEXT COLLATE utf8_bin NOT NULL,
        PRIMARY KEY (`course_id`),
        FOREIGN KEY (`instructor_id`) REFERENCES `instructor`(`instructor_id`)
    );
    ";
    if (!$conn->query($course_sql)) {
        throw new Exception("Error creating course table: " . $conn->error);
    }

    // Create Admin Table
    $admin_sql = "
    CREATE TABLE IF NOT EXISTS `admin` (
        `admin_id` INT(11) NOT NULL AUTO_INCREMENT,
        `admin_name` VARCHAR(255) COLLATE utf8_bin NOT NULL,
        `admin_email` VARCHAR(255) COLLATE utf8_bin NOT NULL,
        `admin_pass` VARCHAR(255) COLLATE utf8_bin NOT NULL,
        PRIMARY KEY (`admin_id`)
    );
    ";
    if (!$conn->query($admin_sql)) {
        throw new Exception("Error creating admin table: " . $conn->error);
    }

    // Create Student Table
    $student_sql = "
    CREATE TABLE IF NOT EXISTS `student` (
        `stu_id` INT(11) NOT NULL AUTO_INCREMENT,
        `stu_name` VARCHAR(255) COLLATE utf8_bin NOT NULL,
        `stu_email` VARCHAR(255) COLLATE utf8_bin NOT NULL,
        `stu_pass` VARCHAR(255) COLLATE utf8_bin NOT NULL,
        `stu_occ` VARCHAR(255) COLLATE utf8_bin NOT NULL,
        `stu_img` TEXT COLLATE utf8_bin NOT NULL,
        PRIMARY KEY (`stu_id`)
    );
    ";
    if (!$conn->query($student_sql)) {
        throw new Exception("Error creating student table: " . $conn->error);
    }

    // Create Enrollees Table
    $enrollees_sql = "
    CREATE TABLE IF NOT EXISTS `enrollees` (
        `enrollee_id` INT(11) NOT NULL AUTO_INCREMENT,
        `stu_id` INT(11) NOT NULL,
        `course_id` INT(11) NOT NULL,
        `enrolment_date` DATE NOT NULL,
        PRIMARY KEY (`enrollee_id`),
        FOREIGN KEY (`stu_id`) REFERENCES `student`(`stu_id`),
        FOREIGN KEY (`course_id`) REFERENCES `course`(`course_id`)
    );
    ";
    if (!$conn->query($enrollees_sql)) {
        throw new Exception("Error creating enrollees table: " . $conn->error);
    }

    // Create Lesson Table
    $lesson_sql = "
    CREATE TABLE IF NOT EXISTS `lesson` (
        `lesson_id` INT(11) NOT NULL AUTO_INCREMENT,
        `lesson_name` TEXT COLLATE utf8_bin NOT NULL,
        `lesson_desc` TEXT COLLATE utf8_bin NOT NULL,
        `lesson_link` TEXT COLLATE utf8_bin NOT NULL,
        `course_id` INT(11) NOT NULL,
        PRIMARY KEY (`lesson_id`),
        FOREIGN KEY (`course_id`) REFERENCES `course`(`course_id`)
    );
    ";
    if (!$conn->query($lesson_sql)) {
        throw new Exception("Error creating lesson table: " . $conn->error);
    }

    // Create Activity Table
    $activity_sql = "
    CREATE TABLE IF NOT EXISTS `activity` (
        `activity_id` INT(11) NOT NULL AUTO_INCREMENT,
        `course_id` INT(11) NOT NULL,
        `activity_title` VARCHAR(255) COLLATE utf8_bin NOT NULL,
        `activity_link` TEXT COLLATE utf8_bin NOT NULL,
        PRIMARY KEY (`activity_id`),
        FOREIGN KEY (`course_id`) REFERENCES `course`(`course_id`)
    );
    ";
    if (!$conn->query($activity_sql)) {
        throw new Exception("Error creating activity table: " . $conn->error);
    }

    // Insert Admin Record
    $admin_insert = "
    INSERT INTO `admin` (`admin_name`, `admin_email`, `admin_pass`) 
    VALUES ('Admin John', 'admin.john@example.com', 'adminpass123');
    ";
    if (!$conn->query($admin_insert)) {
        throw new Exception("Error inserting admin: " . $conn->error);
    }

    // Insert Instructor Record
    $instructor_insert = "
    INSERT INTO `instructor` (`instructor_fname`, `instructor_lname`, `instructor_dob`, `instructor_sex`, `instructor_email`, `instructor_pass`, `instructor_img`) 
    VALUES ('Alice', 'Smith', '1985-04-15', 'Female', 'alice.smith@example.com', 'instructor123', './image/stu/Kenneth.jpg');
    ";
    if (!$conn->query($instructor_insert)) {
        throw new Exception("Error inserting instructor: " . $conn->error);
    }

    // Insert Course Record (Instructor with ID 1 must exist now)
    $course_insert = "
    INSERT INTO `course` (`instructor_id`, `course_name`, `course_desc`, `course_date`, `course_img`) 
    VALUES (1, 'Advanced PHP Programming', 'Learn advanced techniques for PHP programming including OOP, MVC, and more.', '2024-01-01', 'php_course_image.jpg');
    ";
    if (!$conn->query($course_insert)) {
        throw new Exception("Error inserting course: " . $conn->error);
    }

    // Insert Student Record
    $student_insert = "
    INSERT INTO `student` (`stu_name`, `stu_email`, `stu_pass`, `stu_occ`, `stu_img`) 
    VALUES ('John Doe', 'johndoe@example.com', 'password123', 'Software Developer', 'student_image.jpg');
    ";
    if (!$conn->query($student_insert)) {
        throw new Exception("Error inserting student: " . $conn->error);
    }

    // Insert Enrollee Record
    $enrollee_insert = "
    INSERT INTO `enrollees` (`stu_id`, `course_id`, `enrolment_date`) 
    VALUES (1, 1, '2024-01-05');
    ";
    if (!$conn->query($enrollee_insert)) {
        throw new Exception("Error inserting enrollee: " . $conn->error);
    }

    // Insert Lesson Record
    $lesson_insert = "
 INSERT INTO `lesson` (`lesson_id`, `lesson_name`, `lesson_desc`, `lesson_link`, `course_id`) VALUES
(32, 'Introduction to Python', 'Introduction to Python Desc', '../lessonvid/video2.mp4', 1),
(33, 'How Python Works', 'How Python Works Descc', '../lessonvid/video3.mp4', 1),
(34, 'Why Python is powerful', 'Why Python is powerful Desc', '../lessonvid/video9.mp4', 1),
(35, 'Everyone should learn Python', 'Everyone should learn Python Desccc', '../lessonvid/video1.mp4', 1),
(36, 'Introduction to PHP', 'Introduction to PHP Desc', '../lessonvid/video4.mp4', 1),
(37, 'How PHP works', 'How PHP works Desc', '../lessonvid/video5.mp4', 1),
(38, 'is PHP really easy ?', 'is PHP really easy ? desc', '../lessonvid/video6.mp4', 1),
(39, 'Introduction to Guitar44', 'Introduction to Guitar desc1', '../lessonvid/video7.mp4', 1),
(40, 'Type of Guitar', 'Type of Guitar Desc2', '../lessonvid/video8.mp4', 1),
(41, 'Intro Hands-on Artificial Intelligence', 'Intro Hands-on Artificial Intelligence desc', '../lessonvid/video10.mp4', 1),
(42, 'How it works', 'How it works descccccc', '../lessonvid/video11.mp4', 1),
(43, 'Inro Learn Vue JS', 'Inro Learn Vue JS desc', '../lessonvid/video12.mp4', 1),
(44, 'intro Angular JS', 'intro Angular JS desc', '../lessonvid/video13.mp4', 1),
(48, 'Intro to Python Complete', 'This is lesson number 1', '../lessonvid/video11.mp4', 1),
(49, 'Introduction to React Native', 'This intro video of React native', '../lessonvid/video11.mp4', 1);

    ";
    if (!$conn->query($lesson_insert)) {
        throw new Exception("Error inserting lesson: " . $conn->error);
    }

    // Insert Activity Record
    $activity_insert = "
    INSERT INTO `activity` (`course_id`, `activity_title`, `activity_link`) 
    VALUES (1, 'PHP Practice Assignment', 'activity1_link.pdf');
    ";
    if (!$conn->query($activity_insert)) {
        throw new Exception("Error inserting activity: " . $conn->error);
    }

    // Commit the transaction
    $conn->commit();

    echo "<div id='successMessage'>Database and tables created and data inserted successfully.</div>";
} catch (Exception $e) {
    // Rollback the transaction if an error occurs
    $conn->rollback();
    echo "Transaction failed: " . $e->getMessage();
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
