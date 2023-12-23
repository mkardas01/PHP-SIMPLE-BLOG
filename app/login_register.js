const loginbtn = document.getElementById("loginbtn");
const emailForm = document.getElementById('email-div');
const registerbtn = document.getElementById("registerbtn");
const repeatPass = document.getElementById("password2-div");
const repeatPassForm = document.getElementById('password2');
const submitButton = document.getElementById("submit");

registerbtn.addEventListener("click", function () {
    loginbtn.classList.remove('selected');
    registerbtn.classList.add('selected');
    repeatPass.style.display = 'block';
    emailForm.style.display = 'block';
    submitButton.innerText = 'Zarejestruj się';
    submitButton.value = 'register';
});

loginbtn.addEventListener("click", function () {
    registerbtn.classList.remove('selected');
    loginbtn.classList.add('selected');
    repeatPass.style.display = 'none';
    emailForm.style.display = 'none';
    submitButton.innerText = 'Zaloguj się';
    repeatPassForm.value = '';
    submitButton.value = 'login_in';
});

submitButton.addEventListener('click', function (event) {
    event.preventDefault();

    const login = document.getElementById('login');
    const email = document.getElementById("email");
    const password = document.getElementById("password");
    const password2 = document.getElementById("password2");
    const status = document.getElementById('status')
    let statusElement = document.createElement('p');
    statusElement.id = 'status';
    statusElement.style.position ='absolute';

    $.ajax({
        type: "POST",
        url: "loginuser",
        data: {
            login: login.value,
            email: email.value,
            password: password.value,
            password2: password2.value,
            submit: submitButton.value
        },
        cache: false,
        dataType:"json",
        success: function (data) {      
            if(status)
                status.remove();  

            statusElement.innerHTML = data['status'];
            statusElement.classList.add(data['text-color']);
            
            submitButton.parentElement.after(statusElement);

            if (data['redirect'])
                setTimeout(() => { window.location = ''; }, 2000);
        },
        error: function (data) {
            if(status)
                status.remove(); 
            statusElement.innerHTML = 'Błąd serwera';
            statusElement.classList.add('text-danger');
            submitButton.parentElement.after(statusElement);
        }
    });
});
