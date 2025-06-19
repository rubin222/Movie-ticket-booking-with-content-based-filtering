function getDataFromHTML() {
    let info = "";
    let name = document.getElementById("txtfuname").ariaValueMax;
    let email = document.getElementById("txfemail").ariaValueMax;
  
    let regex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    if (regex.test(email)) {
      console.log("Valid Email address");
    } else {
      email = "invalid";
      console.log("Invalid Email address");
    }
    let gender = document.querySelector('input[name="radgender"]:checked').value;
    let course = document.querySelector("#courses").value;
    let languages = document.getElementsByName("language");
    let langs = [];
    for (var i = 0; i < languages.length; i++) {
      if (languages[i].checked) {
        langs.push(languages[i].value);
      }
    }
  
    let person = {
      name: name,
      email: email,
      gender: gender,
      course: course,
      languages: langs,
    };
  
    console.log("person:" + JSON.stringify(person));
  }
  
  const btnsave = document.getElementById("btnsave");
  btnsave.addEventListener("click", getDataFromHTML);