<?php

/** @var \App\Model\Comment[] $comments */
/** @var \App\Service\Router $router */

$title = 'Comment List';
$bodyClass = 'index';

ob_start(); ?>
    <h1>Comment</h1>

    <a href="<?= $router->generatePath('comment-create') ?>">Create new comment</a>

    <ul class="index-list">
        <?php foreach ($comments as $comment): ?>
            <li>
                <h3><?= $comment->getAuthor() ?></h3>
                <ul class="action-list">
                    <li><a href="<?= $router->generatePath('comment-show', ['id' => $comment->getId()]) ?>">Details</a></li>
                    <li><a href="<?= $router->generatePath('comment-edit', ['id' => $comment->getId()]) ?>">Edit</a></li>
                    <li> <a href="<?= $router->generatePath('comment-delete', ['commentId' => $comment->getId()]) ?>"</li>
                </ul>
            </li>
        <?php endforeach; ?>
    </ul>

<?php $main = ob_get_clean();

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';
