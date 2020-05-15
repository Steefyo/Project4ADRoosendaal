<?php
	class Questionlist {
	    private $questionlist;

 		public function setQuestionlist($json) {
 			$this->questionlist = $json;
 		}

 		public function getQuestion($questionNumber) {
	    	$questionlist = $this->questionlist;
	    	return $questionlist[$questionNumber];
	    }
	    public function getQuestionlist() {
	        return $this->questionlist;
	    }

	    public function getQuestionCategory($category) {
	    	$newList = array();
	    	foreach ($this->questionlist as $question) {
				if ($question->getCategory() == $category) {
					array_push($newList, $question);
				}
			}
			return $newList;
	    }
	    public function getCountEachCategory($category) {
			$count = 0;
			foreach ($this->questionlist as $question) {
				if ($question->getCategory() == $category) {
					$count++;
				}
			}
			return $count;
		}
	}
?>