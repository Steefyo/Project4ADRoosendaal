<?php
	class Question {
		private $id;
	    private $textNL;
	    private $textEN;
	    private $category;

	    public function setID($id) {
 			$this->id = $id;
 		}
 		public function setTextNL($textNL) {
 			$this->textNL = $textNL;
 		}
 		public function setTextEN($textEN) {
 			$this->textEN = $textEN;
 		}
 		public function setCategory($category) {
 			$this->category = $category;
 		}

 		public function getID() {
 			return $this->id;
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