<?php
    // Include the TeacherFunctions class
    require_once("../object/teacherfunctions_object.php");
    require_once("../config/dbconnection.php");

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get user input from the form
        $teacher_id = $_POST['teacher_id'];  // You need to get the teacher_id, for example, from session or another source
        $firstname = $_POST["firstname"];
        $lastname = $_POST["lastname"];
        $email = $_POST["email"];
        $gender = $_POST["gender"];
        $birthdate = $_POST["birthdate"];
        $contactnumber = $_POST["contactnumber"];
        $addressed = $_POST["addressed"];
        $school_id_number = $_POST["school_id_number"];
        $degree = $_POST["degree"];
        $section = $_POST["section"];
        $password = $_POST["password"];

    // Create an instance of the TeacherFunctions class
    $teacherFunctions = new TeacherFunctions();

    // Check if the database connection is successful
    if ($teacherFunctions->getState()) {
        // Attempt to insert the student
        $insertResult = $teacherFunctions->insertStudent($teacher_id, $firstname, $lastname, $email, $gender, $birthdate, $contactnumber, $addressed, $school_id_number, $degree, $section);

        // Handle the insert result
        if ($insertResult) {
            // Insert successful
            echo "Student inserted successfully!";
            
            // Display the list of students
            $students = $teacherFunctions->searchStudent("");  // You might want to adjust the search term
            if ($students !== false) {
                // Display the list of students here
                echo "<pre>";
                print_r($students);
                echo "</pre>";
            } else {
                echo "Error fetching student list.";
            }

            // Redirect to a success page or perform other actions
        } else {
            // Insert failed
            echo "Error inserting student.";
            // Redirect to a failure page or display an error message
        }

        // Attempt to update the teacher
        $updateTeacherResult = $teacherFunctions->updateTeacher($teacher_id, $firstname, $lastname, $email, $password);
        // Handle the update result
        if ($updateTeacherResult) {
            // Update successful
            echo "Teacher updated successfully!";
        } else {
            // Update failed
            echo "Error updating teacher.";
        }

        // Attempt to delete the teacher
        $deleteTeacherResult = $teacherFunctions->deleteTeacher($teacher_id);
        // Handle the delete result
        if ($deleteTeacherResult) {
            // Delete successful
            echo "Teacher deleted successfully!";
        } else {
            // Delete failed
            echo "Error deleting teacher.";
        }

        // Attempt to sign in the teacher
        $signInResult = $teacherFunctions->signInTeacher($email, $password);
        // Handle the sign-in result
        if ($signInResult) {
            // Sign-in successful
            echo "Teacher signed in successfully!";
        } else {
            // Sign-in failed
            echo "Error signing in teacher.";
        }

        // Attempt to sign up the teacher
        $signUpResult = $teacherFunctions->signUpTeacher($firstname, $lastname, $email, $password);
        // Handle the sign-up result
        if ($signUpResult === 1) {
            // Sign-up successful
            echo "Teacher signed up successfully!";
        } elseif ($signUpResult === 0) {
            // Sign-up failed
            echo "Sign-up failed.";
        } else {
            // Error occurred during sign-up
            echo "Error: " . $teacherFunctions->getErrMsg();
        }

        // Attempt to get student details
        $studentDetails = $teacherFunctions->getStudent($student_lists_id);  // You need to define $student_lists_id
        // Handle the result
        if ($studentDetails !== null) {
            // Display student details
            echo "<pre>";
            print_r($studentDetails);
            echo "</pre>";
        } else {
            echo "Error fetching student details.";
        }

        // Attempt to delete a student
        $deleteStudentResult = $teacherFunctions->deleteStudent($student_lists_id);  // You need to define $student_lists_id
        // Handle the delete result
        if ($deleteStudentResult) {
            // Delete successful
            echo "Student deleted successfully!";
        } else {
            // Delete failed
            echo "Error deleting student.";
        }

        // Attempt to update a student
        $updateStudentResult = $teacherFunctions->updateStudent($student_lists_id, $teacher_id, $firstname, $lastname, $email, $gender, $birthdate, $contactnumber, $addressed, $school_id_number, $degree, $section);
        // Handle the update result
        if ($updateStudentResult) {
            // Update successful
            echo "Student updated successfully!";
        } else {
            // Update failed
            echo "Error updating student.";
        }

        // Attempt to search for students
        $searchResult = $teacherFunctions->searchStudent($search_term);  // You need to define $search_term
        // Handle the search result
        if ($searchResult !== false) {
            // Display the search results
            echo "<pre>";
            print_r($searchResult);
            echo "</pre>";
        } else {
            echo "Error searching for students.";
        }

        // Attempt to get teacher id
        $teacherIdResult = $teacherFunctions->getTeacherId($email);
        // Handle the result
        if ($teacherIdResult !== null) {
            // Display teacher id
            echo "Teacher ID: " . $teacherIdResult['teacher_id'];
        } else {
            echo "Error fetching teacher ID.";
        }
    } else {
        // Database connection failed
        echo "Error connecting to the database: " . $teacherFunctions->getErrMsg();
        // Log the error, redirect to an error page, or display a generic error message
    }
} else {
    // Redirect or handle accordingly if the form is not submitted
    echo "Invalid request.";
}
?>
