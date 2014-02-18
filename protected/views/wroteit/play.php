<?php
/**
 * @var $this WroteitController
 * @var $game Game
 */
$this->breadcrumbs = array(
    'Wroteit' => array('/wroteit'),
    'Play',

);

if (isset($error)) {
    echo("<h1><center><u>WroteIt Error</u></center></h1><br />\n");
    echo("<h2>Error: $error</h2><br />\n");
} else { //no $error
    if (Yii::app()->user->checkAccess('admin')) {
        var_dump($game->book->title);
        var_dump($game->author->attributes);
    }
    ?>
    <h1>
        <center><u>Welcome to WroteIt</u></center>
    </h1><br/>
    <?php
    if ($win) {
        echo("<center><h1>You Win!!!</h1><br />\n");
        echo("<h2>$author wrote $answer.</h2></center><br />\n");
    } elseif ($lose) {
        echo("<center><h1>You Lose :(</h1><br />\n");
        echo("<h2>$author wrote $answer.</h2></center><br />\n");
    } else { //no win or lose
        echo("<center><h2>Author: $author</h2></center><br />");
        ?>
        <form name="guess_form" id="guess_form_id" method="get">
            <?php echo("<input name='token' type='hidden' value='$token'>\n"); ?>
            <center>
                What did this author write?
                <select name='guess'>
                    <option value="" style="display:none;"></option>
                    <?php
                    foreach ($choices as $choice) {
                        echo('<option value="' . $choice['id'] . '">');
                        echo($choice['title']);
                        echo("</option>\n");
                    }
                    ?>
                </select>
                <input type="submit" value="Submit">
            </center>
        </form>

    <?php
    } //no win or lose
} //no $error

//echo("<center><a href='" . Yii::app()->request->baseUrl . "/index.php/wroteit/create'>New Game</a><br />");
//echo("<a href='" . Yii::app()->request->baseUrl . "/index.php'>Back to CBDB</a><br /></center>");

?>
