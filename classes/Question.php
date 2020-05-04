<?php
	class Question {
	    private $textNL;
	    private $textEN;
	    private $category;

 		public function setTextNL($textNL) {
 			$this->textNL = $textNL;
 		}
 		public function setTextEN($textEN) {
 			$this->textEN = $textEN;
 		}
 		public function setCategory($category) {
 			$this->category = $category;
 		}

 		public function getTextNL() {
 			return $this->textNL;
 		}
 		public function getTextEN() {
 			return $this->textEN;
 		}
 		public function getCategory() {
 			return $this->category;
 		}
	}
?>