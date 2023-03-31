<?php
require_once 'test.php';


$time = time();
$dateTime = new DateTime();
$timestamp = $dateTime->getTimestamp();


// Create user instances
$teacher = new Teacher(3, 'Teacher', 'Chris', 'sole@gmail.com', 'teacher.jpg', 'Mr.');
$student = new Student(15, 'Alex', 'Albert', 'henok@example.com', 'student.jpg', '');

// Save users to the database
$teacher->save();
$student->save();
$time = time();

// Create a message instance
$message = new Message($teacher, $student, 'Hello.', $timestamp, 'System');

// Save the message to the database
if ($message->save()) {
    echo "Message saved successfully.";
} else {
    echo "Failed to save the message.";
}
