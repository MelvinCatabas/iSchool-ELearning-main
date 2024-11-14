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
  
    INSERT INTO `course` (`instructor_id`, `course_name`, `course_desc`, `course_date`, `course_img`) VALUES
(1, 'Learn Guitar The Easy Way', 'This course is your Free Pass to playing guitar. It is the most direct and to the point complete online guitar course.', '2024-01-01', '../image/courseimg/Guitar.jpg'),
(1, 'Complete PHP Bootcamp', 'This course will help you get all the Object Oriented PHP, MYSQLi and end the course by building a CMS system.', '2024-02-01', '../image/courseimg/php.jpg'),
(1, 'Learn Python A-Z', 'This is the most comprehensive, yet straightforward course for the Python programming language.', '2024-03-01', '../image/courseimg/Python.jpg'),
(1, 'Hands-on Artificial Intelligence', 'Learn and master how AI works and how it is changing our lives in this course.', '2024-04-01', '../image/courseimg/ai.jpg'),
(1, 'Learn Vue JS', 'The skills you will learn from this course are applicable to the real world, so you can go ahead and build similar apps.', '2024-05-01', '../image/courseimg/vue.jpg'),
(1, 'Angular JS', 'Angular is one of the most popular frameworks for building client apps with HTML, CSS, and TypeScript.', '2024-06-01', '../image/courseimg/angular.jpg'),
(1, 'Python Complete', 'This is a complete Python course.', '2024-07-01', '../image/courseimg/Python.jpg'),
(1, 'Learn React Native', 'This course covers React Native for Android and iOS app development.', '2024-08-01', '../image/courseimg/Machine.jpg');

";

    if (!$conn->query($course_insert)) {
        throw new Exception("Error inserting course: " . $conn->error);
    }

    // Insert Student Record
    $student_insert = "
    INSERT INTO `student` (`stu_name`, `stu_email`, `stu_pass`, `stu_occ`, `stu_img`) VALUES
('John Doe', 'john@gmail.com', '1234', 'Software Developer', 'student_image.jpg'); 
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
 INSERT INTO `lesson` (`lesson_name`, `lesson_desc`, `lesson_link`, `course_id`) VALUES
('Introduction to Python', 'Introduction to Python Desc', '../lessonvid/video2.mp4', 1),
( 'How Python Works', 'How Python Works Descc', '../lessonvid/video3.mp4', 1),
( 'Why Python is powerful', 'Why Python is powerful Desc', '../lessonvid/video9.mp4', 2);

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