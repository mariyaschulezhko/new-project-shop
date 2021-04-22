<?php
require_once __DIR__ . '/../layouts/header.php';
?>

<section>
    <div class="container">
        <div class="row">
            <h1>Кабинет пользователя</h1>
            <h3>Добро пожаловать, <?= $user['name']; ?>!</h3>

            <ul>
                <li><a href="/cabinet/edit">Редактировать даные</a></li>
                <li><a href="/user/history">Список покупок</a></li>
            </ul>
        </div>
    </div>
</section>







<?php
require_once __DIR__ . '/../layouts/header.php';
?>
