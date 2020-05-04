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
	}
?>