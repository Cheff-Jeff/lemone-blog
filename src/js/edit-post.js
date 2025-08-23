const form = document.querySelector("form");
const contentInput = document.querySelector("#content");
const titleError = document.querySelector(".inputError.title");
const titleInput = document.querySelector(".title-field");
const contentError = document.querySelector(".inputError.content");

let contentValid = false;
let titleValid = false;

const quill = new Quill("#editor", {
  theme: "snow",
  placeholder: "Schrijf hier je post...",
  modules: {
    toolbar: [
      [{ header: [2, 3, 4, 5, 6, false] }],
      ["bold", "italic", "underline", "strike", "link"],
      ["blockquote"],
      [{ list: "ordered" }, { list: "bullet" }],
      [{ color: [] }, { background: [] }],
      ["clean"],
    ],
  },
});

quill.clipboard.dangerouslyPasteHTML(contentInput.value);

quill.on("text-change", (delta, oldDelta, source) => {
  contentInput.value = quill.getSemanticHTML();
});

const checkTitle = (title) => {
  titleValid = title.length > 10;

  titleValid
    ? (titleError.innerHTML = "")
    : (titleError.innerHTML = "titel is verplicht");
};

const checkContent = (content) => {
  contentValid = content.length > 10;

  contentValid
    ? (contentError.innerHTML = "")
    : (contentError.innerHTML = "content is verplicht");
};

titleInput.addEventListener("focusout", (e) => {
  checkTitle(e.target.value);
});

form.addEventListener("submit", (e) => {
  e.preventDefault();
  contentInput.value = quill.getSemanticHTML();

  checkTitle(titleInput.value);
  checkContent(contentInput.value);

  if (titleValid && contentValid) {
    form.submit();
  }
});
