<?php

$file = "students.txt";

function getStudents() {
    global $file;

    if (!file_exists($file)) {
        return [];
    }

    $lines = file($file, FILE_IGNORE_NEW_LINES);
    $students = [];

    foreach ($lines as $line) {
        list($id, $name, $email, $course) = explode("|", $line);
        $students[] = [
            "id" => $id,
            "name" => $name,
            "email" => $email,
            "course" => $course
        ];
    }

    return $students;
}

function addStudent($name, $email, $course) {
    global $file;

    $id = time();
    $data = "$id|$name|$email|$course" . PHP_EOL;
    file_put_contents($file, $data, FILE_APPEND);
}

function deleteStudent($id) {
    global $file;

    $students = getStudents();
    $newContent = "";

    foreach ($students as $student) {
        if ($student['id'] != $id) {
            $newContent .= $student['id'] . "|" .
                           $student['name'] . "|" .
                           $student['email'] . "|" .
                           $student['course'] . PHP_EOL;
        }
    }

    file_put_contents($file, $newContent);
}

function updateStudent($id, $name, $email, $course) {
    global $file;

    $students = getStudents();
    $newContent = "";

    foreach ($students as $student) {
        if ($student['id'] == $id) {
            $newContent .= "$id|$name|$email|$course" . PHP_EOL;
        } else {
            $newContent .= $student['id'] . "|" .
                           $student['name'] . "|" .
                           $student['email'] . "|" .
                           $student['course'] . PHP_EOL;
        }
    }

    file_put_contents($file, $newContent);
}