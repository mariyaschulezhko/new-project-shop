<?php
require_once __DIR__ . '/../layouts/header.php';
?>


<section>
    <div class="container">
        <div class="row">

            <div class="col-sm-4 col-sm-offset-4 padding-right">

                    <?php if (@$result): ?>
                        <h1>Вы зарегистрированы!</h1>
                        <?php else: ?>

                <?php if (isset($errors) && is_array($errors)): ?>
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li>- <?= $error; ?></li>
                        <?php endforeach; ?>
                    </ul>


                <?php endif; ?>



                <div class="signup-form">
                    <h2>Регистрация на сайте</h2>
                    <form action="#" method="post">
                        <input type="text" name="name" placeholder="Имя" value="<?= $name; ?>">
                        <input type="email" name="email" placeholder="E-mal" value="<?= $email; ?>">
                        <input type="password" name="password" placeholder="Пароль">
                        <button type="submit" name="submit" class="btn btn-default">Регистрация</button>
                    </form>
                </div>
                 <?php endif; ?>
                <br>
                <br>
            </div>
        </div>
    </div>
</section>


<?php require_once __DIR__ . '/../layouts/footer.php';?>