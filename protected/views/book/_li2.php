<?php
/**
 * @var $this BookController
 * @var $author Person
 * @var $authors array
 */
?>

<ul data-role="listview" data-theme="g">
<!--<ul>-->
    <?php
    if (count($authors)) {
        foreach ($authors as $author) {
            // echo '<li>' . $author->fname . " " . $author->lname . '</li>';
            echo '<li><a data-ajax="false" href="' . $this->createUrl('person/view', array('id' => $author->id)) . '">'.$author->fname . ' ' . $author->lname.'</a></li>';
        }
    }
    ?>
</ul>
