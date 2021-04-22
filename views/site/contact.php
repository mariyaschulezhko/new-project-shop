<?php
require_once __DIR__ . '/../layouts/header.php';
?>

<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-4 col-sm-offset-4 padding-right">
                <?php if ($result): ?>
                <p>Сообщение отправлено:)</p>
                <?php else: ?>
                <?php if (isset($errors) && is_array($errors)): ?>
                <ul>
                    <?php foreach($errors as $error): ?>
                    <li>- <?= $error; ?></li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>

                <div class="signup-form">
                    <h2>обратная связь</h2>
                    <h5>Если у вас есть вопросы, можете написать нам</h5>
                    <br>
                    <form action="#" method="post">
                        <p>Your email</p>
                        <input type="email" name="userEmail" placeholder="Email" value="<?= $userEmail; ?>">
                        <p>Message</p>
                        <input type="text" name="userText" placeholder="Сообщение" value="<?= $userText; ?>">
                        <br>
                        <input type="submit" name="submit" class="btn btn-default" value="Send">
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
