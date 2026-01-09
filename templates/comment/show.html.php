<?php

/** @var \App\Model\Comment $comment */
/** @var \App\Service\Router $router */

$title = "{$comment->getAuthor()} ({$comment->getId()})";
$bodyClass = 'show';

ob_start(); ?>
    <h1><?= $comment->getAuthor() ?></h1>
    <article>
        <?= $comment->getContent(); ?>
    </article>

    <ul class="action-list">
        <li><a href="<?= $router->generatePath('comment-index') ?>">Back to list</a></li>
        <li><a href="<?= $router->generatePath('comment-edit', ['id' => $comment->getId()]) ?>">Edit</a></li>
    </ul>

<?php $main = ob_get_clean();

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';
