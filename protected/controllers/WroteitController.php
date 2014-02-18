<?php

class WroteitController extends GameController{

    public $defaultAction = 'play';
    public $gameName = 'wroteit';
    protected $win = false;
    protected $lose = false;
    protected $choices = array();
    protected $answer = '';

    public function actionCreate() {
        $randbook = $this->selectRandomAuthorWithBook();
        $decoyIds = $this->selectThreeSuitableBooks($randbook['author_id']);
        $wroteIt = new Game;
        $this->generateToken($wroteIt);
        $wroteIt->game_type_id = GameType::getTypeId($this->gameName);
        $wroteIt->book_id = $randbook['book_id'];
        $wroteIt->author_id = $randbook['author_id'];
        $wroteIt->book_decoy1_id = $decoyIds[0];
        $wroteIt->book_decoy2_id = $decoyIds[1];
        $wroteIt->book_decoy3_id = $decoyIds[2];
        if ($wroteIt->save()) {
            $this->redirect(array('play', 'token' => $wroteIt->token));
        } else {
            $this->errorAndEnd(null, print_r($wroteIt->getErrors(), true));
        }
    }


    public function actionPlay() {
        $wroteIt = $this->evalTokenAndGetGame();
        $this->assessWin($wroteIt);

        if (!$this->win && !$this->lose) {
            $this->generateChoices($wroteIt);
        } else {
            $this->getAnswer($wroteIt);
        }

        $author = $wroteIt->author;

        $this->render('play', array(
            'choices' => $this->choices,
            'author' => $author['fname'] . ' ' . $author['lname'],
            'win' => $this->win,
            'lose' => $this->lose,
            'token' => $wroteIt->token,
            'answer' => $this->answer,
            'game' => $wroteIt,
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

    /**
     * assess the guess, generate $this->win and $this->lose
     * @param Game $wroteIt
     */
    private function assessWin(Game $wroteIt) {
        $guess = Yii::app()->request->getQuery('guess');
        if (!$wroteIt->win && !$wroteIt->fails && !empty($guess)) {
            if ($guess != $wroteIt->book_id) {
                $wroteIt->fails++;
            } else {
                $this->win = true;
                $wroteIt->win = 1;
            }
            if (!$wroteIt->save())
                $this->errorAndEnd(null, print_r($wroteIt->getErrors(), true));
        }
        if ($wroteIt->win) {
            $this->win = true;
        } elseif ($wroteIt->fails) {
            $this->lose = true;
        } else {
            // neither win or lose
        }
    }

    /**
     * generate $this->choices
     * @param $wroteIt Game
     */
    private function generateChoices($wroteIt) {
        $books = array(
            $wroteIt->book,
            $wroteIt->bookDecoy1,
            $wroteIt->bookDecoy2,
            $wroteIt->bookDecoy3,
        );
        shuffle($books);
        /** @var $book Book */
        foreach ($books as $book) {
            $this->choices[] = array('id' => $book->id, 'title' => $book->title);
        }
    }

    /**
     * generate $this->answer
     * @param $wroteIt Game
     * @throws CDbException
     */
    private function getAnswer($wroteIt) {
        $bookAnswer = $wroteIt->book;
        if (empty($bookAnswer))
            throw new CDbException('no answer found');
        $this->answer = $bookAnswer->title;
    }
}
