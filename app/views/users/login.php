<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="test">
  <meta name="author" content="SAH">
  <title><?php echo SITENAME; ?></title>

  <link rel="stylesheet" href="<?php echo URLROOT; ?>icon/fontawesome/css/all.css">
  <link rel="stylesheet" href="<?php echo URLROOT; ?>css/login.css">

</head>

<body>
  <div class="wrapper">
    <div class="column1">
      <h1>Inventory Management <br>System</h1>
      <img src="<?php echo URLROOT; ?>img/inventory-2.png" alt="Background">
    </div>
    <div class="column2">

      <h2 class="title2">WELCOME</h2>
      <img src="<?php echo URLROOT; ?>img/nawalanka-logo.png" alt="Company Logo">

      <form action="<?php echo URLROOT; ?>users/login" method="POST" novalidate>
        <span id="frm_status" class="status <?php echo $data['frm_state']; ?>" aria-live="polite">
          <?php foreach ($data['frm_msg'] as $formStatus) : ?>
            <p><?php echo $formStatus; ?></p>
          <?php endforeach; ?>
        </span>

        <div class="form-input">
          <i class="fas fa-user"></i>
          <input class="" id="txt_username" name="txt_username" type="text" placeholder="Username" autocomplete="off" required minlength="8">
          <span aria-live="polite"></span>
        </div>

        <div class="form-input">
          <i class="fas fa-lock"></i>
          <input class="" id="pas_password" name="pas_password" type="password" placeholder="Password" autocomplete="off" required>
          <span aria-live="polite"></span>
        </div>

        <div class="form-button">
          <button type="submit">Login</button>
        </div>

      </form>

    </div>
  </div>

</body>

</html>