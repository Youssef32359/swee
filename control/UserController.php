<?php
require_once __DIR__ . '/../model/DB.php'; 
require_once __DIR__ . '/../vendor/autoload.php'; 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class UserController {
    private $conn;

    public function __construct() {
        $db = DB::getInstance(); 
        $this->conn = $db->getConnection(); 
    }

  
    public function getUserRole($userId) {
        $stmt = $this->conn->prepare("SELECT role FROM users WHERE id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $stmt->bind_result($role);
        $stmt->fetch();
        return $role;  
    }

    
    public function signup($fullname, $email, $password, $mobile) {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        
        $token = bin2hex(random_bytes(50)); 

       
        $stmt = $this->conn->prepare("INSERT INTO users (fullname, email, password, mobile, token, is_verified) VALUES (?, ?, ?, ?, ?, 0)");
        $stmt->bind_param("sssss", $fullname, $email, $hashed_password, $mobile, $token);

        if ($stmt->execute()) {
          
            $this->sendVerificationEmail($email, $token);
            return "Signup successful! Please check your email to verify your account.";
        } else {
           
            error_log("Signup Error: " . $this->conn->error);
            return "Error during signup. Please try again.";
        }
    }

   
    private function sendVerificationEmail($email, $token) {
        $mail = new PHPMailer(true);
        try {
           
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'youssefhesham32359@gmail.com'; 
            $mail->Password = 'rtyb xojl kozn ursv'; 
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

          
            $mail->setFrom('youssefhesham32359@gmail.com', 'YoussefSSO');
            $mail->addAddress($email);

       
            $mail->isHTML(true);
            $mail->Subject = 'Email Verification';
            $mail->Body = "<div style='font-size: 20px;'>Please verify your email by clicking this link: <a href='http://localhost/swee/verify.php?token=$token' style='font-size: 20px; color: blue;'>Verify Email</a></div>";

         
            $mail->send();
        } catch (Exception $e) {
           
            error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
        }
    }

 
    public function login($email, $password) {
        $stmt = $this->conn->prepare("SELECT id, fullname, password, is_verified, role FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $fullname, $hashed_password, $is_verified, $role);
            $stmt->fetch();

            if (password_verify($password, $hashed_password)) {
                if ($is_verified) {
                    if (session_status() == PHP_SESSION_NONE) {
                        session_start();
                    }
                    $_SESSION['ID'] = $id;
                    $_SESSION['FullName'] = $fullname;
                    $_SESSION['role'] = $role; 

                    
                    if ($role === 'admin') {
                        header("Location: ../view/dashboard.php");
                    } elseif ($role === 'club_leader') {
                        header("Location: ../view/club_leader_dashboard.php");
                    } else { // Default role: user
                        header("Location: ../index.php");
                    }
                    exit;
                } else {
                    return "Please verify your email before logging in.";
                }
            } else {
                return "Invalid credentials!";
            }
        } else {
            return "No account found with this email!";
        }
    }

   
    public function verifyEmail($token) {
        $stmt = $this->conn->prepare("UPDATE users SET is_verified = 1, token = NULL WHERE token = ?"); 
        $stmt->bind_param("s", $token);

        if ($stmt->execute()) {
            return "Your email has been verified successfully!";
        } else {
            return "Error verifying email.";
        }
    }
}
?>
