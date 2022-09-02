const modalContainer = document.getElementById("modal_container");
const open = document.getElementById("open");
const close = document.getElementById("close");

open.addEventListener("click", () => {
  modalContainer.classList.add("show");

});

close.addEventListener("click", () => {
  modalContainer.classList.remove("show");
});