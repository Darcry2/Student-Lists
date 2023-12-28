<?php
require_once("../object/teacherfunctions_object.php");
require_once("../config/dbconnection.php");

// Set the response type to JSON
header('Content-Type: application/json');
// Allow requests from any origin
header('Access-Control-Allow-Origin: *');
// Allow both POST and GET methods
header('Access-Control-Allow-Methods: POST GET');
// Allow the Content-Type header in the request
header('Access-Control-Allow-Headers: Content-Type');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input from the form
    $action = $_POST["action"];

    // Create an instance of the TeacherFunctions class
    $teacherFunctions = new TeacherFunctions();

    // Check if the database connection is successful
    if ($teacherFunctions->getState()) {
        // Handle different actions based on the provided action parameter
        switch ($action) {
            case 'signUpTeacher':
                handleSignUpTeacher($teacherFunctions);
                break;
            case 'signInTeacher':
                handleSignInTeacher($teacherFunctions);
                break;
            case 'updateTeacher':
                handleUpdateTeacher($teacherFunctions);
                break;
            case 'deleteTeacher':
                handleDeleteTeacher($teacherFunctions);
                break;
            case 'insertStudent':
                handleInsertStudent($teacherFunctions);
                break;
            case 'getStudent':
                handleGetStudent($teacherFunctions);
                break;
            case 'updateStudent':
                handleUpdateStudent($teacherFunctions);
                break;
            case 'deleteStudent':
                handleDeleteStudent($teacherFunctions);
                break;
            case 'searchStudent':
                handleSearchStudent($teacherFunctions);
                break;
            case 'getTeacherId':
                handleGetTeacherId($teacherFunctions);
                break;
            // Add more cases for other actions if needed
            default:
                // Unknown action
                $response = [
                    'status' => 'error',
                    'message' => 'Unknown action.'
                ];
                echo json_encode($response);
                break;
        }
    } else {
        // Database connection failed
        $response = [
            'status' => 'error',
            'message' => 'Error connecting to the database: ' . $teacherFunctions->getErrMsg()
        ];
        echo json_encode($response);
    }
}

// Function to handle teacher sign-up
function handleSignUpTeacher($teacherFunctions)
{
    // Get user input from the form
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Attempt to sign up the teacher
    $result = $teacherFunctions->signUpTeacher($firstname, $lastname, $email, $password);

    // Prepare the response array
    $response = [];

    if ($result === 1) {
        // Sign-up successful
        $response['status'] = 'success';
        $response['message'] = 'Teacher signed up successfully!';
        $response['redirect'] = '../view/signin.html'; // Redirect if the user is done signing up
    } elseif ($result === 0) {
        // Sign-up failed
        $response['status'] = 'error';
        $response['message'] = 'Sign-up failed.';
    } else {
        // Error occurred during sign-up
        $response['status'] = 'error';
        $response['message'] = 'Error: ' . $teacherFunctions->getErrMsg();
    }

    // Encode and echo the response
    echo json_encode($response);
}

// Function to handle teacher sign-in
function handleSignInTeacher($teacherFunctions)
{
    // Get user input from the form
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Attempt to sign in the teacher
    $result = $teacherFunctions->signInTeacher($email, $password);

    // Prepare the response array
    $response = [];

    if ($result === 1) {
        // Sign-up successful
        $response['status'] = 'success';
        $response['message'] = 'Teacher signed in successfully!';
        $response['redirect'] = '../view/home.html'; // Redirect if the user is done signing up
    } elseif ($result === 0) {
        // Sign-up failed
        $response['status'] = 'error';
        $response['message'] = 'Error signing in teacher.';
    } else {
        // Error occurred during sign-up
        $response['status'] = 'error';
        $response['message'] = 'Error: ' . $teacherFunctions->getErrMsg();
    }
    // Encode and echo the response
    echo json_encode($response);
}

// Function to handle teacher update
function handleUpdateTeacher($teacherFunctions)
{
    // Get user input from the form
    $teacher_id = $_POST["teacher_id"];
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Attempt to update the teacher
    $result = $teacherFunctions->updateTeacher($teacher_id, $firstname, $lastname, $email, $password);

    // Prepare the response array
    $response = [];

    if ($result) {
        // Update successful
        $response['status'] = 'success';
        $response['message'] = 'Teacher updated successfully!';
    } else {
        // Update failed
        $response['status'] = 'error';
        $response['message'] = 'Error updating teacher.';
    }

    // Encode and echo the response
    echo json_encode($response);
}

// Function to handle teacher deletion
function handleDeleteTeacher($teacherFunctions)
{
    // Get user input from the form
    $teacher_id = $_POST["teacher_id"];

    // Attempt to delete the teacher
    $result = $teacherFunctions->deleteTeacher($teacher_id);

    // Prepare the response array
    $response = [];

    if ($result) {
        // Delete successful
        $response['status'] = 'success';
        $response['message'] = 'Teacher deleted successfully!';
    } else {
        // Delete failed
        $response['status'] = 'error';
        $response['message'] = 'Error deleting teacher.';
    }

    // Encode and echo the response
    echo json_encode($response);
}

// Function to handle student insertion
function handleInsertStudent($teacherFunctions)
{
    // Get user input from the form
    // Add more input variables as needed
    $teacher_id = $_POST["teacher_id"];
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

    // Attempt to insert the student
    $result = $teacherFunctions->insertStudent($teacher_id, $firstname, $lastname, $email, $gender, $birthdate, $contactnumber, $addressed, $school_id_number, $degree, $section);

    // Prepare the response array
    $response = [];

    if ($result) {
        // Insert successful
        $response['status'] = 'success';
        $response['message'] = 'Student inserted successfully!';
    } else {
        // Insert failed
        $response['status'] = 'error';
        $response['message'] = 'Error inserting student.';
    }

    // Encode and echo the response
    echo json_encode($response);
}

// Function to handle student details retrieval
function handleGetStudent($teacherFunctions)
{
    // Get user input from the form
    $student_lists_id = $_POST["student_lists_id"];

    // Attempt to get student details
    $studentDetails = $teacherFunctions->getStudent($student_lists_id);

    // Prepare the response array
    $response = [];

    if ($studentDetails !== null) {
        // Get successful
        $response['status'] = 'success';
        $response['data'] = $studentDetails;
    } else {
        // Get failed
        $response['status'] = 'error';
        $response['message'] = 'Error fetching student details.';
    }

    // Encode and echo the response
    echo json_encode($response);
}

// Function to handle student update
function handleUpdateStudent($teacherFunctions)
{
    // Get user input from the form
    // Add more input variables as needed
    $student_lists_id = $_POST["student_lists_id"];
    $teacher_id = $_POST["teacher_id"];
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

    // Attempt to update the student
    $result = $teacherFunctions->updateStudent($student_lists_id, $teacher_id, $firstname, $lastname, $email, $gender, $birthdate, $contactnumber, $addressed, $school_id_number, $degree, $section);

    // Prepare the response array
    $response = [];

    if ($result) {
        // Update successful
        $response['status'] = 'success';
        $response['message'] = 'Student updated successfully!';
    } else {
        // Update failed
        $response['status'] = 'error';
        $response['message'] = 'Error updating student.';
    }

    // Encode and echo the response
    echo json_encode($response);
}

// Function to handle student deletion
function handleDeleteStudent($teacherFunctions)
{
    // Get user input from the form
    $student_lists_id = $_POST["student_lists_id"];

    // Attempt to delete the student
    $result = $teacherFunctions->deleteStudent($student_lists_id);

    // Prepare the response array
    $response = [];

    if ($result) {
        // Delete successful
        $response['status'] = 'success';
        $response['message'] = 'Student deleted successfully!';
    } else {
        // Delete failed
        $response['status'] = 'error';
        $response['message'] = 'Error deleting student.';
    }

    // Encode and echo the response
    echo json_encode($response);
}

// Function to handle student search
function handleSearchStudent($teacherFunctions)
{
    // Get user input from the form
    $search_term = $_POST["search_term"];

    // Attempt to search for students
    $searchResult = $teacherFunctions->searchStudent($search_term);

    // Prepare the response array
    $response = [];

    if ($searchResult !== false) {
        // Search successful
        $response['status'] = 'success';
        $response['data'] = $searchResult;
    } else {
        // Search failed
        $response['status'] = 'error';
        $response['message'] = 'Error searching for students.';
    }

    // Encode and echo the response
    echo json_encode($response);
}

// Function to handle getting teacher id
function handleGetTeacherId($teacherFunctions)
{
    // Get user input from the form
    $email = $_POST["email"];

    // Attempt to get teacher id
    $teacherIdResult = $teacherFunctions->getTeacherId($email);

    // Prepare the response array
    $response = [];

    if ($teacherIdResult !== null) {
        // Get successful
        $response['status'] = 'success';
        $response['teacher_id'] = $teacherIdResult['teacher_id'];
    } else {
        // Get failed
        $response['status'] = 'error';
        $response['message'] = 'Error fetching teacher ID.';
    }

    // Encode and echo the response as JSON
    echo json_encode($response);
}

?>
