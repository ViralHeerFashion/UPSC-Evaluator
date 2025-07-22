


///validate login details
function validateForm() {
    var username = document.getElementById("username").value.trim();
    var password = document.getElementById("password").value.trim();

    if (username.length === 0) {
        alert("Username cannot be blank.");
        return false;
    }
    
        if (password.length === 0) {
        alert("Password cannot be blank.");
        return false;
    }

    // Other validation logic or form submission can go here

    return true; // Form submission can proceed
}    

///validate forgot password email form
function validateForm2() {
    var email = document.getElementById("email").value.trim();
    if (email.length === 0) {
        alert("Email cannot be blank.");
        return false;
    }
    
    // Other validation logic or form submission can go here
    return true; // Form submission can proceed
    
}    

  

////hide and show login form
document.getElementById('loginLink').addEventListener('click', function(event) {
    event.preventDefault(); // Prevent the default link behavior
    document.getElementById('loginForm').style.display = 'block'; // Show the login form

passwordForm.style.display = "none";
regForm.style.display = "none";
  
});

///hide and show forgot password form
document.getElementById('passwordLink').addEventListener('click', function(event) {
    event.preventDefault(); // Prevent the default link behavior
    document.getElementById('passwordForm').style.display = 'block'; // Show the email form
    loginForm.style.display = "none";
    regForm.style.display = "none";
    
});

///hide and show reg form
document.getElementById('regLink').addEventListener('click', function(event) {
    event.preventDefault(); // Prevent the default link behavior
    document.getElementById('regForm').style.display = 'block'; // Show the reg form
    loginForm.style.display = "none";
    passwordForm.style.display = "none";
});

//clear session text
  document.addEventListener('click', function(event) {
    var container = document.getElementById('sessionForm');
    var targetElement = event.target;

    // Check if the clicked element is outside the container
    if (!container.contains(targetElement)) {
      // Clear the content of the container
      container.innerHTML = '';
    }
  });

       document.addEventListener("DOMContentLoaded", function() {
      // Step 1: Add event listener to the hyperlink
      document.getElementById("hideLink1").addEventListener("click", function(event) {
        // Step 2: Prevent default behavior of the hyperlink
        event.preventDefault();
        
        // Step 3: Select the element you want to hide
        var elementToHide = document.getElementById("loginForm");
        var elementToHide2 = document.getElementById("passwordForm");
        // Step 4: Hide the element
        elementToHide.style.display = "none";
        elementToHide2.style.display = "none";
         
      });
    });
    
           document.addEventListener("DOMContentLoaded", function() {
      // Step 1: Add event listener to the hyperlink
      document.getElementById("hideLink2").addEventListener("click", function(event) {
        // Step 2: Prevent default behavior of the hyperlink
        event.preventDefault();
        
        // Step 3: Select the element you want to hide
        var elementToHide = document.getElementById("loginForm");
        var elementToHide2 = document.getElementById("passwordForm");
        
        // Step 4: Hide the element
        elementToHide.style.display = "none";
        elementToHide2.style.display = "none";
         
      });
    });
    
             document.addEventListener("DOMContentLoaded", function() {
      // Step 1: Add event listener to the hyperlink
      document.getElementById("hideLink3").addEventListener("click", function(event) {
        // Step 2: Prevent default behavior of the hyperlink
        event.preventDefault();
        
        // Step 3: Select the element you want to hide
        var elementToHide = document.getElementById("loginForm");
        var elementToHide2 = document.getElementById("passwordForm");
        
        // Step 4: Hide the element
        elementToHide.style.display = "none";
        elementToHide2.style.display = "none";
         
      });
    });
    
                 document.addEventListener("DOMContentLoaded", function() {
      // Step 1: Add event listener to the hyperlink
      document.getElementById("hideLink4").addEventListener("click", function(event) {
        // Step 2: Prevent default behavior of the hyperlink
        event.preventDefault();
        
        // Step 3: Select the element you want to hide
        var elementToHide = document.getElementById("loginForm");
        var elementToHide2 = document.getElementById("passwordForm");
        
        // Step 4: Hide the element
        elementToHide.style.display = "none";
        elementToHide2.style.display = "none";
         
      });
    });
    
                     document.addEventListener("DOMContentLoaded", function() {
      // Step 1: Add event listener to the hyperlink
      document.getElementById("hideLink5").addEventListener("click", function(event) {
        // Step 2: Prevent default behavior of the hyperlink
        event.preventDefault();
        
        // Step 3: Select the element you want to hide
        var elementToHide = document.getElementById("loginForm");
        var elementToHide2 = document.getElementById("passwordForm");
        
        // Step 4: Hide the element
        elementToHide.style.display = "none";
        elementToHide2.style.display = "none";
         
      });
    });
