<?php

include_once 'global/autoloader.php';

$registration = new Registration\Controller();
$fields = $registration->fields;
$registration->run();
$errors = $registration->errors;
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registration</title>
  </head>
  <body>
      <main>
          <?php if (is_array($errors) && !empty($errors)) { ?>
            <div class="alert alert-warning" role="alert">
                <ul>
                    <?php foreach ($errors as $error) { ?>
                        <li><?=$error['message']?></li>
                    <?php } ?>
                </ul>
            </div>
          <?php } ?>
          <form method="POST" action="">
              <input type="hidden" name="submit" value="1">
            <?php foreach ($fields as $name => $field) { ?>
                <div class="form-group">
                    <label for="<?=$name?>"><?=$field['placeholder']?></label>
                    <input name="<?=$name?>" type="<?=$field['type']?>" placeholder="<?=$field['placeholder']?>"/>
                </div>
            <?php } ?>
            <div class="form-action">
                <button type="submit" class="button-link">Register</button>
            </div>
          </form>
      </main>
  </body>
</html>