<?php
	class User {
	    private $name;
	    private $email = '';
	   	private $profession = '';
	    private $gender = '';
	    private $questionListID = 0;
	    private $age = 0;
	    private $password = '';
	   	private $language = '';
	    private $akey = '';

    	function __construct($name = '', $email = '', $profession = '') {
    		$this->name = $name;
    		$this->email = $email;
    		$this->profession = $profession;
    	}

 		public function setName($name) {
 			$this->name = $name;
 		}
 		public function setEmail($email) {
 			$this->email = $email;
 		}
 		public function setProfession($profession) {
 			$this->profession = $profession;
 		}
 		public function setGender($gender) {
 			$this->gender = $gender;
 		}
 		public function setQuestionlistID($questionListID) {
 			$this->questionListID = $questionListID;
 		}
 		public function setAge($age) {
 			$this->age = $age;
 		}
 		public function setPassword($password) {
 			$this->password = $password;
 		}
 		public function setLanguage($language) {
 			$this->language = $language;
 		}

	    public function getName() {
	        return $this->name;
	    }
	    public function getEmail() {
	        return $this->email;
	    }
	    public function getProfession() {
	        return $this->profession;
	    }
	    public function getGender() {
	        return $this->gender;
	    }
	    public function getQuestionlistID() {
	    	return $this->questionListID;
	    }
	    public function getAge() {
	        return $this->age;
	    }
	    public function getPassword() {
	        return $this->password;
	    }
	    public function getLanguage() {
	        return $this->language;
	    }
	    public function getAKey() {
	        return $this->akey;
	    }
	}
?>