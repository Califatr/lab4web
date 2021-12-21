<?php
require "db.php";
$items_size = 6;

$query = "SELECT id FROM posts";
$items_count = $connection->query($query);
$items_count = $items_count->fetchAll();
$items_count = count($items_count);


$current_page = (int)($_GET['page']);
$last_item = $items_count - (($current_page - 1) * $items_size);
$offset = $items_count - ($current_page * $items_size);
if ($offset < 0) {
    $offset = 0;
    $items_size = $last_item;
}

$query = "SELECT * FROM posts LIMIT $items_size OFFSET $offset";
$items = $connection->query($query);
$items = $items = array_reverse($items->fetchAll());

foreach ($items as $item) :
?>
    <a href="detailed_page.php?id=<?= $item['id']?>" class="post-item">
        <div class="post-item__img-block">
            <img src="posts_img/<?= $item['img'] ?>" alt="" class="post-item__img">
        </div>
        <div class="post-item__title"><?= $item['name'] ?></div>
        <div class="post-item__date"><?= $item['date'] ?></div>
    </a>
<?php endforeach; ?>