const tabLinks = document.querySelectorAll('#sidebar .side-menu.top li a');

function showTab(tabId) {
    // Hide all tab contents
    const tabContents = document.querySelectorAll('.tab-content');
    tabContents.forEach(content => {
        content.style.display = 'none';
    });

    // Display the content of the selected tab
    const selectedTabContent = document.getElementById(tabId);
    if (selectedTabContent) {
        selectedTabContent.style.display = 'block';
    }
}

tabLinks.forEach(item => {
    item.addEventListener('click', function (event) {
        event.preventDefault(); // Prevent default link behavior

        // Remove the 'active' class from all tabs
        tabLinks.forEach(link => {
            link.parentElement.classList.remove('active');
        });

        // Add the 'active' class to the clicked tab
        item.parentElement.classList.add('active');

        // Display the content of the selected tab
        const tabId = item.getAttribute('data-tab-id');
        showTab(tabId);
    });
});
// Add event listener for the "See Section 7" span
const openSection7Button = document.getElementById('openSection7');
if (openSection7Button) {
    openSection7Button.addEventListener('click', function () {
        const tabId = 'section7';
        showTab(tabId);
    });
}
const openSection8Button = document.getElementById('openSection8');
if (openSection8Button) {
    openSection8Button.addEventListener('click', function () {
        const tabId = 'section8';
        showTab(tabId);
    });
}
// Initial load: Show the content of the first tab and mark it as active
const defaultTabId = tabLinks[0].getAttribute('data-tab-id');
showTab(defaultTabId);

// TOGGLE SIDEBAR
const menuBar = document.querySelector('#content nav .bx.bx-menu');
const sidebar = document.getElementById('sidebar');

menuBar.addEventListener('click', function () {
	sidebar.classList.toggle('hide');
})

const searchButton = document.querySelector('#content nav form .form-input button');
const searchButtonIcon = document.querySelector('#content nav form .form-input button .bx');
const searchForm = document.querySelector('#content nav form');

searchButton.addEventListener('click', function (e) {
	if(window.innerWidth < 576) {
		e.preventDefault();
		searchForm.classList.toggle('show');
		if(searchForm.classList.contains('show')) {
			searchButtonIcon.classList.replace('bx-search', 'bx-x');
		} else {
			searchButtonIcon.classList.replace('bx-x', 'bx-search');
		}
	}
})

if(window.innerWidth < 768) {
	sidebar.classList.add('hide');
} else if(window.innerWidth > 576) {
	searchButtonIcon.classList.replace('bx-x', 'bx-search');
	searchForm.classList.remove('show');
}

window.addEventListener('resize', function () {
	if(this.innerWidth > 576) {
		searchButtonIcon.classList.replace('bx-x', 'bx-search');
		searchForm.classList.remove('show');
	}
})

const switchMode = document.getElementById('switch-mode');

switchMode.addEventListener('change', function () {
	if(this.checked) {
		document.body.classList.add('dark');
	} else {
		document.body.classList.remove('dark');
	}
})

function logout(){
    var r = new XMLHttpRequest();
    r.onreadystatechange = function(){
        if(r.readyState == 4 && r.status == 200){
            var t = r.responseText;
            if(t == "Success"){
                // window.location.reload();
                window.location = "index.php";
            }else{
                alert (t);
            }
        }
    }

    r.open("GET", "logout.php", true);
    r.send();
}

function sort(x){
    
    var search = document.getElementById("s");
    var time = "0";

    if(document.getElementById("n").checked){
        time = "1";
    }else if (document.getElementById("o").checked){
        time = "2";
    }

    var price = "0";
    if(document.getElementById("h").checked){
        price = "1";
    }else if (document.getElementById("l").checked){
        price = "2";
    }

    var cata = "0";
    if(document.getElementById("b").checked){
        cata = "1";
    }else if (document.getElementById("u").checked){
        cata = "2";
    }


    var f = new FormData();
    f.append("s",search.value);
    f.append("t",time);
    f.append("p",price);
    f.append("c",cata);
    f.append("page",x);

    var r = new XMLHttpRequest();

    r.onreadystatechange = function() {
        if(r.status == 200 && r.readyState == 4){
            var t = r.responseText;
            document.getElementById("sort").innerHTML = t;
        }
    }

    r.open("POST","sortProccess.php",true);
    r.send(f);
}

function clearSort(){
    window.location.reload();
}

function sendId(id){

  var r = new XMLHttpRequest();

  r.onreadystatechange = function() {
      if(r.status === 200 && r.readyState == 4){
          var t = r.responseText;
          if(t == "Success"){
              window.location = "updateProduct.php";
          }else{
              alert(t);
          }
      }
  }


  r.open("GET", "sendIdProcess.php?id=" + id, true);
  r.send();

}
function deleterep(cid){

  var r = new XMLHttpRequest();
  r.onreadystatechange = function(){
    if (r.readyState == 4) {
      if (r.status == 200) {
        var t = r.responseText;
        if (t == "OK") {
          alert("Succefully Deleted Message!");
          window.location.reload();
        }
      }
    }
  }
  r.open("GET", "deleteProcess.php?id=" + cid, true);
  r.send();
}
function sendme(cid, userEmail, umail) {
    // Get the reply message from the input field
    var replyMessage = document.getElementById('reply').value;
        
    if (!replyMessage.trim()) {
        alert("Please type a message.");
    } else {
        // Proceed with sending the data
        var f = new FormData();
        f.append("c", cid);
        f.append("u", userEmail);
        f.append("t", replyMessage);
        f.append("r", umail);
        
        var r = new XMLHttpRequest();
        r.onreadystatechange = function() {
            if (r.readyState == 4) {
                if (r.status == 200) {
                    var t = r.responseText;
                    if (t == "Success") {
                        window.location.reload();
                    }
                }
            }
        };

        r.open("POST", "replys.php", true);
        r.send(f);
    }
}

function respondToEmail(span) {
    
    var email = span.getAttribute("data-email");
    var cid = span.getAttribute("data-cid");

    
    window.location.href = 'reply.php?email=' + encodeURIComponent(email) + '&cid=' + encodeURIComponent(cid);
}

var myModal = document.getElementById('myModal');
var psModal = document.getElementById('psModal');
var remodal = document.getElementById('remodal');
var unmodal = document.getElementById('unmodal');
var actionSelect = document.querySelectorAll('.status.completed');
var closeButtons1 = document.querySelectorAll('.close');
var closeBanButton = document.getElementById('cancelBanButton');
var closeBanButton11 = document.getElementById('cancelBanButton1');
var closeBanButton2 = document.getElementById('cancelBanButton2');
var closeBanButton3 = document.getElementById('cancelBanButton3');



// // Event listeners for close buttons
closeBanButton.addEventListener('click', closeAllModals);
closeBanButton11.addEventListener('click', closeAllModals);
closeBanButton2.addEventListener('click', closeAllModals);
closeBanButton3.addEventListener('click', closeAllModals);

// Function to open the "Ban User" modal
function openBanUserModal() {
    myModal.style.display = 'block';
}

// Function to open the "Change Password" modal
function openChangePasswordModal() {
    psModal.style.display = 'block';
}

// Function to open the "Make as Admin" modal
function openRemoveAdminModal() {
    remodal.style.display = 'block';
}
function openUnBanModal() {
    unmodal.style.display = 'block';
}

// Function to close all modals
function closeAllModals() {
    myModal.style.display = 'none';
    psModal.style.display = 'none';
    remodal.style.display = 'none';
    unmodal.style.display = 'none';
    
}    


// Event listeners for the dropdowns
actionSelect.forEach(function (select) {
    select.addEventListener('change', function () {
        var selectedOption = select.value;
        console.log('selected option', selectedOption);

        closeAllModals();

        if (selectedOption === 'option1') {
            openBanUserModal();
        } else if (selectedOption === 'option2') {
            openChangePasswordModal();
        } else if (selectedOption === 'option5') {
            openRemoveAdminModal();
        }else if (selectedOption === 'option4') {
            openUnBanModal();
        } 
    
    });
});

// Event listeners for close buttons
closeButtons1.forEach(function (button1) {
    button1.addEventListener('click', function () {
        closeAllModals();
    });
});

// Event listener to close the modal when clicking outside
window.addEventListener('click', function (event) {
    if (event.target === myModal || event.target === psModal || event.target === remodal || event.target === unmodal ){
        closeAllModals();
    }
});


var BanModal1 = document.getElementById('BanModal1');
var PassModal1 = document.getElementById('PasssModal1');
var AdminModal1 = document.getElementById('AdminModal1');
var UnBanModal1 = document.getElementById('unbanmodal1');
var actionSelect1 = document.querySelectorAll('.status.pending');
var closeButtons1 = document.querySelectorAll('.closee');
var closeBanButton1 = document.getElementById('cancelBanButton4');
var closeBanButton11 = document.getElementById('cancelBanButton5');
var closeBanButton12 = document.getElementById('cancelBanButton6');
var closeBanButton13 = document.getElementById('cancelBanButton7');

// Event listeners for close buttons
closeBanButton1.addEventListener('click', closeAllModals1);
closeBanButton11.addEventListener('click', closeAllModals1);
closeBanButton12.addEventListener('click', closeAllModals1);
closeBanButton13.addEventListener('click', closeAllModals1);

// Function to open the "Ban User" modal
function openBanUserModal1() {
    BanModal1.style.display = 'block';
}

// Function to open the "Change Password" modal
function openChangePasswordModal1() {
    PassModal1.style.display = 'block';
}

// Function to open the "Make as Admin" modal
function openMakeAdminModal1() {
    AdminModal1.style.display = 'block';
}
function openUnBanModal1() {
    UnBanModal1.style.display = 'block';
}

// Function to close all modals
function closeAllModals1() {
    BanModal1.style.display = 'none';
    PassModal1.style.display = 'none';
    AdminModal1.style.display = 'none';
    UnBanModal1.style.display = 'none';
   
}

// Event listeners for the dropdowns
actionSelect1.forEach(function (select1) {
    select1.addEventListener('change', function () {
        
        var selectedOption1 = select1.value;
        console.log('selected option', selectedOption1);

        closeAllModals1(); // Close all modals first
        
        if (selectedOption1 === 'option1') {
            openBanUserModal1();
        } else if (selectedOption1 === 'option2') {
            openChangePasswordModal1();
        } else if (selectedOption1 === 'option3') {
            openMakeAdminModal1();
        } else if (selectedOption1 === 'option4') {
            openUnBanModal1();
        } 
    });
});

// Event listeners for close buttons
closeButtons1.forEach(function (button1) {
    button1.addEventListener('click', function () {
        closeAllModals1();
    });
});

// Event listener to close the modal when clicking outside
window.addEventListener('click', function (event) {
    if (event.target === BanModal1 || event.target === PassModal1 || event.target === AdminModal1 || event.target === UnBanModal1 ){
        closeAllModals1();
    }
});


function ban(uemail, amail) {
  var Password = document.getElementById("passwordInput1").value;

  if (!Password.trim()) {
    alert("Please enter admin password!");
  } else {
    var f = new FormData();
    f.append("Pass", Password);
    f.append("umail", uemail);
    f.append("amail", amail);

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
      if (r.readyState == 4) {
        if (r.status == 200) {
          var t = r.responseText;
          if (t == "OK") {
            alert("Successfully Banned User!");
            window.location.reload();
          } else {
            alert("Invalid Admin Password!");
          }
        }
      }
    };
    r.open("POST", "userbanprocess.php", true);
    r.send(f);
  }
}
function changepass(uemail, amail){
    var password = document.getElementById("pas3").value;
    var pass = document.getElementById("pas4").value;
    var pass2 = document.getElementById("pas5").value;

    var f = new FormData();
    f.append("amail", amail);
    f.append("umail", uemail);
    f.append("pass", password);
    f.append("pass2", pass);
    f.append("pass3", pass2);

    var r = new XMLHttpRequest();

    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var t = r.responseText;
            if (t == "OK") {
                
            }else{
                alert("Successfully changed password!");
                window.location.reload();
            }
        }
    };
    r.open("POST", "adminpasswordchange.php", true);
    r.send(f);
}
function adadmin(uemail, amail) {
  var password = document.getElementById("password1").value;

  if (!password.trim()) {
    alert("Please enter admin password!");
  } else {
    var f = new FormData();
    f.append("Pass", password);
    f.append("umail", uemail);
    f.append("amail", amail);

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
      if (r.readyState == 4) {
        if (r.status == 200) {
          var t = r.responseText;
          if (t == "OK") {
            alert("Successfully Added as Admin!");
            window.location.reload();
          } else {
            alert("Invalid Admin Password!");
          }
        }
      }
    };
    r.open("POST", "makeadminprocess.php", true);
    r.send(f);
  }
}

function unban(uemail, amail) {
    var Password = document.getElementById("passwordInput2").value;
  
    if (!Password.trim()) {
      alert("Please enter admin password!");
    } else {
      var f = new FormData();
      f.append("Pass", Password);
      f.append("umail", uemail);
      f.append("amail", amail);
  
      var r = new XMLHttpRequest();
  
      r.onreadystatechange = function () {
        if (r.readyState == 4) {
          if (r.status == 200) {
            var t = r.responseText;
            if (t == "OK") {
              alert("Successfully UnBanned User!");
              window.location.reload();
            } else {
              alert("Invalid Admin Password!");
            }
          }
        }
      };
      r.open("POST", "userunbanprocess.php", true);
      r.send(f);
    }
}
function ban1(uemail, amail) {
    var Password = document.getElementById("passwordInput").value;
  
    if (!Password.trim()) {
      alert("Please enter admin password!");
    } else {
      var f = new FormData();
      f.append("Pass", Password);
      f.append("umail", uemail);
      f.append("amail", amail);
  
      var r = new XMLHttpRequest();
  
      r.onreadystatechange = function () {
        if (r.readyState == 4) {
          if (r.status == 200) {
            var t = r.responseText;
            if (t == "OK") {
              alert("Successfully Banned User!");
              window.location.reload();
            } else {
              alert("Invalid Admin Password!");
            }
          }
        }
      };
      r.open("POST", "userbanprocess.php", true);
      r.send(f);
    }
}
function changepass1(uemail, amail){
    var password = document.getElementById("pas").value;
    var pass = document.getElementById("pas1").value;
    var pass2 = document.getElementById("pas2").value;

    var f = new FormData();
    f.append("amail", amail);
    f.append("umail", uemail);
    f.append("pass", password);
    f.append("pass2", pass);
    f.append("pass3", pass2);

    var r = new XMLHttpRequest();

    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var t = r.responseText;
            if (t == "OK") {
                
            }else{
                alert("Successfully changed password!");
                window.location.reload();
            }
        }
    };
    r.open("POST", "adminpasswordchange.php", true);
    r.send(f);
}
function remadmin(uemail, amail) {
    var password = document.getElementById("pass2").value;
  
    if (!password.trim()) {
      alert("Please enter admin password!");
    } else {
      var f = new FormData();
      f.append("Pass", password);
      f.append("umail", uemail);
      f.append("amail", amail);
  
      var r = new XMLHttpRequest();
  
      r.onreadystatechange = function () {
        if (r.readyState == 4) {
          if (r.status == 200) {
            var t = r.responseText;
            if (t == "OK") {
              alert("Successfully leaved as Admin!");
              window.location.reload();
            } else {
              alert("Invalid Admin Password!");
            }
          }
        }
      };
      r.open("POST", "removeadminprocess.php", true);
      r.send(f);
    }
}
  
function unban1(uemail, amail) {
  var Password = document.getElementById("passwordInput3").value;

  if (!Password.trim()) {
    alert("Please enter admin password!");
  } else {
    var f = new FormData();
    f.append("Pass", Password);
    f.append("umail", uemail);
    f.append("amail", amail);

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
      if (r.readyState == 4) {
        if (r.status == 200) {
          var t = r.responseText;
          if (t == "OK") {
            alert("Successfully UnBanned User!");
            window.location.reload();
          } else {
            alert("Invalid Admin Password!");
          }
        }
      }
    };
    r.open("POST", "userunbanprocess.php", true);
    r.send(f);
  }
}
const openModalButton = document.getElementById("openModalButton");
const modal = document.getElementById("ListModal");
const closeModalButton = document.getElementById("closeModal");
const cancelButton = document.getElementById("cancel");

function openModal() {
  modal.style.display = "block";
}

function closeModal() {
  modal.style.display = "none";
}

function closeOnOutsideClick(event) {
  if (event.target === modal) {
    modal.style.display = "none";
  }
}

openModalButton.addEventListener("click", openModal);
closeModalButton.addEventListener("click", closeModal);
cancelButton.addEventListener("click", closeModal);
window.addEventListener("click", closeOnOutsideClick);

function addcat(email){
  var password = document.getElementById("password34").value;
  var text = document.getElementById("cat").value;

  if (!password.trim()) {
    alert("Please enter admin password");
  }else {
    var f = new FormData();
    f.append("Pass", password);
    f.append("Email", email);
    f.append("text", text);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
      if (r.readyState == 4) {
        if (r.status == 200) {
          var t = r.responseText;
          if (t == "OK") {
            alert("Successfully Added New Categeory!");
            window.location.reload();
          } else {
            alert("Invalid Admin Password!");
          }
        }
      }
    };
    r.open("POST", "addcatprocess.php", true);
    r.send(f);
  }
}

const openModalButton1 = document.getElementById("backupmodal1");
const modal1 = document.getElementById("backupmodal");
const closeModalButton1 = document.getElementById("cancel1");
const cancelButton1 = document.getElementById("closeModal");
const procesButton = document.getElementById("process45");

function openModal1() {
  modal1.style.display = "block";
}

function closeModal1() {
  modal1.style.display = "none";
}

function closeModal2() {
  modal1.style.display = "none";
}

function closeOnOutsideClick1(event) {
  if (event.target === modal) {
    modal1.style.display = "none";
  }
}

openModalButton1.addEventListener("click", openModal1);
closeModalButton1.addEventListener("click", closeModal1);
cancelButton1.addEventListener("click", closeModal1);
procesButton.addEventListener("click", closeModal2);
window.addEventListener("click", closeOnOutsideClick1);


function downdata(mail) {
  var password = document.getElementById("password9").value;

  if (!password.trim()) {
    alert("Please enter admin password");
  } else {
    var f = new FormData();
    f.append("Pass", password);
    f.append("email", mail);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
      if (r.readyState == 4) {
        if (r.status == 200) {
          var t = r.responseText;
          if (t == "OK") {
            
          } else {
            
          }
        }
      }
    };
    r.open("POST", "BackupData.php", true);
    r.send(f);
  }
}
const openModalButton2 = document.getElementById("cloudmodal1");
const modal2 = document.getElementById("cloudmodal");
const closeModalButton2 = document.getElementById("cancel2");
const cancelButton2 = document.getElementById("closeModal");
const procesButton1 = document.getElementById("process55");

function openModal2() {
  modal2.style.display = "block";
}

function closeModal2() {
  modal2.style.display = "none";
}

function closeModal3() {
  modal2.style.display = "none";
}

function closeOnOutsideClick2(event) {
  if (event.target === modal) {
    modal2.style.display = "none";
  }
}

openModalButton2.addEventListener("click", openModal2);
closeModalButton2.addEventListener("click", closeModal2);
cancelButton2.addEventListener("click", closeModal1);
procesButton1.addEventListener("click", closeModal3);
window.addEventListener("click", closeOnOutsideClick2);

function updata(email) {
  var password = document.getElementById("password09").value;

  if (!password.trim()) {
    alert("Please enter Password");
  } else {
    var f = new FormData();
    f.append("Pass", password);
    f.append("Email", email);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
      if (r.readyState == 4) {
        if (r.status == 200) {
          var t = r.responseText;
          if (t == "OK") {
            alert ("Successfully Backuped Database To Google Drive!");
          } else {
            
          }
        }
      }
    };
    r.open("POST", "UploadData.php", true);
    r.send(f);
  }
}