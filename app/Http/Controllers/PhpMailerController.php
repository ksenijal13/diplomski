<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;

class PhpMailerController extends Controller
{
    public function sendEmail (Request $request) {
        $userEmail = $request->post("email");
        // is method a POST ?
        $request->session()->put("email", $userEmail);
            //require 'vendor/autoload.php';													// load Composer's autoloader

            $mail = new PHPMailer(true);                            // Passing `true` enables exceptions

            try {
                // Server settings
                $mail->SMTPDebug = 0;                                	// Enable verbose debug output
                $mail->isSMTP();                                     	// Set mailer to use SMTP
                $mail->Host = 'smtp.gmail.com';												// Specify main and backup SMTP servers
                $mail->SMTPAuth = true;                              	// Enable SMTP authentication
                $mail->Username = 'ksenijalazic13@gmail.com';             // SMTP username
                $mail->Password = 'Programerkamala98';              // SMTP password
                $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
                $mail->Port = 587;                                    // TCP port to connect to

                //Recipients
                $mail->setFrom('ksenijalazic13@gmail.com', 'Mailer');
                $mail->addAddress($userEmail, 'Optional name');	// Add a recipient, Name is optional
                $mail->addReplyTo('ksenijalazic13@gmail.com', 'Mailer');
                $mail->addCC($userEmail);
                $mail->addBCC($userEmail);

                //Attachments (optional)
                // $mail->addAttachment('/var/tmp/file.tar.gz');			// Add attachments
                // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');	// Optional name
                $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

                $randomPassword = substr(str_shuffle(str_repeat($pool, 5)), 0, 10);
                $request->session()->put("new-password", $randomPassword);

                //Content
                $mail->isHTML(true); 																	// Set email format to HTML
                $mail->Subject = 'Obnova lozinke';
                $mail->Body    = 'Vaša nova lozinka je: '. $randomPassword;			// message

                $mail->send();
                $request->session()->put("success", "Success.");
                return back();

            } catch (Exception $e) {
                $request->session()->put("error", "Error.");
                return back();
            }

        return view('phpmailer');
    }
}
