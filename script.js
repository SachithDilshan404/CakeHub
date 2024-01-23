function changeView() {
  var registerbox = document.getElementById("registerbox");
  var loginbox = document.getElementById("loginbox");

  registerbox.classList.toggle("d-none");
  loginbox.classList.toggle("d-none");
}
function showLogin() {
  var reset = document.getElementById("reset");
  var loginbox = document.getElementById("loginbox");

  reset.classList.toggle("d-none");
  loginbox.classList.toggle("d-none");

  var email = document.getElementById("email1");

  var f = new XMLHttpRequest();
  f.onreadystatechange = function () {
    if (f.readyState == 4 && f.status == 200) {
      var response = f.responseText;

      if (response === "Invalid Email address") {
        // User is not registered, hide the Reset Password form
        reset.classList.add("d-none");
        loginbox.classList.remove("d-none");
        // Optionally, you can display an error message to the user
        var fail = document.getElementById("fail");
        fail.classList.add("active");

        setTimeout(function () {
          fail.classList.remove("active");
        }, 1000);
      } else if (response === "Verification code sent") {
        // User is registered, show the Reset Password form
        reset.classList.remove("d-none");
        loginbox.classList.add("d-none");
        // Optionally, you can provide a success message to the user
        var pass = document.getElementById("pass");
        pass.classList.add("active");

        setTimeout(function () {
          pass.classList.remove("active");
        }, 1000);
      } else {
        // Handle other responses or errors as needed
        alert("An error occurred.");
      }
    }
  };

  f.open("GET", "resetpassword.php?e=" + email.value, true);
  f.send();
}

function register() {
  var registerbox = document.getElementById("registerbox");
  var loginbox = document.getElementById("loginbox");
  var fn = document.getElementById("fname");
  var ln = document.getElementById("lname");
  var e = document.getElementById("email");
  var pw = document.getElementById("password");

  var f = new FormData();
  f.append("fname", fn.value);
  f.append("lname", ln.value);
  f.append("email", e.value);
  f.append("password", pw.value);

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var t = r.responseText;

      if (t === "OKSuccess") {
        // Clear input fields
        fn.value = "";
        ln.value = "";
        e.value = "";
        pw.value = "";
        // Display the toast notification
        var pass = document.getElementById("pass");
        pass.classList.add("active");

        setTimeout(function () {
          pass.classList.remove("active");
          registerbox.classList.toggle("d-none");
          loginbox.classList.toggle("d-none");
        }, 5000);
      } else {
        var fail = document.getElementById("fail");
        fail.classList.add("active");

        setTimeout(function () {
          fail.classList.remove("active");
        }, 5000);
      }
    }
  };

  r.open("POST", "register.php", true);
  r.send(f);
}

const check = document.querySelector(".check");
const ballon = document.querySelector(".ballon");
const closeIcon = document.querySelector(".closer");
const progress = document.querySelector(".progress");

check.addEventListener("click", () => {
  ballon.classList.add("active");
  progress.classList.add("active");

  setTimeout(() => {
    ballon.classList.remove("active");
  }, 5000);

  setTimeout(() => {
    progress.classList.remove("active");
  }, 5300);
});

closeIcon.addEventListener("click", () => {
  ballon.classList.remove("active");
  setTimeout(() => {
    progress.classList.remove("active");
  }, 300);
});

const checker = document.querySelector(".checker");
const ballom = document.querySelector(".ballom");
const closerr = document.querySelector(".closer");
const progres = document.querySelector(".progress");

checker.addEventListener("click", () => {
  ballom.classList.add("active");
  progres.classList.add("active");

  setTimeout(() => {
    ballom.classList.remove("active");
  }, 5000);

  setTimeout(() => {
    progres.classList.remove("active");
  }, 5300);
});

closerr.addEventListener("click", () => {
  ballom.classList.remove("active");
  setTimeout(() => {
    progress.classList.remove("active");
  }, 300);
});

function login() {
  var email = document.getElementById("email1");
  var password = document.getElementById("password1");
  var rememberme = document.getElementById("remember");

  var f = new FormData();
  f.append("e", email.value);
  f.append("p", password.value);
  f.append("r", rememberme.checked);

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var t = r.responseText;
      if (t == "Success") {
        window.location = "home.php";
      } else {
        alert(t);
      }
    }
  };

  r.open("POST", "login.php", true);
  r.send(f);
}
function reset() {
  var email = document.getElementById("email1");
  var np = document.getElementById("newpass");
  var rnp = document.getElementById("newpass1");
  var vc = document.getElementById("vc");

  var f = new FormData();
  f.append("e", email.value);
  f.append("np", np.value);
  f.append("rnp", rnp.value);
  f.append("vc", vc.value);

  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var t = r.responseText;

      if (t == "Success") {
        alert("Your Password has been updated");
        window.location.reload();
      } else {
        alert(t);
      }
    }
  };

  r.open("POST", "resetpasswordprocess.php", true);
  r.send(f);
}

function showPass() {
  var np = document.getElementById("newpass");
  var npb = document.getElementById("npb");

  if (np.type == "password") {
    np.type = "text";
    npb.innerHTML = "<i class='bx bxs-low-vision'></i>";
  } else {
    np.type = "password";
    npb.innerHTML = "<i class='bx bx-show eye'></i>";
  }
}

function showPass1() {
  var np1 = document.getElementById("newpass1");
  var npb1 = document.getElementById("npb1");

  if (np1.type == "password") {
    np1.type = "text";
    npb1.innerHTML = "<i class='bx bxs-low-vision'></i>";
  } else {
    np1.type = "password";
    npb1.innerHTML = "<i class='bx bx-show eye'></i>";
  }
}
function logout() {
  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var t = r.responseText;
      if (t == "Success") {
        // window.location.reload();
        window.location = "index.php";
      } else {
        alert(t);
      }
    }
  };

  r.open("GET", "logout.php", true);
  r.send();
}
function openFileExplorer() {
  const fileInput = document.getElementById("profileImage");
  fileInput.click();
}

function changeProductimage() {
  var images = document.getElementById("imageuploader");
  images.click();

  images.onchange = function () {
    var file_count = images.files.length; // getting file count

    if (file_count <= 3) {
      for (var x = 0; x < file_count; x++) {
        var file = this.files[x];
        var url = window.URL.createObjectURL(file);
        document.getElementById("i" + x).src = url;
      }
    } else {
      alert(
        file_count +
          "files uploaded. We are only allowed  to upload 03 or less than 03 files."
      );
    }
  };
}

function updateProfile() {
  var profile_img = document.getElementById("profileImage");
  var first_name = document.getElementById("fname");
  var last_name = document.getElementById("lname");
  var mobile_no = document.getElementById("mobile");
  var email_address = document.getElementById("email");
  var address_line = document.getElementById("line1");
  var province = document.getElementById("province");
  var distric = document.getElementById("distric");
  var city = document.getElementById("city");
  var postal_code = document.getElementById("pc");

  var f = new FormData();
  f.append("img", profile_img.files[0]);
  f.append("fn", first_name.value);
  f.append("ln", last_name.value);
  f.append("mn", mobile_no.value);
  f.append("ea", email_address.value);
  f.append("adl", address_line.value);
  f.append("p", province.value);
  f.append("d", distric.value);
  f.append("c", city.value);
  f.append("pc", postal_code.value);

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.status == 200 && r.readyState == 4) {
      var t = r.responseText;
      if (t == "Success") {
        logout();
      } else {
        alert(t);
      }
    }
  };

  r.open("POST", "onboardingprocess.php", true);
  r.send(f);
}
function addProduct() {
  var category = document.getElementById("category");
  var title = document.getElementById("title");
  var s_description = document.getElementById("srd");
  var l_description = document.getElementById("ld");
  var cost = document.getElementById("cost");
  var d_cost_c = document.getElementById("dtc");
  var d_cost_o = document.getElementById("dto");
  var p_qty = document.getElementById("pq");
  var image = document.getElementById("imageuploader");

  var f = new FormData();
  f.append("ca", category.value);
  f.append("ti", title.value);
  f.append("sd", s_description.value);
  f.append("ld", l_description.value);
  f.append("cst", cost.value);
  f.append("dwc", d_cost_c.value);
  f.append("doc", d_cost_o.value);
  f.append("qty", p_qty.value);

  var file_count = image.files.length;
  for (var x = 0; x < file_count; x++) {
    f.append("img" + x, image.files[x]);
  }

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.status == 200 && r.readyState == 4) {
      var t = r.responseText;
      if (t == "Success") {
        window.location.reload();
      } else {
        alert(t);
      }
    }
  };

  r.open("POST", "listitemsprocess.php", true);
  r.send(f);
}

function updateProduct() {
  var title = document.getElementById("t");
  var qty = document.getElementById("pq");
  var dwc = document.getElementById("dtc");
  var doc = document.getElementById("dto");
  var dis = document.getElementById("ld");
  var sdis = document.getElementById("srd");
  var image = document.getElementById("imageuploader");

  var f = new FormData();

  f.append("t", title.value);
  f.append("q", qty.value);
  f.append("dwc", dwc.value);
  f.append("doc", doc.value);
  f.append("ld", dis.value);
  f.append("srd", sdis.value);

  var file_count = image.files.length;
  for (var x = 0; x < file_count; x++) {
    f.append("i" + x, image.files[x]);
  }

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.status == 200 && r.readyState == 4) {
      var t = r.responseText;

      if (t == "Success") {
        window.location = "myprofile.php";
      } else if (t == "Invalid Image Count") {
        if (
          confirm("Do you really not want to update the product image?") == true
        ) {
          window.location = "myprofile.php";
        } else {
          alert("Please Select Images.");
        }
      } else {
        alert(t);
      }
    }
  };

  r.open("POST", "updateProductProcess.php", true);
  r.send(f);
}

function basicSearch(x) {
  var text = document.getElementById("kw").value;
  var select = document.getElementById("c").value;

  var f = new FormData();
  f.append("t", text);
  f.append("s", select);
  f.append("page", x);

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.status == 200 && r.readyState == 4) {
      var t = r.responseText;
      document.getElementById("sortt").innerHTML = t;
    }
  };

  r.open("POST", "basicSearchProcess.php", true);
  r.send(f);
}
function sort(x) {
  var search = document.getElementById("s");
  var time = "0";

  if (document.getElementById("n").checked) {
    time = "1";
  } else if (document.getElementById("o").checked) {
    time = "2";
  }

  var price = "0";
  if (document.getElementById("h").checked) {
    price = "1";
  } else if (document.getElementById("l").checked) {
    price = "2";
  }

  var cata = "0";
  if (document.getElementById("b").checked) {
    cata = "1";
  } else if (document.getElementById("u").checked) {
    cata = "2";
  }

  var f = new FormData();
  f.append("s", search.value);
  f.append("t", time);
  f.append("p", price);
  f.append("c", cata);
  f.append("page", x);

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.status == 200 && r.readyState == 4) {
      var t = r.responseText;
      document.getElementById("sort").innerHTML = t;
    }
  };

  r.open("POST", "sortProccess.php", true);
  r.send(f);
}
function clearSort() {
  window.location.reload();
}

function sendId(id) {
  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.status === 200 && r.readyState == 4) {
      var t = r.responseText;
      if (t == "Success") {
        window.location = "updateProduct.php";
      } else {
        alert(t);
      }
    }
  };

  r.open("GET", "sendIdProcess.php?id=" + id, true);
  r.send();
}

function advancedSearch(x) {
  var text = document.getElementById("t");
  var category = document.getElementById("c1");
  var sort = document.getElementById("s");
  var from = document.getElementById("pf");
  var to = document.getElementById("pt");

  var f = new FormData();
  f.append("t", text.value);
  f.append("pf", from.value);
  f.append("pt", to.value);
  f.append("s", sort.value);
  f.append("cat", category.value);
  f.append("page", x);

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4) {
      var t = r.responseText;
      document.getElementById("sorta").innerHTML = t;
    }
  };

  r.open("POST", "advancedSearchProcess.php", true);
  r.send(f);
}

function watchlis() {
  window.location = "watchlist.php";
}

function addToWatchlist(id) {
  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.status === 200 && r.readyState == 4) {
      var t = r.responseText;
      if (t == "Added") {
        alert("Product Added to watchlist");
        window.location.reload();
      } else if (t == "Removed") {
        alert("Product Removed from watchlist");
        window.location.reload();
      } else {
        alert(t);
      }
    }
  };

  r.open("GET", "addtowatchlistprocess.php?id=" + id, true);
  r.send();
}

function removeFromWatchlist(id) {
  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.status === 200 && r.readyState == 4) {
      var t = r.responseText;
      if (t == "Deleted") {
        window.location.reload();
      } else {
        alert(t);
      }
    }
  };

  r.open("GET", "removefromwatchlistprocess.php?id=" + id, true);
  r.send();
}

function addToCart(id) {
  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var t = r.responseText;
      if (t == "This Product Already Exists In the cart") {
        alert("This Product Already Exists In the cart");
      } else if (t == "Product Added successfully") {
        alert("Product Added successfully");
        window.location.reload();
      } else {
        alert(t);
      }
    }
  };

  r.open("GET", "addToCartProcess.php?id=" + id, true);
  r.send();
}

function removeFromCart(id) {
  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.status === 200 && r.readyState == 4) {
      var t = r.responseText;
      if (t == "Deleted") {
        window.location.reload();
      } else {
        alert(t);
      }
    }
  };

  r.open("GET", "removefromcartprocess.php?id=" + id, true);
  r.send();
}

function addcart() {
  window.location = "cart.php";
}

function paynow(pid, qty) {

  qty = qty || 1;

  var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.status === 200 && r.readyState == 4) {
        var t = r.responseText;
        var obj = JSON.parse(t);

        var umail = obj["umail"];
        var amount = obj["amount"];

        if (t == "address error") {
            alert("Please Update Your Profile");
            window.location = "onboarding.php";
        } else {
            // Payment completed. It can be a successful failure.
            payhere.onCompleted = function onCompleted(orderId) {
            console.log("Payment completed. OrderID:" + orderId);
            saveInvoice(orderId,pid,umail,amount,qty);
            // Note: validate the payment and show success or failure page to the customer
            
            };

            // Payment window closed
            payhere.onDismissed = function onDismissed() {
            // Note: Prompt user to pay again or show an error page
            console.log("Payment dismissed");
            };

            // Error occurred
            payhere.onError = function onError(error) {
            // Note: show an error page
            console.log("Error:" + error);
            };

            // Put the payment variables here
            var payment = {
            sandbox: true,
            merchant_id: "1224340", // Replace your Merchant ID
            return_url: "http://localhost/CakeHub/singleproduct.php?id=" + pid, // Important
            cancel_url: "http://localhost/CakeHub/singleproduct.php?id=" + pid, // Important
            notify_url: "http://sample.com/notify",
            order_id: obj["id"],
            items: obj["item"],
            amount: amount,
            currency: "LKR",
            hash: obj["hash"], // *Replace with generated hash retrieved from backend
            first_name: obj["fname"],
            last_name: obj["lname"],
            email: umail,
            phone: obj["mobile"],
            address: obj["address"],
            city: obj["city"],
            country: "Sri Lanka",
            delivery_address: obj["address"],
            delivery_city: obj["city"],
            delivery_country: "Sri Lanka",
            custom_1: "",
            custom_2: "",
            };

            // Show the payhere.js popup, when "PayHere Pay" is clicked
            // document.getElementById("payhere-payment").onclick = function (e) {
            payhere.startPayment(payment);
            // };
        }
        }
    };

  r.open("GET", "pyanowProcess.php?id=" + pid + "&qty=" + qty, true);
  r.send();
}

function saveInvoice(orderId, pid, umail, amount, qty) {
  var f = new FormData();
  f.append("o", orderId);
  f.append("r", pid);
  f.append("u", umail);
  f.append("a", amount);
  f.append("q", qty);

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4) {
      var t = r.responseText;
      if (t == "Success") {
        window.location = "invoice.php?id=" + orderId;
      } else {
        alert(t);
      }
    }
  };

  r.open("POST", "saveInvoice.php", true);
  r.send(f);
}
function printInvoice(){
  var restorepage = document.body.innerHTML;
  var page = document.getElementById("page1").innerHTML;
  document.body.innerHTML = page;
  window.print();
  document.body.innerHTML = restorepage;
}
function saveinvoice(){
  var pageContent = document.getElementById("page").outerHTML;
  
  // Create a Blob containing the HTML content
  var blob = new Blob([pageContent], { type: "text/html" });
  
  // Create a link element
  var link = document.createElement("a");
  
  // Set the download attribute to specify the filename
  link.download = "invoice.html";
  
  // Create a URL for the Blob and set it as the href attribute
  link.href = window.URL.createObjectURL(blob);
  
  // Append the link to the body
  document.body.appendChild(link);
  
  // Click the link to trigger the download
  link.click();
  
  // Remove the link from the DOM
  document.body.removeChild(link);
}
function changeValue(amount, cartItemId) {
  var qtyElement = document.getElementById("qty_" + cartItemId);
  var currentValue = parseInt(qtyElement.innerText, 10);

  // Ensure the value doesn't go below 1
  if (currentValue + amount >= 1) {
      qtyElement.innerText = currentValue + amount;

      // Send the updated quantity to the server
      updateQuantityOnServer(cartItemId, currentValue + amount);
  }
}

function updateQuantityOnServer(cartItemId, newQuantity) {
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "update_quantity.php", true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function () {
      if (xhr.readyState === XMLHttpRequest.DONE) {
          if (xhr.status === 200) {
              console.log("Quantity updated successfully.");
          } else {
              console.error("Failed to update quantity.");
          }
      }
  };
  xhr.send("cartItemId=" + cartItemId + "&newQuantity=" + newQuantity);
}
function checkout(pid, qty, cid) {
  
  qty = qty || 1;

  var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.status === 200 && r.readyState == 4) {
        var t = r.responseText;
        var obj = JSON.parse(t);

        var umail = obj["umail"];
        var amount = obj["amount"];

        if (t == "address error") {
            alert("Please Update Your Profile");
            window.location = "onboarding.php";
        } else {
            // Payment completed. It can be a successful failure.
            payhere.onCompleted = function onCompleted(orderId) {
            console.log("Payment completed. OrderID:" + orderId);
            saveInvoice(orderId,pid,umail,amount,qty);
            // Note: validate the payment and show success or failure page to the customer
            removeItemFromCart(cid);
            };

            // Payment window closed
            payhere.onDismissed = function onDismissed() {
            // Note: Prompt user to pay again or show an error page
            console.log("Payment dismissed");
            };

            // Error occurred
            payhere.onError = function onError(error) {
            // Note: show an error page
            console.log("Error:" + error);
            };

            // Put the payment variables here
            var payment = {
            sandbox: true,
            merchant_id: "1224340", // Replace your Merchant ID
            return_url: "http://localhost/CakeHub/cart.php", // Important
            cancel_url: "http://localhost/CakeHub/cart.php", // Important
            notify_url: "http://sample.com/notify",
            order_id: obj["id"],
            items: obj["item"],
            amount: amount,
            currency: "LKR",
            hash: obj["hash"], // *Replace with generated hash retrieved from backend
            first_name: obj["fname"],
            last_name: obj["lname"],
            email: umail,
            phone: obj["mobile"],
            address: obj["address"],
            city: obj["city"],
            country: "Sri Lanka",
            delivery_address: obj["address"],
            delivery_city: obj["city"],
            delivery_country: "Sri Lanka",
            custom_1: "",
            custom_2: "",
            };

            // Show the payhere.js popup, when "PayHere Pay" is clicked
            // document.getElementById("payhere-payment").onclick = function (e) {
            payhere.startPayment(payment);
            // };
        }
        }
    };

  r.open("GET", "pyanowProcess.php?id=" + pid + "&qty=" + qty, true);
  r.send();
}
function removeItemFromCart(cid) {
  // Make an AJAX request to remove the item from the cart
  var xhr = new XMLHttpRequest();
  xhr.open("GET", "removeItemFromCart.php?id=" + cid, true);

  xhr.onreadystatechange = function () {
    if (xhr.readyState == 4 && xhr.status == 200) {
      console.log("Item removed from cart successfully");
    }
  };

  xhr.send();
}
function hoverStar(starIndex) {
  for (let i = 1; i <= starIndex; i++) {
    const star = document.querySelector(`.star-container .bx.bxs-star:nth-child(${i})`);
    star.classList.add('hover');
  }
}

function resetStarsColor() {
  const stars = document.querySelectorAll('.star-container .bx.bxs-star');
  stars.forEach(star => {
    star.classList.remove('hover');
  });
}

function review(userEmail) {
  var status = document.getElementById("experience-select").value;
  var title = document.getElementById("title").value;
  var body = document.getElementById("body").value;

  var f = new FormData();
  f.append("status", status);
  f.append("title", title);
  f.append("body", body);
  f.append("u", userEmail);  // Add the user's email to the FormData

  var r = new XMLHttpRequest();

  r.onreadystatechange = function() {
    if (r.readyState == 4) {  // Check if the request is complete
      if (r.status == 200) {  // Check if the response is OK
        var t = r.responseText;
        if (t === "Success") {
          alert("Thanks for Your Feedback!");
          window.location.reload();
        }
      }
    }
  };

  r.open("POST", "feedbackprocess.php", true);
  r.send(f);
}
function toggleLike(fidId, mail, heartIcon) {
  var f = new FormData();
  f.append("f", fidId);
  f.append("m", mail);

  var isLiked = heartIcon.classList.contains('liked');

  var r = new XMLHttpRequest();
  r.onreadystatechange = function() {
      if (r.readyState == 4) {
          if (r.status == 200) {
              var t = r.responseText;
              if (t === "Success") {
                  // Toggle the "liked" class on the heart icon
                  heartIcon.classList.toggle('liked');
                  // Toggle between empty heart and full heart
                  heartIcon.classList.toggle('bx-heart');
                  heartIcon.classList.toggle('bxs-heart');

                  // Store liked state in localStorage
                  localStorage.setItem('like_' + fidId, heartIcon.classList.contains('liked'));
              }
          } else {
              console.error('Error: ' + r.status);
              console.error('Response: ' + r.responseText);
          }
      }
  };

  // Toggle like based on current status
  if (isLiked) {
      r.open("POST", "removelike.php", true);
  } else {
      r.open("POST", "likeprocess.php", true);
  }

  r.send(f);
}
var storedFeedbackId; // Variable to store the feedback ID

function setFeedbackId(fid) {
    storedFeedbackId = fid; // Store the feedback ID in a variable
}

function reply(userEmail) {

  var body = document.getElementById("text").value;
    
  var f = new FormData();
  f.append("body", body);
  f.append("mail", userEmail);
  f.append("fid", storedFeedbackId);

  var r = new XMLHttpRequest();

  r.onreadystatechange = function() {
    if (r.readyState == 4) {  // Check if the request is complete
      if (r.status == 200) {  // Check if the response is OK
        var t = r.responseText;
        if (t === "Success") {
          alert("Successfully Added Reply!");
          window.location.reload();
        }
      }
    }
  };

  r.open("POST", "replyingprocess.php", true);
  r.send(f);
}
function contact(){
  var name = document.getElementById("usr").value;
  var email = document.getElementById("eml").value;
  var phone = document.getElementById("phn").value;
  var msg = document.getElementById("comment").value;

  var f = new FormData();
  f.append("name", name);
  f.append("mail", email);
  f.append("phone", phone);
  f.append("msg", msg);

  var r = new XMLHttpRequest();
  r.onreadystatechange = function() {
    if (r.readyState == 4) {
      if (r.status == 200) {
        var t = r.responseText;
        if (t == "OK") {
          alert("Message Successfully sent. You will be contact Soon!");
          window.location.reload();
        }
      }
    }
  }

  r.open("POST", "contactprocess.php", true);
  r.send(f);
}
function admin() {
  var email = document.getElementById("mail").value;
  var password = document.getElementById("pass").value;
  var rememberme = document.getElementById("remember").checked;

  var f = new FormData();
  f.append("e", email);
  f.append("p", password);
  f.append("r", rememberme);

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var t = r.responseText;
      if (t == "Success") {
        // Display the verification window
        document.getElementById("login").classList.add("d-none");
        document.getElementById("verify").classList.remove("d-none");
      } else {
        alert(t);
      }
    }
  };

  r.open("POST", "adminverify.php", true);
  r.send(f);
}
function verifyAndRedirect() {
  var verificationCode = document.getElementById("vco").value;
  var mail = document.getElementById("mail").value;

  var f = new FormData();
  f.append("e", mail);
  f.append("r", verificationCode);

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var t = r.responseText;
      if (t == "Success") {
        // Display the verification window
        window.location.href = "adminpannnel.php";
      } else {
        alert(t);
      }
    }
  };
  r.open("POST", "vertificationprocess.php", true);
  r.send(f);
}









