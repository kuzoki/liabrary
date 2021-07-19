<template>
  <div>
    <div class="row">
      <div class="col-3">
        <div class="sidebar">
          <!-- Side Bar Form -->
          <div class="sidebar-widget">
            <div>
              <h1 class="name">
                Welcome Back <span v-if="user"> {{ user.name }} </span>
              </h1>
            </div>
            <h2 class="sec-title">Add a new book</h2>
            <form
              class="add-book-form"
              id="add-book-form"
              @submit.prevent="addBook"
              required
            >
              <input
                type="text"
                id="title"
                placeholder="Title"
                name="title"
                v-model="booksVue.book_name"
                required
              />
              <input
                type="text"
                id="author"
                placeholder="Author"
                name="author"
                v-model="booksVue.book_author"
                required
              />
              <input
                type="number"
                id="pages"
                placeholder="Number of Pages"
                name="pages"
                v-model="booksVue.book_page_number"
                required
              />
              <div class="d-flex flex-row time">
                <input
                  type="number"
                  name="hours"
                  placeholder="Houres"
                  v-model="booksVue.book_hours"
                />
                <input
                  type="number"
                  name="minuts"
                  placeholder="Minutes"
                  max="60"
                  min="0"
                  v-model="booksVue.book_minutes"
                />
                <input
                  type="text"
                  name="Category"
                  placeholder="Category"
                  v-model="booksVue.book_category"
                />
              </div>
              <select
                name="read"
                id="read"
                v-model="booksVue.book_read"
                required
              >
                <option :value="null" disabled selected>
                  Have you read it?
                </option>
                <option :value="true">Yes</option>
                <option :value="false">No</option>
              </select>
              <!-- <input type="submit" value="New Book" class="btn btn-submit" id="submit"/> -->
              <button type="submit" class="btn btn-submit" id="submit">
                New Book
              </button>
            </form>
          </div>

          <!-- Data Analytics -->
          <div class="sidebar-widget widget-library-log mt-4">
            <h2 class="sec-title">Library log</h2>
            <div class="library-log">
              <div class="library-log--single">
                <img src="/uploads/book-mark.svg" alt="books icon" />
                <h4>
                  Total books : <span>{{ allBooks.length }}</span>
                </h4>
              </div>
              <div class="library-log--single">
                <img src="/uploads/check.svg" alt="books icon" />
                <h4>
                  Books read : <span>{{ numberRead }}</span>
                </h4>
              </div>

              <div class="library-log--single">
                <img src="/uploads/check.svg" alt="books icon" />
                <h4>
                  Total Pages Readed :
                  <span>
                    {{ totalpageRead }}
                  </span>
                </h4>
              </div>
              <div class="library-log--single">
                <img src="/uploads/x.svg" alt="books icon" />
                <h4>
                  Books not read :
                  <span>{{ allBooks.length - numberRead }} </span>
                </h4>
              </div>
            </div>
          </div>
          <div class="sidebar-widget widget-library-log mt-4">
            <button class="btn btn-primary" @click="showAnlytic = !showAnlytic">
              View My Stats
            </button>
          </div>
        </div>
      </div>

      <!-- View Page -->
      <div class="col-9 p-5 position-relative">
        <div class="navi mb-5">
          <button @click.prevent="logout" class="logout">Logout</button>
          <div class="filter-btns">
            <button class="btn btn-primary" @click.prevent="readNotread(null)">
              All
            </button>
            <button class="btn btn-primary" @click.prevent="readNotread(true)">
              Readed
            </button>
            <button class="btn btn-primary" @click.prevent="readNotread(false)">
              Not Read
            </button>
          </div>
        </div>

        <div class="book-list">
          <h1 class="sec-title">My Books</h1>
          <div class="grid row" id="books-list-grid">
            <div
              class="col col-4 col-lg"
              v-for="(item, index) in allBooks"
              :key="index"
            >
              <div class="book-card">
                <h4 class="title">{{ item.book_name }}</h4>
                <!-- <p class="pages my-4" style="color: #313a46">
                  To do After Lorem ipsum dolor sit, amet consectetur
                  adipisicing elit. Repellat ullam numquam animi aliquid harum
                  error, illum laudantium id? Deserunt enim officia illum
                  asperiores
                </p> -->
                <p class="author">Author : {{ item.book_author }}</p>
                <p class="author">Category : {{ item.book_category }}</p>
                <p class="author">
                  Time Of read : {{ item.book_hours }}h /
                  {{ item.book_minutes }}minutes
                </p>

                <p class="pages">
                  Number Of Pages : {{ item.book_page_number }}
                </p>
                <p class="status status--read" v-if="item.book_read">
                  <span style="color: #98a6ad">State : </span> I Have alredy
                  Read This Book
                </p>
                <p class="status status--notread" v-else>
                  <span style="color: #98a6ad">State :</span> Planing To Read
                  this Book
                </p>
                <button
                  class="btn btn-edit"
                  id="btn-edit"
                  @click="editPass(item, index, item.id)"
                >
                  Edit
                </button>
                <button
                  class="btn btn-delete"
                  @click.prevent="pass(index, item.book_name, item.id)"
                >
                  Delete
                </button>
              </div>
            </div>
          </div>
        </div>
        <!-- Delet confirmation -->
        <div class="Delete p-5" v-if="showCinfirmationDelet">
          <span @click.prevent="showCinfirmationDelet = false" class="close"
            >X</span
          >
          <h2>Are You Sure You want To delete</h2>
          <p>{{ titletodelet }} Book</p>

          <button
            class="btn confirm-delete mx-auto d-block"
            @click.prevent="deletBook()"
          >
            permanent delete
          </button>
        </div>
        <!-- Pop Up Edit -->
        <div class="popup" id="popup" v-if="showEditPop">
          <div class="popup-overlay"></div>
          <div class="popup-content">
            <div class="popup-close" @click="showEditPop = !showEditPop">
              &times;
            </div>
            <h3 class="popup-title mb-5">
              <strong>Book :</strong> {{ edit_name }}
            </h3>
            <form
              class="add-book-form"
              id="add-book-form"
              @submit.prevent="editBook(editIndex, editId)"
            >
              <input
                type="text"
                id="title"
                placeholder="Title"
                name="title"
                required
                v-model="edit_name"
              />
              <input
                type="text"
                id="author"
                placeholder="Author"
                name="author"
                required
                v-model="edit_author"
              />
              <input
                type="number"
                id="pages"
                placeholder="Number of Pages"
                name="pages"
                required
                v-model="edit_page_number"
              />
              <div class="d-flex flex-row time">
                <input
                  type="number"
                  name="hours"
                  placeholder="Houres"
                  v-model="edit_hours"
                />
                <input
                  type="number"
                  name="minuts"
                  placeholder="Minutes"
                  max="60"
                  min="0"
                  v-model="edit_minutes"
                />
                <input
                  type="text"
                  name="Category"
                  placeholder="Category"
                  v-model="edit_category"
                />
              </div>
              <select name="read" id="read" v-model="edit_read" required>
                <option :value="null" disabled selected>
                  Have you read it?
                </option>
                <option :value="1">Yes</option>
                <option :value="0">No</option>
              </select>
              <!-- <input type="submit" value="New Book" class="btn btn-submit" id="submit"/> -->
              <button type="submit" class="btn btn-submit" id="submit">
                Save
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- Anaytic Page -->
    <div v-if="showAnlytic">
      <analytic @closeAnalytice="showAnlytic = !showAnlytic"></analytic>
    </div>
  </div>
</template>
<script>
import axios from "axios";
import analytic from "./analytic";

export default {
  components: { analytic },
  data() {
    return {
      user: null,

      booksVue: {
        book_name: "",
        book_author: "",
        book_page_number: null,
        book_read: null,
        unique_delete_id: null,
        book_hours: null,
        book_minutes: null,
        book_category: "",
      },
      // show Anlytic
      showAnlytic: false,
      // Array That Always Hold Info
      allBooks: [],
      numberRead: 0,
      totalpageRead: 0,

      // Pop Up Dynamic Data
      showCinfirmationDelet: false,
      titletodelet: "",

      //Deletition data first for vue sconed fo database
      indexDelet: null,
      bookTodelet: null,

      // Edit Show Block
      showEditPop: false,
      editIndex: null,
      editId: null,

      // Edit Popup Used Data
      edit_name: "",
      edit_author: "",
      edit_page_number: null,
      edit_read: null,
      edit_hours: null,
      edit_minutes: null,
      edit_category: "",
    };
  },
  mounted() {
    axios
      .get("/api/user")
      .then((res) => {
        this.user = res.data;
        this.getBooks();
      })
      .catch((error) => {
        console.log(error);
      });
  },

  methods: {
    // Filter Buttons Methods
    readNotread(state) {
      if (state !== null) {
        this.allBooks = this.allBooks.filter((el) => {
          return el.book_read == state;
        });
        this.fillterRead();
      } else {
        this.getBooks();
      }
    },

    // methode To creat calculate the books that are readed
    fillterRead() {
      let newarray = this.allBooks.filter(function (ell) {
        //console.log(ell.read);
        return ell.book_read == true;
      });
      this.numberRead = newarray.length;

      this.totalpageRead = 0;
      for (let i = 0; i < newarray.length; i++) {
        this.totalpageRead += parseInt(newarray[i].book_page_number);
        // console.log(typeof newarray[i].book_page_number);
      }
    },

    // Get All Booke By User
    getBooks() {
      //console.log(this.user.id);
      axios
        .get("/api/book/show/" + this.user.id)
        .then((res) => {
          //console.log(res.data);

          if (res.data !== "no book") {
            this.allBooks = res.data;
            this.fillterRead();
          }
        })
        .catch((err) => {
          console.log(err);
        });
    },

    //push To Array
    addBook() {
      let newBook = {
        book_name: this.booksVue.book_name,
        book_author: this.booksVue.book_author,
        book_page_number: this.booksVue.book_page_number,
        book_read: this.booksVue.book_read,
        book_hours: this.booksVue.book_hours,
        book_minutes: this.booksVue.book_minutes,
        book_category: this.booksVue.book_category,
        user_name: this.user.name,
        user_email: this.user.email,
        user_id: this.user.id,
      };

      //***  push to data base
      axios
        .post("/api/book/store", newBook)
        .then((res) => {
          //console.log(res.data);

          if (res.data) {
            let newBookaxios = {
              book_name: res.data.book_name,
              book_author: res.data.book_author,
              book_page_number: res.data.book_page_number,
              book_read: res.data.book_read,
              book_category: res.data.book_category,
              book_hours: res.data.book_hours,
              book_minutes: res.data.book_minutes,
              user_name: res.data.user_name,
              user_email: res.data.email,
              user_id: res.data.user_id,
              id: res.data.id,
            };

            this.allBooks.push(newBookaxios);
            //console.log(this.allBooks);
            this.fillterRead();
          }
        })
        .catch((error) => {
          console.log(error);
        });

      this.booksVue.book_name = "";
      this.booksVue.book_author = "";
      this.booksVue.book_page_number = null;
      this.booksVue.book_read = null;
    },
    // Edit Book
    editPass(el, index, id) {
      //pass Index Delet for vue and id for mysql

      this.editIndex = index;
      this.editId = id;

      // show pop up
      this.showEditPop = !this.showEditPop;

      // pass alredy exist data to from card to edits popup

      this.edit_name = el.book_name;
      this.edit_author = el.book_author;
      this.edit_page_number = el.book_page_number;
      this.edit_read = el.book_read;
      this.edit_hours = el.book_hours;
      this.edit_minutes = el.book_minutes;
      this.edit_category = el.book_category;
    },

    editBook(index, id) {
      //assing new data for vue so we will not refresh

      this.allBooks[index].book_name = this.edit_name;
      this.allBooks[index].book_author = this.edit_author;
      this.allBooks[index].book_page_number = this.edit_page_number;
      this.allBooks[index].book_read = this.edit_read;
      this.allBooks[index].book_hours = this.edit_hours;
      this.allBooks[index].book_minutes = this.edit_minutes;
      this.allBooks[index].book_category = this.edit_category;

      let data = {
        book_name: this.edit_name,
        book_author: this.edit_author,
        book_page_number: this.edit_page_number,
        book_read: this.edit_read,
        book_hours: this.edit_hours,
        book_minutes: this.edit_minutes,
        book_category: this.edit_category,
      };

      axios
        .put("/api/book/update/" + id, data)
        .then((res) => {
          if (res.status == 200) {
            console.log("Updated");
          }
        })
        .catch((err) => {
          console.log(err);
        });

      this.fillterRead();
      // close popup
      this.showEditPop = !this.showEditPop;
    },
    // ****** delete Books

    pass(e, t, d) {
      this.indexDelet = e;
      this.titletodelet = t;
      this.bookTodelet = d;
      this.showCinfirmationDelet = true;
    },

    deletBook() {
      this.allBooks.splice(this.indexDelet, 1);
      this.showCinfirmationDelet = false;
      this.fillterRead();
      axios
        .delete("api/book/delete/" + this.bookTodelet)
        .then((res) => {
          //console.log(res);
          alert("Item Was Deleted");
        })
        .catch((err) => {
          console.log(err);
        });
    },

    // Log Out Methods
    logout() {
      axios.post("/api/user/logout").then((res) => {
        localStorage.setItem("logstate", "loggedOut");
        this.$router.push("/");
      });
    },
  },
};
</script>


<style scoped>
.time input {
  margin: 0 5px 20px 0;
  width: 33.33%;
}
.time input:last-of-type {
  margin-right: 0;
}
.close {
  position: absolute;
  top: 5px;
  right: 10px;
  color: red;
  font-size: 18px;
  font-weight: bold;
  cursor: pointer;
}
.Delete {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  background-color: #fff;
  padding: 30px;
  z-index: 2;
  box-shadow: 1px 0px 10px 2px rgba(199, 199, 199, 0.7);
}
.Delete p {
  text-align: center;
  font-weight: bold;
  text-transform: capitalize;
}
.name {
  font-weight: bold;
  color: white;
  text-transform: uppercase;
  font-size: 24px;
  margin-bottom: 40px;
  background: #404853;
  padding: 20px;
  border-radius: 5px;
  letter-spacing: 1px;
  text-transform: capitalize;
}
.name span {
  color: #ea5a47;
}
.sidebar h2 {
  color: #fff;
}
.sidebar {
  background-color: #313a46;
  height: 100vh;
  padding: 50px 40px;
  margin-left: -12px;
  margin-right: -12px;
  position: relative;
}
.sec-title {
  font-size: 26px;
  line-height: 1.3em;
  margin-bottom: 20px;
  font-weight: 600;
}
input,
select {
  width: 100%;
  outline: none;
  height: 40px;
  padding-left: 15px;
  border: 1px solid transparent;
  margin-bottom: 20px;
  border-radius: 0;
  font-family: "Nunito Sans", sans-serif;
  font-size: 14px;
  color: #000;
  font-weight: 500;
}
button[type="submit"],
.logout {
  width: 100%;
  height: 46px;
  border: none;
  border-radius: 0;
  font-family: "Nunito Sans", sans-serif;
  font-size: 14px;
  color: #fff;
  font-weight: 600;
  background-color: #03b5e6;
  transition: 0.3s all;
}
.logout {
  width: 10%;
  position: absolute;
  top: 20px;
  right: 40px;
  background: tomato;
  background: linear-gradient(
    90deg,
    rgba(230, 31, 31, 1) 0%,
    rgba(253, 130, 29, 1) 50%,
    rgba(252, 139, 69, 1) 100%
  );

  box-shadow: 1px 0px 10px 2px rgba(199, 199, 199, 0.7);
}
.logout:hover {
  background: gray;
  transition: ease;
}
.library-log {
  background-color: #404853;
  padding: 20px;
  border-radius: 5px;
  text-align: left;
  color: #fff;
}
.library-log .library-log--single {
  display: flex;
  align-items: center;
}
.library-log .library-log--single h4 {
  font-weight: 500;
  line-height: 1.5em;
  text-transform: uppercase;
  font-size: 14px;
}
.library-log .library-log--single span {
  font-weight: 400;
  color: #03b5e6;
}
.library-log .library-log--single img {
  width: 32px;
  vertical-align: middle;
  margin-right: 10px;
}
.book-card {
  background: #fff;
  padding: 20px;
  border-radius: 5px;
  box-shadow: 1px 1px 50px 1px rgb(154 161 171 / 15%);
  margin-bottom: 24px;
  font-family: "Nunito Sans", sans-serif;
}
.book-card .title {
  color: #6c757d;
  font-size: 18px;
  line-height: 1.5em;
  margin-bottom: 0;
  font-weight: bold;
  text-transform: capitalize;
}
.book-card .author,
.book-card .pages,
.book-card .status {
  color: #98a6ad;
  font-size: 16px;
  line-height: 1.5em;
  margin-bottom: 0;
}
.book-card .status.status--read {
  color: #03b5e6;
}
.book-card .status.notread {
  color: gray;
}
.book-card .btn.btn-edit {
  background: url(/uploads/pen.svg) no-repeat;
  padding: 0 0 0 24px;
  color: #03b5e6;
}
.book-card .btn.btn-delete {
  color: #fa5c7c;
  margin-left: 10px;
  background: url(/uploads/delete.svg) no-repeat;
  padding: 0 0 0 24px;
}
.book-card .btn.btn-delete:hover,
.book-card .btn.btn-edit:hover {
  color: orangered;
}

.book-card .btn {
  margin-top: 10px;
  background: transparent;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 0;
  font-size: 14px;
  font-family: "Nunito Sans", sans-serif;
  font-weight: 600;
  color: #6c757d;
}
.confirm-delete {
  background: #fa5c7c;
  color: white;
  text-transform: capitalize;
  letter-spacing: 1px;
}
.confirm-delete:hover {
  background: gray;
}
.popup .popup-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  background-color: rgba(0, 0, 0, 0.7);
  z-index: 1;
}

.popup .popup-content {
  position: absolute;
  top: 50%;
  left: 40%;
  transform: translate(-50%, -50%);
  background-color: #fff;
  padding: 30px;
  z-index: 2;
  width: 60%;
}

.popup .popup-close {
  position: absolute;
  top: 12px;
  right: 12px;
  cursor: pointer;
  font-size: 26px;
  font-weight: bold;
  line-height: 0.5em;
  color: #98a6ad;
  transition: all 0.3s;
}
.popup .popup-close:hover {
  color: #000;
}

.popup.active .popup-overlay {
  display: block;
}

.popup.active .popup-content {
  transition: all 0.3s ease-in-out;
  transform: translate(-50%, -50%) scale(1);
}
.popup input,
.popup select {
  border: 0.5px solid #f1f7f9;
  box-shadow: 0px 0px 5px 0px rgb(214 214 214);
}
</style>