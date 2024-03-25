function showDrop(element) {
  // alert('hi ' + elem.tagName);
  var dropContent = element.nextElementSibling;
  if (dropContent.classList.contains("drop-content")) {
    dropContent.classList.toggle("show");
  }
  element.classList.toggle("show");
  // alert(dropContent);
}

function setClassTimeout(element, className, delay) {
  element.classList.add(className);
  return new Promise(resolve => {
    setTimeout(function () {
      resolve("done");
      element.classList.remove(className);
    }, delay)
  })
}

// function setClassTimeout(element, className, delay) {
//   element.classList.add(className);
//   setTimeout(function () {
//     element.classList.remove(className);
//   }, delay)
// }



function createTblData(parent, content, data = null) {
  let tblData = document.createElement("div");
  tblData.classList.add("td");
  tblData.innerHTML = content;
  if (data) {
    tblData.dataset.value = data;
  }
  // if (content instanceof Element) {
  //   tblData.appendChild(content);
  // } else {
  //   tblData.textContent = content;
  // }
  parent.appendChild(tblData);
  // return tblData;
}

function setEventsByClass(className, callbackFunc) {
  let btnList = document.getElementsByClassName(className);
  let len = btnList.length;
  if (len) {
    for (let i = 0; i < len; i++) {
      btnList.item(i).addEventListener("click", callbackFunc);
    }
  }
}

function showHide(modalId) {
  // console.log(modalId);
  document.getElementById(modalId).classList.toggle("active");
}


class ServerCall {
  constructor(url) {
    this.url = url;
    this.callback = null;

    this.fetchInit = {
      method: 'POST', // *GET, POST, PUT, DELETE, etc.
      //mode: 'cors', // no-cors, *cors, same-origin
      //cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
      //credentials: 'same-origin', // include, *same-origin, omit
      headers: {
        //   // 'Content-Type': 'application/json'
        //   'Content-Type': 'application/x-www-form-urlencoded'
        //   // if you want to send 'multipart/form-data' remove 'Content-Type' header, browser will do it. 
      },
      //redirect: 'follow', // manual, *follow, error
      //referrerPolicy: 'no-referrer', // no-referrer, *no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
      body: '' // ArrayBuffer, ArrayBufferView, Blob/File, string, URLSearchParams, FormData
      // body data type must match "Content-Type" header
    };
  }

  set setCallback(callback) {
    this.callback = callback;
  }

  set setMethod(method) {
    if (method == 'GET' || method == 'POST') {
      this.fetchInit['method'] = method;
    } else {
      this.fetchInit['method'] = 'GET';
    }
  }

  set setData(data) {
    if (data instanceof URLSearchParams) {
      this.fetchInit['headers']['Content-Type'] = "application/x-www-form-urlencoded";
    } else {
      delete this.fetchInit['headers']['Content-Type'];
    }
    this.fetchInit['body'] = data;
  }

  async fetchServer() {
    let response;
    try {
      response = await fetch(this.url, this.fetchInit);

      if (!response.ok) {
        throw new Error(response.status);
      } else {
        response = await response.json(); //text();
      }

    } catch (error) {
      response = error;
    }

    if (typeof this.callback === "function") {
      this.callback(response); // call callback function to handel the response
    } else {
      // console.log("Callback not found!\n");
      return response;
    }
  }

}


class FormHandler {
  constructor(form_id, status_id, url) {
    this.form = document.getElementById(form_id);
    this.form.addEventListener('submit', this.submitForm.bind(this));
    this.status_field = document.getElementById(status_id);

    this.serverReq = new ServerCall(url);

    this.callback = null;
    this.valid;
    this.files;
    this.error_msg;
  }

  setCallback(callback) {
    this.callback = callback;
  }

  submitForm(event) {
    event.preventDefault();
    const form_fields = event.target.elements;
    // console.log(form_fields);

    this.formData = new FormData();
    // this.error_msg = "";
    this.status_field.textContent = "";
    this.valid = true;
    this.files = false;

    this.status_field.classList.remove("invalid");

    for (let i = 0; i < form_fields.length; i++) {
      // console.log(formElem[i]);
      let key = form_fields[i].getAttribute("id");
      console.log(key);
      if (!(key == null)) {
        // validate using html5 inbuilt validations 
        // if (this.validateField(form_fields[i])) {
        form_fields[i].classList.remove("invalid");

        if (form_fields[i].getAttribute("type") == "file") {
          // console.log("file found");

          for (let j = 0; j < form_fields[i].files.length; j++) {
            this.formData.append(key + "[]", form_fields[i].files[j]);

            // if (this.imageValidate(this.form_fields[i].files[j])) { // validate images
            //   this.formData.append(key, this.form_fields[i].files[j]); // append to FormData
            // } else {
            //   // this.valid = false;     
            //   this.form_fields[i].classList.add("invalid");
            //   break;
            // }
          }
          // this.files = this.formData.has("0");
        } else {
          this.formData.append(key, form_fields[i].value);
        }
        // }
      }
    }


    if (this.valid) {
      this.sendData();
    } else {
      this.status_field.classList.add("invalid");
      // this.status_field.textContent = this.error_msg;
    }
  }

  async sendData() {
    this.serverReq.setData = this.formData;
    let serverRes = await this.serverReq.fetchServer();
    // console.log(serverRes);
    if (serverRes["state"] == "success") {
      for (let id in serverRes["frm_msg"]) {
        const pElem = document.createElement("p");
        pElem.textContent = serverRes["frm_msg"][id];
        this.status_field.appendChild(pElem);
      }
      await setClassTimeout(this.status_field, "success", 2500);
      this.form.reset();

      if (typeof this.callback === "function") {
        this.callback();
      }
    } else {
      this.status_field.classList.add("invalid");
      for (let id in serverRes["frm_msg"]) {
        console.log(serverRes["frm_msg"][id]);
        const pElem = document.createElement("p");
        pElem.textContent = serverRes["frm_msg"][id];
        this.status_field.appendChild(pElem);
        document.getElementById(id).classList.add("invalid");
        // let field = document.getElementById(id).classList.add("invalid");
        // if (field !== null) {
        //   field.classList.add("invalid");
        // }
      }
    }
  }

  /*
    async sendData() {
      this.serverReq.setData = this.formData;
      let serverRes = await this.serverReq.fetchServer();
      // console.log(serverRes);
      if (serverRes["state"] == "success") {
        // this.status_field.classList.add("success");
        this.error_msg += serverRes["msg"]["frm_status"];
        // setTimeout(function () {
        //   this.status_field.classList.remove("success");
        // }, 6000);
        setClassTimeout(this.status_field, "success", 4000);
      } else {
        this.status_field.classList.add("invalid");
        for (let id in serverRes["msg"]) {
          console.log(serverRes["msg"][id]);
          this.error_msg += serverRes["msg"][id] + "\n";
          document.getElementById(id).classList.add("invalid");
          // let field = document.getElementById(id).classList.add("invalid");
          // if (field !== null) {
          //   field.classList.add("invalid");
          // }
        }
      }
      this.status_field.textContent = this.error_msg;
    }
  */

  /*
  async sendData() {
    if (this.files) {
      this.serverReq.setData = this.formData;
      let serverRes1 = await this.serverReq.fetchServer();
      console.log(serverRes1);
      if (serverRes1.state == 'success') {

        this.serverReq.setData = this.searchParam;
        let serverRes2 = await this.serverReq.fetchServer();
        console.log(serverRes2);
        if (serverRes2.state == 'success') {
          this.status_field.classList.add("success");
        } else {
          this.status_field.classList.add("invalid");
        }
        for (let msg of serverRes2.msg) {
          this.error_msg += msg + "\n";
        }
      } else {
        this.status_field.textContent = serverRes1.msg;
        this.status_field.classList.add("invalid");
      }
    } else {
      this.serverReq.setData = this.searchParam;
      let serverRes2 = await this.serverReq.fetchServer();
      console.log(serverRes2);
      this.showResponse(serverRes2);
      // let ids = Object.keys(serverRes2.msg);
      // console.log(ids);
      // for (let id of ids) {
      //   document.getElementById(id).classList.add("invalid");
      // }
      // if (serverRes2.state == 'success') {
      //   this.status_field.classList.add("success");
      // } else {
      //   this.status_field.classList.add("invalid");
      // }
      // this.status_field.textContent = Object.values(serverRes2.msg).toString().replaceAll(",", "\n");
    }
  }
*/
  /*
    showResponse(response) {
      this.error_msg = "";
      if (response.state == 'success') {
        this.status_field.classList.add("success");
      } else {
        this.status_field.classList.add("invalid");
        let ids = Object.keys(response.msg);
        let errors = Object.values(response.msg);
        for (let k in ids) {
          document.getElementById(ids[k]).classList.add("invalid");
          this.error_msg += errors[k] + "\n";
          // console.log(errors[k]);
        }
      }
      this.status_field.textContent = this.error_msg;
      // for (let k = 0; k < response.msg.length; k++) {
      //   console.log(response.msg[k]);
      // }
    }
  */

  validateField(form_field) {
    // const field_name = form_field.previousElementSibling.textContent; // get label name
    // const field_name = form_field.getAttribute("name");
    // console.log(fieldName);
    if (!form_field.validity.valid) {
      console.log("NOT valid");
      const field_name = form_field.dataset.name;
      // this.error_msg += field_name;
      const pElem = document.createElement("p");

      if (form_field.validity.valueMissing) {
        // There must be a value (with a required attribute).
        // this.error_msg += ": Field is empty";
        pElem.textContent = field_name + ": Field is empty";

      } else if (form_field.validity.typeMismatch) {
        // The value must be compatible with attribute type.
        // this.error_msg += ": Type of the value is not matched";
        pElem.textContent = field_name + ": Type of the value is not matched";

      } else if (form_field.validity.tooShort) {
        // The number of characters must not be less than the value of the attribute minlength.
        // this.error_msg += ": Character length is too short";
        pElem.textContent = field_name + ": Character length is too short";

      } else if (form_field.validity.tooLong) {
        // The number of characters must not exceed the value of the attribute maxlength. 
        // this.error_msg += ": Character length is too long";
        pElem.textContent = field_name + ": Character length is too long";

      } else if (form_field.validity.patternMismatch) {
        // The value must be match with specified RegEx in attribute pattern
        // this.error_msg += ": Pattern of the value is not matched";
        pElem.textContent = field_name + ": Pattern of the value is not matched";

      } else if (form_field.validity.rangeUnderflow) {
        // The value must be greater than or equal to the value of attribute min.
        // this.error_msg += ": Value is under ranged";
        pElem.textContent = field_name + ": Value is under ranged";

      } else if (form_field.validity.rangeOverflow) {
        // The value must be less than or equal to the value of attribute max.
        // this.error_msg += ": Value is over ranged";
        pElem.textContent = field_name + ": Value is over ranged";

      }
      // this.error_msg += "\n";
      this.status_field.appendChild(pElem);
      form_field.classList.add("invalid");
      this.valid = false;
      return false;
    } else {
      form_field.classList.remove("invalid");
      return true;
    }
  }

  imageValidate(imgFile) {
    if (!imgFile.type.startsWith('image/')) {
      // validate image type
      // this.error_msg += previousElementSibling.textContent + ": Unsupported file format found"; // append error with label
      this.error_msg += "Image: Unsupported file format found\n";
      return false;
    } else if (imgFile.size > 1024 * 1024) {
      // validate max file size
      this.error_msg += "Image: Maximum file size is 1 MB\n";
      return false;
    } else {
      return true;
    }
  }

  resetForm() {
    this.form.reset();
    this.status_field.classList.remove("invalid");
    if (this.formData) {
      for (let key of this.formData.keys()) {
        document.getElementById(key).classList.remove("invalid");
      }
    }
  }
}

class DataList {
  constructor(url, callback) {
    this.serverReq = new ServerCall(url);

    this.callback = callback;

    this.page = 1;
    this.pageTot = 1;
    this.search = "";
    this.lastHeader = 1;
    this.header = 1; // table column number
    this.order = 0; // 0 = ASC, 1 = DESC
    // this.headerTot = 0;

    this.requestData(1, this.page, this.header, this.order, '');
  }

  setControls(prevbtn_id, nextbtn_id) {
    this.prevBtn = document.getElementById(prevbtn_id);
    this.prevBtn.addEventListener('click', this.prevDataset.bind(this));

    this.nextBtn = document.getElementById(nextbtn_id);
    this.nextBtn.addEventListener('click', this.nextDataset.bind(this));
  }

  setDetail(detailbox_id) {
    this.detailBox = document.getElementById(detailbox_id);
  }

  setSortHeader(...restParam) {
    // console.log(arguments.length, restParam.length, restParam);
    // this.headerTot = restParam.length;
    for (let ind = 0; ind < restParam.length; ind++) {
      document.getElementById(restParam[ind]).addEventListener('click', this.sortData.bind(this, ind));
    }
  }

  setSearch(searchinp_id, searchbtn_id) {
    this.searchInp = document.getElementById(searchinp_id);
    this.searchBtn = document.getElementById(searchbtn_id);
    this.searchBtn.addEventListener('click', this.searchData.bind(this));
  }

  async requestData(newQuery, pageNum, sortCol, sortType, searchVal) {
    const searchParams = new URLSearchParams();
    searchParams.append('page_num', pageNum);
    searchParams.append('sort_col', sortCol);
    searchParams.append('sort_type', sortType);
    searchParams.append('search_new', newQuery);
    searchParams.append('search_val', searchVal);

    // for (var pair of searchParams.entries()) {
    //   console.log(pair[0] + ', ' + pair[1]);
    // }

    this.serverReq.setData = searchParams;
    let serverRes = await this.serverReq.fetchServer();
    if (!!serverRes['page_tot']) { // or user Boolean(str)
      this.pageTot = serverRes['page_tot'];
    }
    this.changeControls();
    this.callback(serverRes['tbl_data']);

    // for(let i in serverRes['tbl_data']){
    //   const tblRow = document.createElement("div");
    //   tblRow.classList.add("tr");

    // }
  }

  searchData() {
    if (this.searchInp.validity.tooShort) {
      console.log('Character length is too short');
      this.searchInp.setCustomValidity('Character length is too short');
    } else {
      this.searchInp.setCustomValidity('');
      this.search = this.searchInp.value.toLowerCase();
      this.page = 1;
      this.header = 1;
      this.order = 0;
      this.requestData(1, this.page, this.header, this.order, this.search);
    }
  }

  sortData(colHead) {
    this.header = colHead + 1;
    // this.header = parseInt(col_head) + 1;
    // console.log(this.header);
    this.page = 1;
    if (this.header == this.lastHeader) { // check  for last active header
      if (this.order == 0) { // then toggle order state
        this.order = 1;
      } else {
        this.order = 0;
      }
      // console.log(header + " " + order);
      this.requestData(0, this.page, this.header, this.order, this.search);
    } else { // otherwise order state is ascending
      this.order = 0;
      // console.log(header + " " + order);
      this.requestData(0, this.page, this.header, this.order, this.search);
      this.lastHeader = this.header;
    }
  }

  prevDataset() {
    this.page = this.page - 1;
    console.log(this.page, this.header, this.order);
    this.requestData(0, this.page, this.header, this.order, this.search);
  }

  nextDataset() {
    this.page = this.page + 1;
    console.log(this.page, this.header, this.order);
    this.requestData(0, this.page, this.header, this.order, this.search);
  }

  changeControls() {
    if (this.page >= this.pageTot) {
      this.nextBtn.disabled = true;
    } else {
      this.nextBtn.disabled = false;
    }

    if (this.page <= 1) {
      this.prevBtn.disabled = true;
    } else {
      this.prevBtn.disabled = false;
    }

    this.detailBox.textContent = 'Page ' + this.page + ' of ' + this.pageTot;
  }

  refreshData() {
    this.page = 1;
    this.header = 1;
    this.order = 0;
    this.requestData(1, this.page, this.header, this.order, '');
  }
}