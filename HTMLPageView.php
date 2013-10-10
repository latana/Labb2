<?php

namespace htmlpageview;

require_once("controller.php");

	class View{
		
		public $errorMessage;
		public $loginMessage;
		public $keepme;
		public $cookieMessage;
		/**
		 * 	@return html string
		 * 	@var errorMessage = String
		 *  @var outMessage = String
		 */
		
		
		public function firstPage(){
			
			$html = "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Strict//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd'>
	        <html xmlns='http://www.w3.org/1999/xhtml'> 
	          <head> 
	             <title>Laboration 1. Inte inloggad</title> 
	             <meta http-equiv='content-type' content='text/html; charset=utf-8' />
	          </head> 
	          <body>
	          ".$this->errorMessage."
	            <h1>Labration 2 ms223eq</h1><h2>Ej Inloggad</h2>
				<p id='loggout'> </p>";
				
			// Skriver ut meddelande om man loggar ut
			
			if(isset($_SESSION["outMessage"])){
				
				$html .= "<p>Du är utloggad</p>";
				unset($_SESSION["outMessage"]);
			}
			
			// Skriver ut resten av formuläret
			
			$html .= "
				<form action='?login' method='post' enctype='multipart/form-data'>
					<fieldset>
						<legend>Login - Skriv in användarnamn och lösenord</legend>
						<label for='userID' >Användarnamn :</label>
						<input type='text' size='20' name='".\controller\Controller::$userID."' id='userID' value= '". \controller\Controller::getUserID() ."'/>
						<label for='passID' >Lösenord  :</label>
						<input type='password' size='20' name='".\controller\Controller::$passID."' id='passID' value='' />
						<label for='autologinID' >Håll mig inloggad  :</label>
						<input type='checkbox' name='autologinID' id='autologinID' />
						<input type='submit' name=''  value='Logga in' />
					</fieldset>
				</form>
					 <p> ".strftime('%A, den %d %B år %Y. Klockan är: [%H:%M:%S] ')." </p>
	          </body>
	        </html>";
	        
	        return $html;
		}
		
		/**
		 * 	@return html string
		 * 	@loginMessage
		 * 	@keepme
		 */
		
		public function loginPage(){
				
			return "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Strict//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd'> 
		        <html xmlns='http://www.w3.org/1999/xhtml'> 
				<head> 
			    <title>Laboration. Inloggad</title> 
			    <meta http-equiv='content-type' content='text/html; charset=utf-8' />   
			    </head> 
			    <body>
			    ".$this->loginMessage. $this->keepme. $this->cookieMessage."
			    <h1>Laboration 2 ms223eq</h1>
				<h2>Admin är inloggad</h2>
				<p><a href='logout.php'>Logga ut</a></p>
				<p>" . strftime('%A, den %d %B år %Y. Klockan är: [%H:%M:%S] ') . " </p>
			    </body>
			    </html>";
		}
	}