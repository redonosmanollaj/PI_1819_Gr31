<!DOCTYPE html>
<html manifest="manifest.appcache">
<head>
	<title>Miami University</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
</head>
<body >

	<div id="header">
		<div style="width: 100%;">
		<div style="width: 50%;float: left; margin-top: 10px; "><a class="logo" style="color:rgb(227, 227, 227);text-decoration: none;" href="index.html";>Miami University</a></div>
			<div style="width: 50%; float: right;">
				<div><a class="hyperlink" href="Company.html" href="javascript:void(0)|">COMPANY</a></div>
				<div><a class="hyperlink" href="services.html" href="javascript:void(0)">SERVICES</a></div>
				<div><a class="hyperlink" href="Contact.html" href="javascript:void(0)">CONTACT</a></div>
				<div><a class="hyperlink" href="Gallery.html" href="javascript:void(0)">GALLERY</a></div>
			</div>
		</div>	
	</div>

		
		
	<div id="pjesa2">
		<div class="school">Public Institution, Personal Education.</div>
		<div style="float: right;margin-right: 10px;margin-top: -75px;">
		<table>
			<tr>
				<td><a><img src="images/a2.png"></a></td>
				<td><a><img src="images/images.jpeg"></a></td>
				<td><a><img src="images/images.jpg"></a></td>
				<td><a><img src="images/a.jpeg"></a></td>
			</tr>
			<tr>
				<td><a><img src="images/b.jpeg"></a></td>
				<td><a><img src="images/c3.jpg"></a></td>
				<td><a><img src="images/a1.jpeg"></a></td>
				<td><a><img src="images/download.png"></a></td>
			</tr>
		</table>
	
		</div>
		<div style="width:35%; margin-top:25px; font-size:15px;margin-left:20px;color: rgb(193, 193, 193);font-family: arial;">
		Many consider Miami's campus one of the most beautiful in America. 
		While you're here, you can attend an information session, take a campus tour, 
		and check out uptown Oxford that is a pleasant walk with campus and home to boutiques,
		 coffeehouses, and unique restaurants.		
		</div>
	</div>

	<div id="pjesa3">
		<div id="tabelat">
			<span class="tabela1">
				<img src="images/1.jpg" style="width: 260px; height: 125px;margin-top: -2%;"> 
			</span>			

			<span class="tabela2">
				<img src="images/2.jpg" style="width: 260px; height: 125px;margin-top: -2%;">
			</span>

			<span class="tabela3">
				<img src="images/3.jpg" style="width: 260px; height: 125px;margin-top: -130px;float: right;margin-right: 20px;">
			</span>			
		</div>
		<div id="permbajtja">
			<div class="teksti" style="margin-top: -215px; margin-left: 24px;">
				<h3 style="">Faculty and Staff </h3>
				<hr style="width:100%;float: left; margin-top: -4px;">
				<ul style="margin-top: 10px;">
					<li class="listat">Bruce Drushel</li>
					<li class="listat">Howard Kleiman</li>
					<li class="listat">Ron Becker</li>
					<li class="listat">Kerry Heqarty</li>
					<li class="listat">Bill Brewer</li>
					<li class="listat">Patricia gallagher newberry</li>
				</ul>
			</div>
			<div class="teksti" style="margin-top: -215px; margin-left: 17%;">
				<h3 style="">Department of Media</h3>
				<hr style="width:100%;float: left; margin-top: -4px;">
				<pre class="listat" style="margin-left: -330px;">
					
					We are united behind the goal of 
					helping	students become
					media-literate and critically
					engaged citizen-producers.
					We integrate the analysis of media's
					role in our social world and the 
					creation of
					high-quality media content.
					</pre>
			</div>
			<div class="teksti" style="margin-top: -215px; margin-left: 25%;">
				<h3 style="margin-left: -32%">King Library</h3>
				<hr style="width:100%;float: left; margin-top: -4px;margin-left: -32%;">
				<pre class="listat" style="margin-right: 40%;float: right; margin-top: 0px; font-size: 14px;">
					King Library was originally 
					knownas the King
					Undergraduate Library 
					when the south section was
					completed in 1966. When
					the north section was
					completed in 1972, the word 
					"undergraduate" was dropped
					from its name.
					Before King Library was built.
				</pre>
			</div>
		</div>
	</div>
				
	<div id="pjesa4">
		<br>
		<div style="float: left;width: 27%">		
			<h2 class="fund">Why Not Contact Us Today !</h2>
			<hr style="width:95%; float: left; margin-top: -4px; margin-left: 10px;">

			<br>
			<div class="fund" style="float: left;margin-left: 10px;margin-top: 15px;">Name:</div>
			<div class="fund" style="float: left;margin-left: 150px;margin-top: 15px;">Email:</div>
			<br>
			<br>
			<br>
			<form id="myFrom">
				<input class="fund" type="text" name="emri"  placeholder="Write your name" autocomplete="off">
				<input class="fund" type="text" name="email" id="email"  placeholder="Write your email" autocomplete="off">
				<br>
				<div class="fund" style="margin-left: 10px;">
					Message:
				<br>
				<textarea style="width: 98%; height: 100px;"  placeholder="What's on your mind?" autocomplete="off"></textarea>
				<button type="submit" value="submit" id="validate" onclick="validate()">Submit</button>
				<button type="reset" value="reset" style="margin-left: 10px;" onclick="clickCounter()">Reset</button>
			</form>
				<p id="result"></p>
				<p id="erorr_message"></p>
			</div>
			
		</div>
		<div style="width: 22%;float: left;margin-left: 70px;">
			<h2 class="fund">You can do it</h2>
			<hr style="width:70%;float: left;margin-top: -4px;margin-left: 10px;">	
			<br>
			<div class="fund1">
		       Do you need some help when it 
				comes to studying?
				Perhaps you have used the 
				law of Attraction
				to help you visualize what you want to 
				achieve,
				you just need some 
				help with actually
				getting motivated?
			</div>
		</div>
		<div style="width: 22%;float: left;margin-left: -10px;">
			<h2 class="fund">You can take it</h2>		
			<hr style="width:70%;float: left;margin-top: -4px;margin-left: 10px;">	
			<br>
			<div class="fund1">
			 Don’t let what you cannot do 
			interfere with what you can do.
			Successful and unsuccessful people 
			do not 
			vary greatly in their abilities.
			They vary in their desires 
			to reach their potential.

			</div>	
		</div>
		<div style="width: 22%;float: left;margin-left: -10px;">
			<h2 class="fund">You can win it </h2>		
			<hr style="width:70%;float: left;margin-top: -4px;margin-left: 10px;">	
			<br>
			<div class="fund1" >
				Strive 
				for progress, not perfection.” 
				“Failure is the opportunxity to begin again more intelligently.
				“Our greatest weakness lies in giving up. The most certain way to succeed 
				is always to try just one more time. 

			</div>	
		</div>
		<div style="width: 65%; height: 15%; float: left; margin-right: 15px; padding-left: 80px; padding-top: 10px;">
			<label class="fund">Enter your Email to join our mailing list >>
			</label>
			<input type="text" name="Email" id="email_join" style="width: 400px; height: 21px; margin-left: 10px;">
			<button style="width: 40px; height: 27px; margin-left:10px;" onclick="setSession()" id="setSession">GO</button>
			<p id="message_error"></p>
		</div>
	</div>
	<footer>
			<div style="float: left;margin-left: 20px;margin-top: 15px;">				
				Copyright &#169; 2019 Domain Name - All rights Reserved
			</div>
			<div style="float: right; margin-right: 20px; margin-top: 15px;">
					Template by OS Templates
			</div>			
		</footer>
	<script>
		if (typeof(Storage) !== "undefined") {
		  document.getElementById("email_join").value = localStorage.getItem("emailJoin");
		} else {
		  document.getElementById("email_join").value = "Sorry, your browser does not support Web Storage...";
		}
		function validateEmail(email_join) {
		  var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		  return re.test(email_join);
		}

		function setSession() {
			var $result = $("#message_error");
			var email_join = $("#email_join").val();
			$result.text("");

			if (validateEmail(email_join)) {
			   try {
				localStorage.setItem("emailJoin", document.getElementById("email_join").value);
				alert("Thank you for join us");
				}
				catch(error){
					document.getElementById("message_error").innerHTML = error.message;
				}
			} else {
			   $result.text(email_join + " is not valid");
			   $result.css("color", "red");
			}
			return false;
		}

      function validateEmail(email) {
        var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
      }

      function clickCounter() {
		  if (typeof(Storage) !== "undefined") {
		    if (sessionStorage.clickcount) {
		      sessionStorage.clickcount = Number(sessionStorage.clickcount)+1;
		      document.getElementById("myForm").reset();
		    } else {
		      sessionStorage.clickcount = 1;
		    }
		    document.getElementById("result").innerHTML = "Keni klikuar " + sessionStorage.clickcount + " here butonin reset.";
		  } else {
		    document.getElementById("result").innerHTML = "Sorry, your browser does not support web storage...";
		  }
		}

      function validate() {
        var $result = $("#result");
        var email = $("#email").val();
        $result.text("");

        if (validateEmail(email)) {
        	alert("Thank you for texting us, we will answer soon!")
        } else {
          $result.text(email + " is not valid");
          $result.css("color", "red");
        }
        return false;
      }

      $("#validate").bind("click", validate);
        window.onscroll = function() {myFunction()};
        
        var navbar = document.getElementById("header");
        var sticky = navbar.offsetTop;
        
        function myFunction() {
          if (window.pageYOffset >= sticky) {
            navbar.classList.add("sticky")
          } else {
            navbar.classList.remove("sticky");
          }
        }
        </script>
</body>
</html>