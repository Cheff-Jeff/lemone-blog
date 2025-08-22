const modal = document.querySelector(".modal");
const modalTrigger = document.querySelector("#modal-trigger");
const closeBtn = document.querySelector(".close");

const editReactionTrigger = document.querySelector("#edit-trigger");
const editReactionForm = document.querySelector(".edit-reaction-form");

if (modal && modalTrigger) {
  modalTrigger.addEventListener("click", () => {
    modal.classList.remove("hide");
  });

  closeBtn.addEventListener("click", () => {
    modal.classList.add("hide");
  });

  modal.addEventListener("click", (e) => {
    if (e.target === modal) {
      modal.classList.add("hide");
    }
  });
}

if (editReactionTrigger && editReactionForm) {
  editReactionTrigger.addEventListener("click", (e) => {
    e.preventDefault();
    editReactionForm.classList.toggle("hide");

    editReactionForm.classList.contains("hide")
      ? (editReactionTrigger.innerHTML = "Bewerken")
      : (editReactionTrigger.innerHTML = "Sluiten");

    window.scrollTo({
      top: editReactionForm.offsetTop - 100,
      behavior: "smooth",
    });
  });
}
