<?php 


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require "../vendor/autoload.php";

if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $email = $_POST['em'] ?? '';
        $name = $_POST['nm'] ?? '';
        $message = $_POST['ms'] ?? '';

        if(!filter_var($email, FILTER_VALIDATE_EMAIL))
            {
                header("Location: ../contact.php?error=Invalid email address");
                exit();
            }

            if(empty($message) || empty($name))
                {
                    header("Location: ../contact.php?error=All fields are required");
                    exit();
                }

                $mail = new PHPMailer(true);

            
            try
            {
                $mail -> isSMTP();
                $mail -> Host = 'smtp.gmail.com';

                $mail -> SMTPAuth = true;
                $mail -> Username = "7amzagamer2070@gmail.com";
                $mail -> Password = "tmlscfkzutrufjkq";
                
                $mail -> SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

                $mail -> Port = 587;

                $mail -> setFrom($email, $name);

                $mail -> addAddress('hamzahu933@gmail.com');


                $mail -> isHTML(true);
                $mail -> Subject = "Feedback From My portfolio Website";

                $mail -> Body ="
                <h2>New Message from Website</h2>
                <hr>
                <p><strong>Name:</strong> {$name}</p>
                <p><strong>Email</strong> {$email}</p>
                <p><strong>Subject:</strong> Feedback From My portfolio Website</p>
                <p><strong>Message:</strong><br>{$message}</p>";

                $mail -> AltBody = "Name: $name\nEmail: $email\nSubject: Feedback From My portfolio Website\nMessage: $message";

                $mail -> send();

                header("Location: ../contact.php?success=1");
                exit();

            } catch(Exception $ex){

                header("Location: ../contact.php?error=Message could not be sent");
                exit();

            }


    } else{
        header("Location: ../contact.php");
        exit();
    }





?>