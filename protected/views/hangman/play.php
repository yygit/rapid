<?php
/* @var $this HangmanController */
/* @var $model Hangman */
/* @var $maskedTitle string */
/* @var $guessed string */
/* @var $dataArr array */

Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . "/css/hangman.css");

$this->breadcrumbs = array(
    'Hangman' => array('/hangman'),
    'Play',
);
?>
    <h1><?php echo $this->route; ?></h1>
<?php
if (!empty($error)) {
    echo '<div class="errormessage bold">ERROR: ' . $error . '</div>';
} else {
    if ($dataArr['lose'] || $dataArr['win']) {
        Yii::app()->clientScript->registerScript('gameover', "$('div.floatleft').click(function () {return false;});", CClientScript::POS_READY);
    } else {
        Yii::app()->clientScript->registerScript('guessfocus', "
            $('#guess_id').focus();
            $('#guess_id').keypress(function(event) {
                if ((event.ctrlKey == false) && (event.altKey == false) && (event.metaKey == false)) {
                    event.preventDefault();
                    $('#guess_id').val(String.fromCharCode(event.charCode));
                    $('#guess_form_id').submit();
                }
            });
        ", CClientScript::POS_READY);
        var_dump($dataArr);
    }
    ?>
    <div class="floatleft bold">
        <?php
        $titleclass = $dataArr['lose'] ? 'lose' : ($dataArr['win'] ? 'win' : 'neither');
        echo '<span class="' . $titleclass . '">' . $dataArr['maskedTitle'] . '</span><br /><br />' . $dataArr['guessed'] . '<br /><br />';
        ?>
        <!--form for submitting guesses -->
        <form name="guess_form" id="guess_form_id" method="get">
            <input type='hidden' name='token' value='<?php echo $dataArr['token']; ?>'>
            <label for="guess_id">Guess: </label><input type="text" name="guess" id="guess_id"/>
            <!--<input type="submit" value="Submit"/>-->
        </form>
        <br/>
        <?php
        $alphabetEN = 'abcdefghijklmnopqrstuvwxyz';
        foreach (preg_split('//', $alphabetEN, 0, PREG_SPLIT_NO_EMPTY) as $letter) {
            if (stristr($dataArr['guessed'], $letter) === FALSE) {
                echo CHtml::link(strtoupper($letter), array('', 'token' => $dataArr['token'], 'guess' => $letter)) . ' ';
            } else {
                echo strtoupper($letter) . ' ';
            }
        }
        ?>
        <br/>
        <?php
        $alphabetRU = 'абвгдеёжзийклмнопрстуфхцчшщэюяъь';
        foreach (preg_split('//u', $alphabetRU, 0, PREG_SPLIT_NO_EMPTY) as $letter) {
            if (mb_stristr($dataArr['guessed'], $letter, false, 'UTF-8') === FALSE) {
                echo CHtml::link(mb_strtoupper($letter, 'UTF-8'), array('', 'token' => $dataArr['token'], 'guess' => $letter)) . ' ';
            } else {
                echo mb_strtoupper($letter, 'UTF-8') . ' ';
            }
        }
        ?>
    </div>
    <?php
    $fails = !empty($dataArr['fails']) ? $dataArr['fails'] : 0;
    echo '<div class="floatleft"><img width=120 alt="hangman image" src="' . Yii::app()->request->baseUrl . '/images/hangman/hangman' . ($fails) . '.png" /></div>';
}
