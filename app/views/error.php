<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="test">
  <meta name="author" content="SAH">

  <title>Error</title>
  <link rel="stylesheet" href="<?php echo URLROOT ?>/icon/fontawesome/css/all.css">
  <style>
    .title {
      color: #ce2e3e;
      text-align: center;
      font-size: 20px;
    }

    .message {
      color: #444;
    }
  </style>
</head>

<body>
  <h1 class="title">
    <i class="fas fa-exclamation-triangle"></i>
    UNEXPECTED ERROR!
  </h1>
  <br>

  <div class="message">
    <p>
      <?php //echo $data['msg']; 
      ?>
    </p>
  </div>
</body>

</html>