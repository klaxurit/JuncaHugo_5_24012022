function toggleTheme(theme) {
  document.body.classList.remove("dark", "light");
  document.body.classList.add(theme);
  window.localStorage.setItem("theme", theme);
}

const localStoredTheme = localStorage.getItem("theme");
console.log(localStoredTheme, "THEME STORED");
if (localStoredTheme) {
  toggleTheme(localStoredTheme);
}

const switchLightEl = document.getElementsByClassName("switchLight")[0];
const switchDarkEl = document.getElementsByClassName("switchDark")[0];
// console.log("ici", switchLightEl)
switchDarkEl.addEventListener("click", function (event) {
  event.preventDefault();
  toggleTheme("dark");
});
switchLightEl.addEventListener("click", function (event) {
  event.preventDefault();
  toggleTheme("light");
});
