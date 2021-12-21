<?php
session_start();
header('Content-Type: application/json');

if ($_SESSION['user'] == null)
{
    echo("У вас нет прав!");
    die();
}

require 'db.php';

$new_value = (int)$_POST['selector'];
$id = $_POST['id'];
$user_id = $_SESSION['user']['id'];

$old_rating = $connection->prepare("SELECT rating FROM posts WHERE id=?");
$old_rating ->execute([$id]);
$old_rating = $old_rating->fetchAll();

$ratings_count = $connection->prepare("SELECT * FROM ratings WHERE post_id=?");
$ratings_count->execute([$id]);
$ratings_count = $ratings_count->fetchAll();
$ratings_count = count($ratings_count);

$query = "SELECT * FROM ratings WHERE post_id=$id AND user_id=$user_id";
$rating_repeat = $connection->query($query);
$rating_repeat = $rating_repeat->fetchAll();
$old_rating_repeat_user = $rating_repeat[0]['rating'];

if (count($rating_repeat) > 0)
{
    $query = "UPDATE ratings SET rating=$new_value WHERE user_id=$user_id AND post_id=$id";
    $release = $connection->query($query);
    (float)$new_rating = ((((float)$old_rating[0]['rating'] * $ratings_count) - $old_rating_repeat_user + $new_value) / $ratings_count);
}
else{
    $query = "INSERT INTO ratings (post_id, user_id, rating) VALUES ($id, $user_id, $new_value)";
    $release = $connection->query($query);
    (float)$new_rating = ((((float)$old_rating[0]['rating'] * $ratings_count) + $new_value) / ($ratings_count + 1));
    $ratings_count = $ratings_count + 1;
}

echo((float)$new_rating);
echo("\n" . $old_rating[0]['rating']);
echo("\n" . $ratings_count);
echo("\n" . $new_value);
echo("\n" . $ratings_count);
echo("\n" . $old_rating_repeat_user);

$query = "UPDATE posts SET rating=$new_rating, number_of_ratings=$ratings_count WHERE id=$id";
$release = $connection->query($query);

echo json_encode(['success' => true]);
