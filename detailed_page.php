<?php require 'db.php';
session_start();
require 'templates/head.html';
$id = (int)$_GET['id'];
$query = "SELECT * FROM posts WHERE id=$id";
$post = $connection->query($query);
$post = $post->fetchAll();

$user_id = $post[0]['user_id'];
$query = ("SELECT * FROM users WHERE id=$user_id");
$owner = $connection->query($query);
$owner = $owner->fetchAll();
?>
<link rel="stylesheet" href="css/detailed_page.css">

<body>
    <?php require 'templates/header.php' ?>
    <main>
        <div class="wrapper">
            <div class="container main__container">
                <div class="main__title"><?= $post[0]['name'] ?></div>
                <div class="detailed-page">
                    <div class="detailed-page__img-block">
                        <img src="posts_img/<?= $post[0]['img'] ?>" alt="" class="detailed-page__img">
                    </div>
                    <div class="detailed-page__row">
                        <div class="detailed-page__owner">Владелец: <?= $owner[0]['name']; ?></div>
                        <div class="detailed-page__date"><?= $post[0]['date']; ?></div>
                    </div>
                    <div class="detailed-page__row">
                        <?php
                        $query = ("SELECT rating FROM posts WHERE id=$id");
                        $current_rating = $connection->query($query);
                        $current_rating = $current_rating->fetchAll();
                        $query = "SELECT post_id FROM ratings WHERE post_id=$id";
                        $rating_count = $connection->query($query);
                        $rating_count = $rating_count->fetchAll();
                        $rating_count = count($rating_count);
                        ?>
                        <div class="detailed-page__average-rating">Рейтинг: <?= $current_rating[0]['rating'] ?> (на основании <?= $rating_count ?> оценок)</div>
                    </div>
                    <?php if (($_SESSION['user'] != null) && ($_SESSION['user']['id'] != $owner[0]['id'])) : ?>
                        <div class="detailed-page__row detailed-page__row_rating">
                            <div class="detailed-page__rating-title">Ваша оценка:</div>
                            <form action="" method="POST" class="detailed-page__rating-form" id="detailed-page__rating-form">
                                <select name="selector" id="detailed-page_selector" class="detailed-page__selector">
                                    <option value="5" class="detailed-page__selector_option">5</option>
                                    <option value="4" class="detailed-page__selector_option">4</option>
                                    <option value="3" class="detailed-page__selector_option">3</option>
                                    <option value="2" class="detailed-page__selector_option">2</option>
                                    <option value="1" class="detailed-page__selector_option">1</option>
                                </select>
                                <input type="text" name="id" class="detailed-page__hidden-input" value="<?= $id ?>">
                                <input type="submit" id="detailed-page_selector-button" class="detailed-page__selector-send" value="Подтвердить оценку"></input>
                            </form>
                        </div>
                    <?php endif; ?>
                    <div class="detailed-page__row detailed-page__column">
                        <div class="detailed-page__discription-title">Описание:</div>
                        <div class="detailed-page__discription"><?= $post[0]['description'] ?></div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php require 'templates/footer.html';
    require 'templates/forms.html' ?>
    <script src="js/forms.js"></script>
    <script src="js/rating.js"></script>
</body>

</html>