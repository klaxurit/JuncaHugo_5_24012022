window.onload = () => {
  let buttons = document.querySelectorAll(".custom-control-input")

  for(let button of buttons){
    button.addEventListener("click", activate)
    
  }
}


function activate(){
  let xmlhttp = new XMLHttpRequest;
  
  xmlhttp.open('GET', '/admin/activateComment'+this.dataset.id)
  
  xmlhttp.send()
}