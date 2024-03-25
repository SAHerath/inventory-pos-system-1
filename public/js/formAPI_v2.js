/*
 * Use submitForm function with onsubmit event to submit form data to server
 * Ex:-  <form onsubmit="submitForm(event, serverUrl, resultFunc)" id="form" novalidate> </form>
 *
 * Use fetchResult function to get server response
 */


function formSubmit(formEvent, serverUrl, callbackFunc = callbackDefault) {
  formEvent.preventDefault();
  const statusField = formEvent.target.firstElementChild;
  if (!statusField.classList.contains("status")) {
    console.log("statusField not found");
    statusField = "";
  }
  statusField.textContent = "";
  statusField.classList.remove("invalid");

  const formElem = formEvent.target.elements;
  console.log(formElem);

  const searchParam = new URLSearchParams();
  var valid = true;
  var files = false;

  for (let i = 0; i < formElem.length; i++) {
    // console.log(formElem[i]);
    // console.log(formElem[i].getAttribute("type"));
    let key = formElem[i].getAttribute("id");
    console.log(key);
    if (!(key == null)) {
      // first validate
      if (!formFieldValidate(formElem[i], statusField)) {
        valid = false;
      } else {
        // second append to FormData or SearchParams
        if (formElem[i].getAttribute("type") == "file") {
          console.log("file found");
          const formData = new FormData();
          formElem[i].classList.remove("invalid");

          for (let j = 0; j < formElem[i].files.length; j++) {
            if (!imageValidate(formElem[i].files[j], statusField)) {
              valid = false;
              formElem[i].classList.add("invalid");
              break;
            } else {
              formData.append(key, formElem[i].files[j]);
            }
          }
          // console.log(formElem[i].files[0].name);
          files = true;
        } else {
          searchParam.append(key, formElem[i].value);
        }
      }
    }

  }

  if (valid) {
    fetchServer(serverUrl, searchParam, callbackFunc, statusField);
    if (files) {
      fetchServer(serverUrl, formData, callbackFunc, statusField);
    }
  } else {
    statusField.classList.add("invalid");
  }
}

function formFieldValidate(formElem, errorField) {
  const fieldName = formElem.previousElementSibling.textContent;
  // console.log(fieldName);
  if (!formElem.validity.valid) {
    console.log("NOT valid");
    errorField.textContent += fieldName;

    if (formElem.validity.valueMissing) {
      // There must be a value (with a required attribute).
      errorField.textContent += ": Field is empty";

    } else if (formElem.validity.typeMismatch) {
      // The value must be compatible with attribute type.
      errorField.textContent += ": Type of the value is not matched";

    } else if (formElem.validity.tooShort) {
      // The number of characters must not be less than the value of the attribute minlength.
      errorField.textContent += ": Character length is too short";

    } else if (formElem.validity.tooLong) {
      // The number of characters must not exceed the value of the attribute maxlength. 
      errorField.textContent += ": Character length is too long";

    } else if (formElem.validity.patternMismatch) {
      // The value must be match with specified RegEx in attribute pattern
      errorField.textContent += ": Pattern of the value is not matched";

    } else if (formElem.validity.rangeUnderflow) {
      // The value must be greater than or equal to the value of attribute min.
      errorField.textContent += ": Value is under ranged";

    } else if (formElem.validity.rangeOverflow) {
      // The value must be less than or equal to the value of attribute max.
      errorField.textContent += ": Value is over ranged";

    }
    errorField.textContent += "\n";
    formElem.classList.add("invalid");
    return false;
  } else {
    formElem.classList.remove("invalid");
    return true;
  }

}

function fieldValidate(formElem) {
  if (!formElem.validity.valid) {
    formElem.classList.add("invalid");
    return false;
  } else {
    formElem.classList.remove("invalid");
    return true;
  }
}

function imageValidate(imgFile, errorField) {
  if (!imgFile.type.startsWith('image/')) {
    // validate image type
    // errorField.textContent += previousElementSibling.textContent + ": Unsupported file format found"; // append error with label
    errorField.textContent += "Image: Unsupported file format found\n";
    return false;
  } else if (imgFile.size > 1024 * 1024) {
    // validate max file size
    errorField.textContent += "Image: Maximum file size is 1 MB\n";
    return false;
  } else {
    return true;
  }
}

function fetchServer(url, data, callback, errField = null) {
  let fetchInit = {
    method: 'POST', // *GET, POST, PUT, DELETE, etc.
    //mode: 'cors', // no-cors, *cors, same-origin
    //cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
    //credentials: 'same-origin', // include, *same-origin, omit
    headers: {
      // 'Content-Type': 'application/json'
      // 'Content-Type': 'application/x-www-form-urlencoded'
      // if you want to send 'multipart/form-data' remove 'Content-Type' header, browser will do it. 
    },
    //redirect: 'follow', // manual, *follow, error
    //referrerPolicy: 'no-referrer', // no-referrer, *no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
    body: data // ArrayBuffer, ArrayBufferView, Blob/File, string, URLSearchParams, FormData
    // body data type must match "Content-Type" header
  };
  if (data instanceof URLSearchParams) {
    fetchInit['headers']['Content-Type'] = "application/x-www-form-urlencoded";
  }

  fetch(url, fetchInit)
    .then(function (response) {
      if (!response.ok) { // check that status is in the range 200-299 (Network failure)
        throw new Error(response.status); // throw error with status code
      }
      return response.text(); // if the response is valied, parse the response to text/json/blob/arrayBuffer/formData
    })
    .then(callback) // call callback function to handel the response
    .catch(function (error) { // catch errors
      if (errField instanceof Element) {
        errField.textContent = error;
        errField.classList.add("invalid");
      } else if (typeof errField == 'string') {
        let errElem = document.getElementById(errField);
        errElem.textContent = error;
        errElem.classList.add("invalid");
      } else {
        console.log("Fetch " + error);
      }
    });
}

function callbackDefault(result) {
  console.log("DefaultFunction");
  console.log(result);
}

/////////////////////////////////////////////////////////////////////

// function previewFile(fileInput, preview_box) {
//   // console.log(fileInput.files);
//   var previewBox = document.getElementById(preview_box);
//   previewBox.textContent = "";

//   let i = 0;
//   for (i = 0; i < fileInput.files.length; i++) {
//     const file = fileInput.files[i];

//     const image = document.createElement("img");
//     previewBox.appendChild(image);

//     const freader = new FileReader();
//     freader.onload = function (fileDone) {
//       // console.log(fileDone.target);
//       image.setAttribute("src", fileDone.target.result);
//     };
//     freader.readAsDataURL(file);
//   }
//   if (!i) {
//     previewBox.textContent = "No Image Selected";
//   }
// }

function previewFile(fileInput, previewboxId) {
  console.log(fileInput.files);
  var previewBox = document.getElementById(previewboxId);
  previewBox.textContent = "";

  let i = 0;
  for (i = 0; i < fileInput.files.length; i++) {
    const file = fileInput.files[i];

    const image = document.createElement("img");
    image.src = URL.createObjectURL(file);
    image.onload = function () {
      URL.revokeObjectURL(this.src);
    }
    previewBox.appendChild(image);
  }
  if (!i) {
    previewBox.textContent = "No Image Selected";
  }
}

function resetFile(fileinputId, previewboxId) {
  var fileInput = document.getElementById(fileinputId);
  var previewBox = document.getElementById(previewboxId);
  previewBox.textContent = "";
  fileInput.value = "";
}