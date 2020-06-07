<?php
	class Answers {
		// User ID needs to be set after the "normal" user has been created. After the user has been created the ID needs to be set in the Anser model

	    private $questionListID = 0;
	    private $answers;

 		public function setQuestionListID($QLID) {
 			$this->questionListID = $QLID;
 		}
 		public function setAnswers($json) {
 			if (is_array($json)) {
				$this->answers = json_encode($json);
 			} else {
 				$this->answers = $json;
 			}
 		}

 		public function getQuestionListID() {
	        return $this->questionListID;
	    }
 		public function getAnswer($answersNumber) {
	    	$answers = json_decode($this->answers);
	    	if (array_key_exists($answersNumber, $answers)) {
	    		return $answers[$answersNumber];
	    	} else {
	    		return 0;
	    	}
	    }
	    public function getAnswerToTextNL($answersNumber) {
	    	$answers = json_decode($this->answers);
	    	if (array_key_exists($answersNumber, $answers)) {
	    		if ($answers[$answersNumber] == 1) {
	    			return "Helemaal niet mee eens";
	    		} else if ($answers[$answersNumber] == 2) {
	    			return "Enigszins niet mee eens";
	    		} else if ($answers[$answersNumber] == 3) {
	    			return "Neutraal";
	    		} else if ($answers[$answersNumber] == 4) {
	    			return "Enigszins mee eens";
	    		} else if ($answers[$answersNumber] == 5) {
	    			return "Helemaal mee eens";
	    		}
	    	} else {
	    		return "";
	    	}
	    }
	    public function getAnswerToTextEN($answersNumber) {
	    	$answers = json_decode($this->answers);
	    	if (array_key_exists($answersNumber, $answers)) {
	    		if ($answers[$answersNumber] == 1) {
	    			return "Strongly disagree";
	    		} else if ($answers[$answersNumber] == 2) {
	    			return "Somewhat disagree";
	    		} else if ($answers[$answersNumber] == 3) {
	    			return "Neutral";
	    		} else if ($answers[$answersNumber] == 4) {
	    			return "Somewhat agree";
	    		} else if ($answers[$answersNumber] == 5) {
	    			return "Strongly agree";
	    		}
	    	} else {
	    		return "";
	    	}
	    }
	    public function getAnswers() {
	        return json_decode($this->answers);
	    }
	}
?>