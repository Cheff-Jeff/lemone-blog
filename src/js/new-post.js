const form = document.querySelector("form");
const contentInput = document.querySelector("#content");

const quill = new Quill("#editor", {
  theme: "snow",
  placeholder: "Schrijf hier je post...",
  modules: {
    toolbar: [
      [{ header: [2, 3, 4, 5, 6, false] }],
      ["bold", "italic", "underline", "strike", "link"],
      ["blockquote"],
      [{ list: "ordered" }, { list: "bullet" }],

      [{ color: [] }, { background: [] }], // dropdown with defaults from theme

      ["clean"], // remove formatting button
    ],
  },
});

// quill.clipboard.dangerouslyPasteHTML(
//   '<h3>Dit&nbsp;is&nbsp;mijn&nbsp;nieuwe&nbsp;post</h3><p><strong>Dit&nbsp;is&nbsp;vet&nbsp;met&nbsp;<a href="#" rel="noopener noreferrer" target="_blank">link</a></strong></p><p></p><p></p><p>&lt;script&gt;</p><p>alert(&quot;Hello!&nbsp;I&nbsp;am&nbsp;an&nbsp;alert&nbsp;box!&quot;);</p><p>&lt;/script&gt;</p>'
// );

form.addEventListener("submit", (e) => {
  e.preventDefault();

  contentInput.value = quill.getSemanticHTML();
  // console.log(quill.getSemanticHTML());
  form.submit();
});
