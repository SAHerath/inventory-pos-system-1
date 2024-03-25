var winState = "some";
var btnState = "some";

var buttonStates = ["open", "close"];
var windowStates = ["mobile", "tablet", "desktop"];

var gridCon = document.getElementById("gridContainer");


function setStateClass() {
  // set button class
  for (const i of windowStates) {
    if (winState == i) {
      // alert("Add  "+i+"-"+j);
      gridCon.classList.add(i);
    } else {
      // alert("Remove  "+i+"-"+j);
      gridCon.classList.remove(i);
    }
  }
  // set window class
  for (const j of buttonStates) {
    if (btnState == j) {
      // alert("Add  "+i+"-"+j);
      gridCon.classList.add(j);
    } else {
      // alert("Remove  "+i+"-"+j);
      gridCon.classList.remove(j);
    }
  }
}

function actionToggle() {
  if (btnState == "open") {
    btnState = "close";
    setStateClass();
  } else if (btnState == "close") {
    btnState = "open";
    setStateClass();
  }
}

function getWindowSize() {
  if (window.matchMedia("(min-width: 992px)").matches) {
    if (winState != "desktop") {
      winState = "desktop";
      btnState = "open";
      setStateClass();
    }
  } else if (window.matchMedia("(min-width: 576px)").matches) {
    if (winState != "tablet") {
      winState = "tablet";
      btnState = "close";
      setStateClass();
    }
  } else {
    if (winState != "mobile") {
      winState = "mobile";
      btnState = "close";
      setStateClass();
    }
  }
}

document.addEventListener('DOMContentLoaded', getWindowSize);
window.addEventListener('resize', getWindowSize);