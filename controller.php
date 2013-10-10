<?php

namespace controller;

require_once 'HTMLPageView.php';

	class Controller{
		
		/**
		 * @var string
		 */
		private $userName;
		
		/**
		 * @var string
		 */
		private $passWord;
		
		/**
		 * @var string
		 */
		private $user;
		
		/**
		 * @var string
		 */
		
		private $pass;
		
		/**
		 * @var string
		 */
		public static $userID ="userID";
		
		/**
		 * @var string
		 */
		public static $passID ="passID";
		
		/**
		 * @var string
		 */
		public $cookieUser = "cookieUser";
		
		/**
		 * @var string
		 */
		public $cookiePass = "cookiePass";
		
		/**
		 * @var string
		 */
		public $safeKey = "safeKey";
		
		/**
		 * @var string
		 */
		public $errorMessage;
		
		/**
		 * @var string
		 */
		public $outMessage;
		
		/**
		 * @var string
		 */
		public $loginMessage;
		
		/**
		 * @var string
		 */
		public $keepme;
		
		private $htmlPageView;
				
		/**
		 * @var string
		 */
		
		public function __construct() {

			$this -> userName = "Admin";
			$this -> passWord = "Password";
			$this -> user = null;
			$this -> pass = null;
			$this -> errorMessage = null;
			$this -> outMessage = null;
			$this -> loginMessage = null;
			$this -> keepme = null;
			$this->htmlPageView = new \htmlpageview\View();
		}
		
		/** Skickar userID till användarnamnsfältet i klassen firstPage i HTMLPageView 
		 * @return $userID
		 * **/
		
		public static function getUserID(){
		
			if(isset($_POST[self::$userID])){
			
				return $_POST[self::$userID];
			}
		}
		
		/** Skickar passID till användarnamnsfältet i klassen firstPage i HTMLPageView
		 * @return $passID
		 * **/
		
		public static function getPassID(){
		
			if(isset($_POST[self::$passID])){
			
				return $_POST[self::$passID];
			}
		}
		// Förbereder för inloggning
		private function loginsuccess(){

			$_SESSION['mySess'] = true;
			
			$this->loginMessage;

		}
		
		/**
		 * errorMassage
		 * Sätter felmeddelanden 
		 */
		public function errorMessages(){
					
			if($this->user == null){
				
				$this->htmlPageView->errorMessage = "<p>Användarnamn saknas</p>";
			}
			else if($this->pass == null){
					
				$this->htmlPageView->errorMessage = "<p>Lösenord saknas</p>";
			}
			else if($this->user != $this->userName || $this->pass != $this->passWord){
				$this->htmlPageView->errorMessage = "<p>Användarnamn eller Lösenord är felaktig</p>";
			}
		}
		// Kontrollerar inloggning
		private function checkMyLogin(){
			

			
			if(isset($_SESSION['mySess'])){
			
				if(isset($_POST["autologinID"])){
					
					$this->htmlPageView->keepme = "<p>Dina uppgifter är sparade</p>";
					$this->MakeCookie();
				}
				echo $this->htmlPageView->loginPage();
			}
			else{
				
				echo $this->htmlPageView->firstPage();
			}
		}
		
		private function MakeCookie(){
			
			$cookieTime = time() + 25;
			$mySite = "latana.se";
			
			file_put_contents("cookieTime.txt", "$cookieTime");
			
	 		setcookie($this->cookieUser, $this->userName, $cookieTime);
			$cryptPass = md5($this->passWord, $this->safeKey);
		
			$value = setcookie($this->cookiePass, $cryptPass, $cookieTime);
			
	 	}
		// Kollar av kakorna
		private function checkMyCookies(){
						
			if(isset($_COOKIE[$this->cookieUser])){
			
				$timeFile = file_get_contents("cookieTime.txt");
				// Kollar ifall kakan stämmer
					if(!isset($_SESSION["mySess"]) &&  $timeFile > time() &&
					$_COOKIE[$this->cookieUser] == $this->userName && 
					$_COOKIE[$this->cookiePass] == md5($this->passWord,
					$this->safeKey)){
			
					$this->htmlPageView->cookieMessage = "<p>Du blev inloggad med cookie</p>";
					$this->loginsuccess();
				}
				// Kollar ifall kakan är fel
				if(!isset($_SESSION["mySess"]) &&
				(isset($_COOKIE[$this->cookieUser]) !== $this->userName)
				|| $_COOKIE[$this->cookiePass] !== md5($this->passWord, $this->safeKey
				|| $timeFile < time())){
					
					$this->htmlPageView->cookieMessage = "Felaktiga uppgifter i cookie";
					setcookie("cookieUser", "", time()-9999999);
					setcookie("cookiePass", "", time()-9999999);
				}
			}
		}
		// Testar det användaren matat in
		public function myLogin(){
			
			$this->checkMyCookies();
			
			if($_POST){
				
			$this->user = $_POST[self::$userID];
			$this->pass = $_POST[self::$passID];
			$this->errorMessages();
			
				// Om uppgifterna stämmer
				if($this->user == $this->userName && $this->pass == $this->passWord){
						
					$this->htmlPageView->loginMessage = "<p>inloggning lyckades</p>";
					$this->loginsuccess();
				}
			}
			$this->checkMyLogin();
		}
	}
