class ServerCall {

  constructor(url, callback = null, errField = null) {
    this.url = url;
    this.callback = callback;

    if (errField instanceof Element) {
      this.errField = errField;
    } else if (typeof errField == 'string') {
      this.errField = document.getElementById(errField);
    } else {
      this.errField = null;
    }

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
      body: "" // ArrayBuffer, ArrayBufferView, Blob/File, string, URLSearchParams, FormData
      // body data type must match "Content-Type" header
    };
  }

  // set callbackfunc(callback) {
  //   this.callback = callback;
  // }

  set data(data) {
    if (data instanceof URLSearchParams) {
      this.fetchInit['headers']['Content-Type'] = "application/x-www-form-urlencoded";
    } else {
      delete this.fetchInit['headers']['Content-Type'];
    }
    // this.fetchInit['headers']['Content-Type'] = "application/json";
    // this.fetchInit['headers']['Content-Type'] = "application/x-www-form-urlencoded";
    this.fetchInit['body'] = data;
  }

  fetchServer() {
    const self = this;
    // console.log(self.fetchInit);
    fetch(self.url, self.fetchInit)
      .then(function (response) {
        if (!response.ok) { // check that status is in the range 200-299 (Network failure)
          throw new Error(response.status); // throw error with status code
        }
        return response.text(); // if the response is valied, parse the response to text/json/blob/arrayBuffer/formData
      })
      .then(function (result) {
        if (typeof self.callback === "function") {
          self.callback(result); // call callback function to handel the response
        } else {
          console.log("Callback not found!\n");
          console.log(result);
        }
      })
      .catch(function (error) { // catch errors
        // console.log(this);
        if (self.errField) {
          self.errField.textContent = error;
          self.errField.classList.add("invalid");
        } else {
          console.log("Fetch " + error);
        }
      });
    self.fetchInit['body'] = ""; // clear post data
  }

}

class FormsApi extends ServerCall {
  constructor(url, callback, status_id) {
    super(url, callback, status_id);

    this.status_field = document.getElementById(status_id);

    this.searchParam = new URLSearchParams();
    this.valid;
    this.files;
    this.error_msg;
  }

  // setForm(form_id) {
  //   this.form_elem = document.getElementById(form_id);
  // }

  // setStatusField(status_id) {
  //   this.status_field = document.getElementById(status_id);
  // }

  submitForm(event) {
    event.preventDefault();
    this.form_fields = event.target.elements;
    console.log(this.form_fields);

    this.error_msg = "";
    this.valid = true;
    this.files = false;

    this.status_field.classList.remove("invalid");

    for (let i = 0; i < this.form_fields.length; i++) {
      // console.log(formElem[i]);
      // console.log(formElem[i].getAttribute("type"));
      let key = this.form_fields[i].getAttribute("id");
      console.log(key);
      if (!(key == null)) {
        // validate using html5 inbuilt validations 
        if (this.formFieldValidate(this.form_fields[i])) { //if valied use custom validations
          // check for files and append them to FormData, others append to SearchParams
          if (this.form_fields[i].getAttribute("type") == "file") {
            console.log("file found");
            this.files = true;
            this.formData = new FormData();
            this.form_fields[i].classList.remove("invalid");

            for (let j = 0; j < this.form_fields[i].files.length; j++) {
              if (this.imageValidate(this.form_fields[i].files[j])) { // validate images
                this.formData.append(key, this.form_fields[i].files[j]); // append to FormData
              } else {
                this.valid = false;
                this.form_fields[i].classList.add("invalid");
                break;
              }
            }

          } else {
            this.searchParam.append(key, this.form_fields[i].value); // append to SearchParams
          }
        }
      }
    }
    this.status_field.textContent = this.error_msg;

    if (this.valid) {
      super.data = this.searchParam;
      super.fetchServer();
      if (this.files) {
        super.data = this.formData;
        super.fetchServer();
      }
    } else {
      this.status_field.classList.add("invalid");
    }
  }

  formFieldValidate(form_field) {
    // const field_name = form_field.previousElementSibling.textContent; // get label name
    const field_name = form_field.getAttribute("name");
    // console.log(fieldName);
    if (!form_field.validity.valid) {
      console.log("NOT valid");
      this.error_msg += field_name;

      if (form_field.validity.valueMissing) {
        // There must be a value (with a required attribute).
        this.error_msg += ": Field is empty";

      } else if (form_field.validity.typeMismatch) {
        // The value must be compatible with attribute type.
        this.error_msg += ": Type of the value is not matched";

      } else if (form_field.validity.tooShort) {
        // The number of characters must not be less than the value of the attribute minlength.
        this.error_msg += ": Character length is too short";

      } else if (form_field.validity.tooLong) {
        // The number of characters must not exceed the value of the attribute maxlength. 
        this.error_msg += ": Character length is too long";

      } else if (form_field.validity.patternMismatch) {
        // The value must be match with specified RegEx in attribute pattern
        this.error_msg += ": Pattern of the value is not matched";

      } else if (form_field.validity.rangeUnderflow) {
        // The value must be greater than or equal to the value of attribute min.
        this.error_msg += ": Value is under ranged";

      } else if (form_field.validity.rangeOverflow) {
        // The value must be less than or equal to the value of attribute max.
        this.error_msg += ": Value is over ranged";

      }
      this.error_msg += "\n";
      this.valid = false;
      form_field.classList.add("invalid");
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

  formCallback(result) {
    console.log('Form Callback');
    console.log(result);
  }
}

class DataList extends ServerCall {
  constructor(url, callback) {
    super(url, callback);
    // super.callback = this.displayData;

    // const data_list = document.getElementById(data_list_id);
    // const dltop = data_list.getElementsByClassName('dlist_top')[0];
    // const dlbot = data_list.getElementsByClassName('dlist_bot')[0];
    // this.tbl_result = data_list.getElementsByClassName('tbody')[0];
    // this.spn_detail = dltop.getElementsByTagName('span')[0];
    // this.inp_search = dltop.getElementsByTagName('input')[0];
    // this.btn_control = dlbot.getElementsByTagName('button');

    // this.page_tot = 1;
    this.page = 1;
    this.search = "";
    this.last_header = 1;
    this.header = 1; // table column number
    this.order = 0; // 0 = ASC, 1 = DESC    
  }

  // setresultTable(tablebody_id) {
  //   this.tbl_result = document.getElementById(tablebody_id);
  // }

  setDetail(detail_id) {
    this.detail_elem = document.getElementById(detail_id);
  }

  setSearch(search_id) {
    this.search_elem = document.getElementById(search_id);
  }

  setControls(prev_id, next_id) {
    this.prev_elem = document.getElementById(prev_id);
    this.next_elem = document.getElementById(next_id);
  }

  requestData(new_query, page_num, sort_col, sort_type, search_val) {
    const usParam = new URLSearchParams();
    usParam.append("new", new_query);
    usParam.append("page_num", page_num);
    usParam.append("sort_col", sort_col);
    usParam.append("sort_type", sort_type);
    usParam.append("search_val", search_val);

    super.data = usParam;
    super.fetchServer();

    // this.changeControls();
  }

  searchData() {
    this.search = this.search_elem.value.toLowerCase();
    if (this.search.length < 2) {
      console.log("Please make sure your search query is more then 2 characters");
    }
    this.page = 1;
    this.request_page(1, this.page, this.header, this.order, this.search);
  }

  sortData(col_head) {
    this.header = col_head;
    // console.log(header);
    this.page = 1;
    if (this.header == this.last_header) { // check  for last active header
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
      this.last_header = this.header;
    }
  }

  nextDataset() {
    this.page = this.page + 1;
    console.log(this.page + " " + this.header + " " + this.order);
    this.requestData(0, this.page, this.header, this.order, this.search);
  }

  prevDataset() {
    this.page = this.page - 1;
    console.log(this.page + " " + this.header + " " + this.order);
    this.requestData(0, this.page, this.header, this.order, this.search);
  }

  // changeControls() {
  //   if (this.page >= this.page_tot) {
  //     this.next_elem.disabled = true;
  //   } else {
  //     this.next_elem.disabled = false;
  //   }

  //   if (this.page <= 1) {
  //     this.prev_elem.disabled = true;
  //   } else {
  //     this.prev_elem.disabled = false;
  //   }
  // }
}