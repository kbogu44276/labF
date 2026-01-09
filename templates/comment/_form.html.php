<?php
/** @var $comment ?\App\Model\Comment */
?>

<div class="form-group">
    <label for="author">Author</label>
    <input type="text" id="author" name="comment[author]" value="<?= $comment ? $comment->getAuthor() : '' ?>">
</div>

<div class="form-group">
    <label for="content">Content</label>
    <textarea id="content" name="comment[content]"><?= $comment? $comment->getContent() : '' ?></textarea>
</div>

<div class="form-group">
    <label></label>
    <input type="submit" value="Submit">
</div>
