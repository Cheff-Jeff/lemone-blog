const error = document.querySelector(".error-note");
const good = document.querySelector(".good-note");

if (error) {
  setTimeout(() => {
    error.classList.add("hide");
  }, 5000);
}

if (good) {
  setTimeout(() => {
    good.classList.add("hide");
  }, 5000);
}
