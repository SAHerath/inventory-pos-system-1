<?php

class Home extends Controller
{
  public function __construct()
  {
    $this->userModel = $this->model('HomeM');
  }

  public function index()
  {
    $data = [
      'title' => 'Welcome',
      'tot_prodt' => '',
      'tot_order' => '',
      'tot_users' => '',
      'tot_locat' => ''
    ];

    $data['tot_prodt'] = $this->userModel->getProductCount();
    $data['tot_order'] = $this->userModel->getOrderCount();
    $data['tot_users'] = $this->userModel->getUserCount();
    $data['tot_locat'] = $this->userModel->getLocationCount();

    $this->view('home/dashboardV', $data);
  }

  public function about()
  {
    // $this->view('pages/about');
  }

  public function sendEmail()
  {
    // require_once(APPROOT . '/extensions/phpmailer/autoload.php');
    /*
    NawaLanka Enterprises
nawalankaenter@gmail.com
    njyuyhwweajbauqj   gmail app
    */

    //Create a new PHPMailer instance
    $mail = new PHPMailer(true);    //Passing true to the constructor enables the use of exceptions for error handling

    try {

      //Tell PHPMailer to use SMTP
      $mail->isSMTP();

      //Enable SMTP debugging
      // 0 = off (for production use)
      // 1 = client messages
      // 2 = client and server messages
      $mail->SMTPDebug = 0;

      //Ask for HTML-friendly debug output
      $mail->Debugoutput = 'html';

      //Set the hostname of the mail server
      $mail->Host = 'smtp.gmail.com';

      //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
      $mail->Port = 587;

      //Whether to use SMTP authentication
      $mail->SMTPAuth = true;

      //Set the encryption system to use - ssl (deprecated) or tls
      $mail->SMTPSecure = 'tls';


      //Username to use for SMTP authentication - use full email address for gmail
      $mail->Username = 'supunanuradhaherath@gmail.com';

      //Password to use for SMTP authentication
      $mail->Password = 'hdwxphtdvafpudmp';

      //Set who the message is to be sent from
      $mail->setFrom('supunanuradhaherath@gmail.com', 'SAH Technologies');

      //Set an alternative reply-to address
      // $mail->addReplyTo('supunanuradhaherath@gmail.com');

      //Set who the message is to be sent to
      // $mail->addAddress('h.supun.anuradha@gmail.com', 'Supun');

      $recipients = array(
        'Supun' => 'h.supun.anuradha@gmail.com',
        'Anura' => '1958anuraherath@gmail.com'
      );
      foreach ($recipients as $name => $email) {
        $mail->AddCC($email, $name);
      }

      $mail->isHTML(true);


      $mail->CharSet = 'UTF-8';

      //Set the subject line
      $mail->Subject = 'PHPMailer GMail SMTP test';

      //Read an HTML message body from an external file, convert referenced images to embedded,
      //convert HTML into a basic plain-text alternative body
      $mail->msgHTML(file_get_contents(APPROOT . '/views/email/emailbodyV.html'), dirname(__FILE__));

      //Replace the plain text body with one created manually
      $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';

      //Attach an image file
      // $mail->addAttachment(URLROOT . 'img/nawalanka-logo-2.png');

      //send the message, check for errors
      $mail->send();

      echo "Message sent!";
    } catch (phpmailerException $e) {
      echo $e->errorMessage(); //Pretty error messages from PHPMailer
    } catch (Exception $e) {
      echo $e->getMessage(); //Boring error messages from anything else!
    }
  }

  public function testdb()
  {
  }
}
