import { validateEmail } from "./input-validation.js";

const emailInput = document.querySelector("input[type='email']");
const passwordInput = document.querySelector("input[type='password']");
const form = document.querySelector("form");
const emailError = document.querySelector(".inputError.email");
const passwordError = document.querySelector(".inputError.password");

let valitEmail = false;
let valitPassword = false;

const checkEmail = (email) => {
  console.log(email);
  valitEmail = validateEmail(email);

  valitEmail
    ? (emailError.innerHTML = "")
    : (emailError.innerHTML = "Dit is geen geldig e-mailadres");
};

const checkPassword = (password) => {
  valitPassword = password.length > 0;

  valitPassword
    ? (passwordError.innerHTML = "")
    : (passwordError.innerHTML = "Wachtwoord is verplicht");
};

emailInput.addEventListener("focusout", (e) => {
  checkEmail(e.target.value);
});

passwordInput.addEventListener("focusout", (e) => {
  checkPassword(e.target.value);
});

form.addEventListener("submit", (e) => {
  e.preventDefault();

  checkEmail(emailInput.value);
  checkPassword(passwordInput.value);

  if (valitEmail && valitPassword) {
    form.submit();
  }
});
