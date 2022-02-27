<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/core/src/Bootstrap.php';
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
            <?php if (is_array($class->messages) && !empty($class->messages)) { ?>
                <?php foreach ($class->messages as $type => $item) {
                    if ($type === 'success') {
                        $alertClass = 'success';
                        $role = 'status';
                    } else {
                        $alertClass = 'warning';
                        $role = 'alert';
                    } ?>
                    <div class="alert <?=$alertClass?>" role="<?=$role?>">
                        <ul>
                            <?php foreach ($item as $message) { ?>
                                 <li><?=$message?></li>
                            <?php } ?>
                        </ul>
                    </div>
                <?php } ?>
            <?php } ?>

            <form method="POST" action="">
                <input type="hidden" name="submit" value="1">
                <?php if (is_array($class->fields) && !empty($class->fields)) { ?>
                    <?php foreach ($class->fields as $name => $field) { ?>
                        <div class="form-group">
                            <label for="<?=$name?>"><?=$field['placeholder']?></label>
                            <input name="<?=$name?>" type="<?=$field['type']?>" placeholder="<?=$field['placeholder']?>"/>
                        </div>
                    <?php } ?>
                <?php } ?>
                <div class="form-action">
                    <button type="submit" class="button-link">Register</button>
                </div>
            </form>
        </main>
    </body>
</html>
