<?php
require_once("../config/dbconnection.php");

class TeacherFunctions {
    private $dbcon;
    private $state;
    private $errmsg;

    public function __construct(){
        try {
            $db = new Database();
            if ($db->getState()) {
                $this->dbcon = $db->getDb();
                $this->state = true;
                $this->errmsg = "Connected";
            } else {
                $this->state = false;
                $this->errmsg = $db->getErrMsg();
            }
        } catch (Exception $e) {
            $this->state = false;
            $this->errmsg = $e->getMessage();
        }
    }

    public function getState() {
        return $this->state;
    }

    public function getErrMsg() {
        return $this->errmsg;
    }

    public function signUpTeacher($firstname, $lastname, $email, $password) {
        $sql = "CALL sp_signup_teacher(:firstname, :lastname, :email, :password)";
        $stmt = $this->dbcon->prepare($sql);

        $stmt->bindParam(':firstname', $firstname);
        $stmt->bindParam(':lastname', $lastname);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);

        try {
            $stmt->execute();
            // Check if the procedure executed successfully
            if ($stmt->rowCount() > 0) {
                return 1; // Success
            } else {
                return 0; // Failed
            }
        } catch (Exception $ex) {
            $this->errmsg = $ex->getMessage();
            return -1; // Error
        }
    }

    public function signInTeacher($email, $password) {
        $sql = "CALL sp_signin_teacher(:email, :password)";
        $stmt = $this->dbcon->prepare($sql);

        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);

        try {
            $stmt->execute();
    
            // Check if the procedure executed successfully
            if ($stmt->rowCount() > 0) {
                return 1; // Success
            } else {
                return 0; // Incorrect email or password
            }
        } catch (Exception $ex) {
            $this->errmsg = $ex->getMessage();
            return -1; // Error
        }
    }

    public function updateTeacher($teacher_id, $firstname, $lastname, $email, $password) {
        $sql = "CALL sp_update_teacher(:teacher_id, :firstname, :lastname, :email, :password)";
        $stmt = $this->dbcon->prepare($sql);

        $stmt->bindParam(':teacher_id', $teacher_id, PDO::PARAM_INT);
        $stmt->bindParam(':firstname', $firstname);
        $stmt->bindParam(':lastname', $lastname);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);

        try {
            $stmt->execute();
    
            // Check if the procedure executed successfully
            if ($stmt->rowCount() > 0) {
                return 1; // Success
            } else {
                return 0; // Incorrect email or password
            }
        } catch (Exception $ex) {
            $this->errmsg = $ex->getMessage();
            return -1; // Error
        }
    }

    public function deleteTeacher($teacher_id) {
        $sql = "CALL sp_delete_teacher(:teacher_id)";
        $stmt = $this->dbcon->prepare($sql);
        $stmt->bindParam(':teacher_id', $teacher_id, PDO::PARAM_INT);

        try {
            $stmt->execute();
    
            // Check if the procedure executed successfully
            if ($stmt->rowCount() > 0) {
                return 1; // Success
            } else {
                return 0; // Incorrect email or password
            }
        } catch (Exception $ex) {
            $this->errmsg = $ex->getMessage();
            return -1; // Error
        }
    }

    public function updateStudent($student_lists_id, $teacher_id, $firstname, $lastname, $email, $gender, $birthdate, $contactnumber, $addressed, $school_id_number, $degree, $section) {
        $sql = "CALL sp_update_student(:student_lists_id, :teacher_id, :firstname, :lastname, :email, :gender, :birthdate, :contactnumber, :addressed, :school_id_number, :degree, :section)";
        $stmt = $this->dbcon->prepare($sql);

        $stmt->bindParam(':student_lists_id', $student_lists_id, PDO::PARAM_INT);
        $stmt->bindParam(':teacher_id', $teacher_id, PDO::PARAM_INT);
        $stmt->bindParam(':firstname', $firstname);
        $stmt->bindParam(':lastname', $lastname);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':gender', $gender);
        $stmt->bindParam(':birthdate', $birthdate);
        $stmt->bindParam(':contactnumber', $contactnumber);
        $stmt->bindParam(':addressed', $addressed);
        $stmt->bindParam(':school_id_number', $school_id_number);
        $stmt->bindParam(':degree', $degree);
        $stmt->bindParam(':section', $section);

        try {
            $stmt->execute();
    
            // Check if the procedure executed successfully
            if ($stmt->rowCount() > 0) {
                return 1; // Success
            } else {
                return 0; // Incorrect email or password
            }
        } catch (Exception $ex) {
            $this->errmsg = $ex->getMessage();
            return -1; // Error
        }
    }

    public function deleteStudent($student_lists_id) {
        $sql = "CALL sp_delete_student(:student_lists_id)";
        $stmt = $this->dbcon->prepare($sql);
        $stmt->bindParam(':student_lists_id', $student_lists_id, PDO::PARAM_INT);

        try {
            $stmt->execute();
    
            // Check if the procedure executed successfully
            if ($stmt->rowCount() > 0) {
                return 1; // Success
            } else {
                return 0; // Incorrect email or password
            }
        } catch (Exception $ex) {
            $this->errmsg = $ex->getMessage();
            return -1; // Error
        }
    }

    public function searchStudent($search_term) {
        $sql = "CALL sp_search_student(:search_term)";
        $stmt = $this->dbcon->prepare($sql);
        $stmt->bindParam(':search_term', $search_term, PDO::PARAM_STR);

        try {
            $stmt->execute();
            // Fetch the results
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $ex) {
            $this->errmsg = $ex->getMessage();
            return false; // Error
        }
    }

    public function getStudent($student_lists_id) {
        $sql = "CALL sp_get_student(:student_lists_id)";
        $stmt = $this->dbcon->prepare($sql);
        $stmt->bindParam(':student_lists_id', $student_lists_id, PDO::PARAM_INT);

        try {
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $ex) {
            $this->errmsg = $ex->getMessage();
            return null; // Error
        }
    }

    public function insertStudent($teacher_id, $firstname, $lastname, $email, $gender, $birthdate, $contactnumber, $addressed, $school_id_number, $degree, $section) {
        $sql = "CALL sp_insert_student(:teacher_id, :firstname, :lastname, :email, :gender, :birthdate, :contactnumber, :addressed, :school_id_number, :degree, :section)";
        $stmt = $this->dbcon->prepare($sql);

        $stmt->bindParam(':teacher_id', $teacher_id, PDO::PARAM_INT);
        $stmt->bindParam(':firstname', $firstname);
        $stmt->bindParam(':lastname', $lastname);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':gender', $gender);
        $stmt->bindParam(':birthdate', $birthdate);
        $stmt->bindParam(':contactnumber', $contactnumber);
        $stmt->bindParam(':addressed', $addressed);
        $stmt->bindParam(':school_id_number', $school_id_number);
        $stmt->bindParam(':degree', $degree);
        $stmt->bindParam(':section', $section);

        try {
            $stmt->execute();
    
            // Check if the procedure executed successfully
            if ($stmt->rowCount() > 0) {
                return 1; // Success
            } else {
                return 0; // Incorrect email or password
            }
        } catch (Exception $ex) {
            $this->errmsg = $ex->getMessage();
            return -1; // Error
        }
    }

    public function getTeacherId($email) {
        $sql = "CALL sp_get_teacher_id(:email)";
        $stmt = $this->dbcon->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    
        try {
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $ex) {
            $this->errmsg = $ex->getMessage();
            return null; // Error
        }
    }    
}
?>
