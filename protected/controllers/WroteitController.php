<?php

class WroteitController extends GameController{

    public $gameName = 'wroteit';

    public function actionCreate() {
        $randbook = $this->selectRandomAuthorWithBook();
        $decoyIds = $this->selectThreeSuitableBooks($randbook['author_id']);
//        $gameType = Gametype::model()->find('devname="wrote_it"');
        $wroteIt = new Game;
        $wroteIt->token = $this->gameToken();
//        $wroteIt->game_type_id = $gameType['id'];
        $wroteIt->game_type_id = GameType::getTypeId($this->gameName);
        $wroteIt->book_id = $randbook['book_id'];
        $wroteIt->author_id = $randbook['author_id'];
        $wroteIt->book_decoy1_id = $decoyIds[0];
        $wroteIt->book_decoy2_id = $decoyIds[1];
        $wroteIt->book_decoy3_id = $decoyIds[2];
//        $wroteIt->save();
        if ($wroteIt->save()) {
            $this->redirect(array('play', 'token' => $wroteIt->token));
        } else {
            $this->errorAndEnd(null, print_r($wroteIt->getErrors(), true));
        }
//        $request = Yii::app()->request;
//        $this->redirect($request->hostInfo . $request->baseUrl . '/index.php/wroteit/play?token=' . $wroteIt->token);
    }

    public function actionIndex() {
        $AuthorWithBook = $this->selectRandomAuthorWithBook();
        $otherBooks = $this->selectThreeSuitableBooks($AuthorWithBook['author_id']);
        var_dump($AuthorWithBook);
        var_dump($otherBooks);
        Yii::app()->end();
        $this->render('index');
    }

    public function actionPlay() {
        $wroteIt = $this->evalTokenAndGetGame('wrote_it');

        $win = false;
        if (!$wroteIt->win && $wroteIt->fails == 0 && isset($_GET['guess'])) {
            $guess = $_GET['guess'];
            if (strlen($guess) != 0) {
                if ($guess != $wroteIt->book_id) {
                    $wroteIt->fails++;
                } else {
                    $win = true;
                    $wroteIt->win = 1;
                }
                if (!$wroteIt->save())
                    $this->errorAndEnd(null, print_r($wroteIt->getErrors(), true));
            }
        } elseif ($wroteIt->win) {
            $win = true;
        }

        $ids = array(
            $wroteIt->book_id, $wroteIt->book_decoy1_id,
            $wroteIt->book_decoy2_id, $wroteIt->book_decoy3_id,
        );
        $criteria = new CDbCriteria;
        $criteria->addInCondition('id', $ids);
        $choices = array();
        $author = Person::model()->find('id=:id', array('id' => $wroteIt->author_id));
        $books = Book::model()->findAll($criteria);
        shuffle($books);
        foreach ($books as $book) {
            $choices[] = array('id' => $book->id, 'title' => $book->title);
        }
        $answer = '';
        $lose = false;
        if ($wroteIt->fails > 0) {
            $lose = true;
        }
        if ($win || $lose) {
            $bookAnswer = Book::model()->find('id=:id', array('id' => $wroteIt->book_id));
            $answer = $bookAnswer->title;
        }
        $this->render('play', array(
            'choices' => $choices,
            'author' => $author['fname'] . ' ' . $author['lname'],
            'win' => $win,
            'lose' => $lose,
            'token' => $wroteIt->token,
            'answer' => $answer,
        ));
    }

    /**
     * select a random author and one book that he is an author to
     * @param $action string error action
     * @return array
     */
    private function selectRandomAuthorWithBook($action = null) {
        $bookauthors = BookAuthor::model()->findAll(array(
            'select' => 'author_id',
            'group' => 'author_id',
            'distinct' => true,
        ));
        $authorIds = array();
        foreach ($bookauthors as $bookauthor) {
            $authorIds[] = $bookauthor['author_id'];
        }
        if (count($authorIds) == 0) {
            $this->errorAndEnd($action, 'No authors in database.');
        }
        $author = Person::model()->find('id=:id', array('id' => $authorIds[mt_rand(0, count($authorIds) - 1)]));
        $bookIds = array();
        foreach ($author->books as $book) {
            $bookIds[] = $book['id'];
        }
        if (count($bookIds) == 0) {
            $this->errorAndEnd($action, 'Relational integrity error. You should not see this.');
        }
        return array(
            'author_id' => $author['id'],
            'book_id' => $bookIds[mt_rand(0, count($bookIds) - 1)],
        );
    }

    /**
     * Return three books that are not written by the author referenced by author_id
     * @param $author_id
     * @param $action
     * @return array
     */
    private function selectThreeSuitableBooks($author_id, $action = null) {
//        $author = Person::model()->find('id=:id', array('id' => $author_id));
        $author = Person::model()->findByAttributes(array('id' => $author_id));
        $bookIdsByAuthor = array();
        foreach ($author->books as $book) {
            $bookIdsByAuthor[] = $book['id'];
        }
        $criteria = new CDbCriteria;
        $criteria->addNotInCondition('id', $bookIdsByAuthor);
        $ret = array();

        $books = Book::model()->findAll($criteria);
        $bookIds = array();
        foreach ($books as $book) {
            $bookIds[] = $book['id'];
        }
        if (count($bookIds) < 3) {
            $this->errorAndEnd($action, 'Not enough books not written by author in database.');
        } elseif (count($bookIds) == 3) {
            return $bookIds;
        } else {
            for ($count = 0; $count < 3; $count++) {
                $index = mt_rand(0, count($bookIds) - 1);
                $ret[] = $bookIds[$index];
                unset($bookIds[$index]);
                $bookIds = array_merge($bookIds);
            }
        }
        return $ret;
    }
}
