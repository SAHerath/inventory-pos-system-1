// const leftList = document.getElementById("dlb_left");
// const rightList = document.getElementById("dlb_right");
// const toLeftAll = document.getElementById("dlb_remv_all");
// const toRightAll = document.getElementById("dlb_add_all");

// leftList.addEventListener('change', swapItem.bind(leftList,
//   rightList)); // bind parameters with function, first parameter will be 'this' in the function
// rightList.addEventListener('change', swapItem.bind(rightList, leftList));

// toLeftAll.addEventListener('click', swapAllItems.bind(rightList, leftList)); // this, elem
// toRightAll.addEventListener('click', swapAllItems.bind(leftList, rightList));

// function swapItem(elem) {
//   let newOption = this.options[this.selectedIndex];
//   // console.log(newOption.value);

//   let newIndex = -1; // invalid index add the first and last option
//   for (let i = 0; i < elem.length; i++) {
//     if ((elem.options[i].value * 1) > (newOption.value * 1)) // multiplying by 1 will convert string to integer
//     {
//       newIndex = i;
//       break;
//     }
//     // console.log("old " + elem.options[i].value);
//   }

//   this.remove(this.selectedIndex);
//   newOption.selected = false;
//   elem.add(newOption, newIndex);
// }

// function swapAllItems(elem) {
//   let len = this.length - 1;
//   for (let i = len; i >= 0; i--) {
//     // console.log(this.options[i].value);
//     elem.add(this.options[i], 0);
//     this.remove(i);
//   }
// }

function swapItem(listbox1, listboxId2) {
  const listbox2 = document.getElementById(listboxId2);

  let newOption = listbox1.options[listbox1.selectedIndex];
  // console.log(newOption.value);
  let newIndex = -1; // invalid index add the first and last option

  for (let i = 0; i < listbox2.length; i++) {
    if ((listbox2.options[i].value * 1) > (newOption.value * 1)) // multiplying by 1 will convert string to integer
    {
      newIndex = i;
      break;
    }
    // console.log("old " + listbox2.options[i].value);
  }

  listbox1.remove(listbox1.selectedIndex);
  newOption.selected = false;
  listbox2.add(newOption, newIndex);
}

function swapAllItems(listboxId1, listboxId2) { // move all items from listboxId1 to listboxId2
  const listbox1 = document.getElementById(listboxId1);
  const listbox2 = document.getElementById(listboxId2);

  let len = listbox1.length - 1;
  for (let i = len; i >= 0; i--) {
    // console.log(listbox1.options[i].value);
    listbox2.add(listbox1.options[i], 0);
    listbox1.remove(i);
  }
}