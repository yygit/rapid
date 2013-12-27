<?php
/**
 * @var $this ListView
 * @var $owner CWidget|CController
 */
?>

<!--<ul data-role="listview" data-theme="g">-->
<ul data-role="listview" data-theme="g" data-filter="true">
    <?php
    $data = $this->dataProvider->getData();
    $owner = $this->getOwner();
    foreach ($data as $i => $item) {
        echo "<li>";
        $owner->renderPartial($this->itemView, $item);
        echo "</li>";
    }
    ?>
</ul>

