document.addEventListener("DOMContentLoaded", () => {
  const login = document.getElementById("login");
  const register = document.getElementById("register");
  const loginBox = document.getElementById("form-box-login");
  const registerBox = document.getElementById("form-box-register");

  const activeForm = localStorage.getItem("activeForm");

  if (activeForm === "register") {
    loginBox.style.display = "none";
    registerBox.style.display = "block";
  } else {
    registerBox.style.display = "none";
    loginBox.style.display = "block";
  }

  register.onclick = e => {
    e.preventDefault();
    loginBox.style.display = "none";
    registerBox.style.display = "block";
    localStorage.setItem("activeForm", "register");
    document.title = "User Registration";
  };

  login.onclick = e => {
    e.preventDefault();
    registerBox.style.display = "none";
    loginBox.style.display = "block";
    localStorage.setItem("activeForm", "login");
    document.title = "User Login";
  };
});

document.getElementById("loginBtn").addEventListener("click", function() {
    window.location.href = "index.html";
});

document.getElementById("registerBtn").addEventListener("click", function() {
    window.location.href = "index.html";
});

document.querySelectorAll(".social-link").forEach(link => {
    link.addEventListener("click", function(e) {

        if (window.innerWidth > 768) {
            e.preventDefault();
            window.open(
                this.href,
                "socialPopup",
                "width=500,height=600"
            );
        } else {
          this.setAttribute("target", "_blank");
        }
    });
});