<?php

//Verifica se tutti i dati sono stati entrati 

session_start();
$Name = $_POST['Name'];
$Company = $_POST['Company'];
$email =$_POST['email'];
$password = md5($_POST['password']);
$confermpassword = md5($_POST['confermpassword']);

   if
       ( !empty($email) ) 
   {
       
       include "pageperso.php";
       
if(mysqli_connect_error())
{
die('connect_Error('.mysqli_connect_errno().')'.mysqli_connect_error());
 }
   
       else
    {   
            if(filter_var($email, FILTER_VALIDATE_EMAIL)) 
            {
                
               $SELECT ="SELECT Name FROM profil WHERE Name= ? Limit 1";
                
                $INSERT= "INSERT INTO profil (Name, Company, email, password) VALUES (?,?,?,?)";
              
              
 //prepared statement
                    
     $stmt = $conn ->prepare ($SELECT);
     $stmt -> bind_param("i", $Name);
     $stmt -> execute();
     $stmt ->store_result();
     $rnum =$stmt -> num_rows;
                    
    if($rnum == 0)
        {
 $SELECTE ="SELECT email FROM profil WHERE email= ? Limit 1";          
     $stmt = $conn ->prepare ($SELECTE);
     $stmt -> bind_param("s", $email);
     $stmt -> execute();
     $stmt ->store_result();
     $rnume =$stmt -> num_rows    
            
            
     $conn->query($INSERT);          
   
    
require 'Phpmailer/PHPMailerAutoload.php';
$mail = new PHPMailer;
$mail ->Host ='smtp.gmail.com';
$mail->port=587;
$mail->SMPTPAuth =true;
$mail->SMTPSecure='tls';
$mail->Username='site43244@gmail.com';
$mail->Password ='Qwerty.1234';
//echo   $verification_mail['email'];
$mail->setFrom($_POST['email']);
$mail->addAddress($_POST['email']);
$mail->addReplyTo('site43244@gmail.com');
$mail->isHTML(true);
$mail->Subject ='conferm registration';
$mail->Body ="your registration have sucessfullu done";
if(!$mail->send())
{
    echo "we have a problem to send the mail";
}
else
{
   echo "we have send a mail to your address"; 
}

                       
        echo "we have create the account !" ;
          
        
header('Location:https://webdev.dibris.unige.it/~S4412388/startup/html/loginmedico.html');
                     
                  } 
                   
                   
               }
        else
        {
            echo 'we had already use this mail';
        }
    }
                else
                   { 
                   
                     echo "questo pseudo or name è già stato usato ";
                  
               }
               
                
            } 
             else {
              
                echo "this is invalid mail !";
                
            }
             
             
          {
              $stmt ->close();
              $conn -> close();
          }
      
