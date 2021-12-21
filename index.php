<?php require 'db.php';
session_start();
require 'templates/head.html';


$query = "SELECT id FROM posts";

$items_count = $connection->query($query);
$items_count = $items_count->fetchAll();

$items_count = count($items_count);
$items_size = 6;
$offset = $items_count - $items_size;
if ($offset < 0) {
    $offset = 0;
    $items_size = $items_count - $items_size;
}

$query = "SELECT * FROM posts LIMIT $items_size OFFSET $offset";
$items = $connection->query($query);
$items = array_reverse($items->fetchAll());

?>

<body>
    <?php require 'templates/header.php' ?>
    <main>
        <div class="wrapper">
            <div class="container main__container">
                <div class="main__title">Последние публикации</div>
                <div class="post-items">
                    <?php foreach ($items as $item) : ?>
                        <a href="detailed_page.php?id=<?= $item['id'] ?>" class="post-item">
                            <div class="post-item__img-block">
                                <img src="posts_img/<?= $item['img'] ?>" alt="" class="post-item__img">
                            </div>
                            <div class="post-item__title"><?= $item['name'] ?></div>
                            <div class="post-item__date"><?= $item['date'] ?></div>
                        </a>
                    <?php endforeach; ?>
                </div>
                <?php if ($items_size == 6) : ?>
                    <button id="ajax_loader_button" class="ajax-loader-button" data-page="1" data-page-max="<?= ceil($items_count / $items_size) ?>">Загрузить ещё</button>
                <?php endif; ?>
            </div>
        </div>
    </main>
    <?php require 'templates/footer.html';
    require 'templates/forms.html' ?>
    <script src="js/forms.js"></script>
    <script src="js/ajax.js"></script>
</body>

</html>