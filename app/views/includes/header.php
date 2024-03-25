<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="Cache-Control" content="no-cache">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="inventory application">
  <meta name="author" content="SAH">

  <link rel="shortcut icon" type="image/x-icon" href="<?php echo URLROOT; ?>icon/bl_paws_Favicon.ico">
  <title><?php echo SITENAME; ?></title>

  <link rel="stylesheet" href="<?php echo URLROOT; ?>icon/fontawesome/css/all.css">
  <link rel="stylesheet" href="<?php echo URLROOT; ?>css/main.css">
  <!-- <link rel="stylesheet" href="<?php //echo URLROOT; 
                                    ?>css/bootstrap.css"> -->
  <?php
  if (isset($data['style'])) {
    echo '<link rel="stylesheet" href="' . URLROOT . 'css/' . $data['style'] . '.css">';
  }
  ?>
  <script type="text/javascript" src="<?php echo URLROOT; ?>js/main.js"></script>
</head>

<body>
  <div id="grid_container">