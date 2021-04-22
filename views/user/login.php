<?php
require_once __DIR__ . '/../layouts/header.php';
?>

<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-4 col-sm-offset-4 padding-right">

                <?php if (isset($errors) && is_array($errors)): ?>
                <ul>
                    <?php foreach($errors as $error): ?>
                    <li> - <?= $error; ?></li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>
                <div class="signup-form">
                    <h2>Signup</h2>
                    <form action="#" method="post">
                        <input type="email" name="email" placeholder="E-mail" value="<?= $email; ?>">
                        <input type="password" name="password" placeholder="Password" value="<?= $password; ?>">
                        <input type="submit" name="submit" class="btn btn-default" value="Signup">
                    </form>
                </div>
                <br>
                <br>

            </div>
        </div>
    </div>
</section>






<?php require_once __DIR__ . '/../layouts/footer.php';  ?>
