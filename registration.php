<?php

include_once 'global/autoloader.php';

$registration = new Registration\Controller();
$fields = $registration->fields;
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
          <form method="POST" action="">
            <?php foreach ($fields as $name => $field) { ?>
                <label for="<?=$name?>"><?=$field['placeholder']?></label>
                <input name="<?=$name?>" type="<?=$field['type']?>" placeholder="<?=$field['placeholder']?>"/>
            <?php } ?>
          </form>
      </main>
  </body>
</html>