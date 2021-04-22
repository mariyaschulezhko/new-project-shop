<?php

require_once __DIR__ . '/../layouts/header.php';
?>
<section>
    <div class="container">
            <div class="row">
                <div class="col-sm-4 col-sm-offset-4 padding-right">
            <?php if($result): ?>
            <p>Data edited</p>
            <?php else: ?>
           <?php if (isset($errors) && is_array($errors)): ?>
            <ul>
                <?php foreach($errors as $error): ?>
                <li> -<?=$error; ?> </li>
                <?php endforeach; ?>
            </ul>
            <?php endif; ?>

        <div class="signup-form">
            <h2>Edit data</h2>
            <form action="#" method="post">
                <p>Name:</p>
                <input type="text" name="name" placeholder="Name" value="<?= $name; ?>">
                <p>Password:</p>
                <input type="password" name="password" placeholder="Password" value="<?= $password; ?>">
                <br>
                <input type="submit" name="submit" class="btn btn-default" value="Save">
            </form>
        </div>
        <?php endif; ?>
       <br>
        <br>
    </div>
    </div>
</div>


</section>




<?php

require_once __DIR__ . '/../layouts/footer.php';
?>
