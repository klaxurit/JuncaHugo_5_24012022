
function toggleTheme(theme) {
  document.body.classList.remove("dark", "light");
  document.body.classList.add(theme);
  window.localStorage.setItem("theme", theme)
}

// window.onload = checkTheme(); 

// function checkTheme() {
  const localStoredTheme = localStorage.getItem("theme");
  console.log(localStoredTheme, "THEME STORED")
  if(localStoredTheme){
    toggleTheme(localStoredTheme)
  }

//   if (localStorageTheme !== null && localStorageTheme === "dark") {
//       document.body.className = localStorageTheme;
//   }
// }

const switchLightEl = document.getElementsByClassName("switchLight")[0];
const switchDarkEl = document.getElementsByClassName("switchDark")[0];
// console.log("ici", switchLightEl)
switchDarkEl.addEventListener("click", function(event) {
  event.preventDefault()
  toggleTheme("dark")
});
switchLightEl.addEventListener("click", function(event) {
  event.preventDefault()
  toggleTheme("light")
});

