<template>
  <div class="p-5">
    <div class="container-fluid">
      <h1 class="display-3 mb-5">Analityc</h1>
      <div class="row">
        <!-- Readed Book Data -->
        <div class="col-6">
          <h3 class="display-6">The readed Book Data Analityc:</h3>
          <ul>
            <li>Number of books readed : {{ readBooks.length }}</li>
            <li>Number of Pages readed : {{ numberPageread }}</li>
            <li>
              Number of books Hours : {{ totalTimemin }} Minutes =
              {{ (totalTimemin - (totalTimemin % 60)) / 60 }} Hours /
              {{ totalTimemin % 60 }} Minutes
            </li>
            <li>
              You spend {{ ((totalTimemin * 100) / 525600).toFixed(2) }} % of
              the year reading Books
            </li>
            <li>
              Category <br />
              <span v-for="(item, index) in CategoryData" :key="index">
                {{ item.category_name }} : {{ item.number }} Books
                <div class="block">
                  <div
                    class="w-c"
                    :style="widthBlock(item.number, readBooks.length)"
                  ></div>
                </div>
                <br />
              </span>
            </li>
          </ul>
        </div>
        <div class="col-6"></div>
      </div>
    </div>
  </div>
</template>
<script>
import axios from "axios";
export default {
  data() {
    return {
      allbooks: [],
      readBooks: [],
      numberPageread: null,
      totalTimemin: null,
      bookCategory: [],
      CategoryData: [],
    };
  },

  mounted() {
    axios
      .get("/api/user")
      .then((res) => {
        let userId = res.data.id;
        this.getBooks(userId);
      })
      .catch((error) => {
        console.log(error);
      });
    this.widthBlock();
  },

  methods: {
    widthBlock(x, a) {
      let per = (x * 100) / a;
      let resualt = "width:" + per + "%";
      return resualt;
    },
    getBooks(id) {
      axios
        .get("/api/book/show/" + id)
        .then((res) => {
          if (res.data !== "no book") {
            this.allbooks = res.data;
            this.filterBookRead(res.data);
          }
        })
        .catch((err) => {
          console.log(err);
        });
    },
    // methode To creat calculate the books that are readed
    filterBookRead(data) {
      this.readBooks = data.filter((el) => {
        return el.book_read == true;
      });
      let cat = [];
      // page Numbers + Time
      for (let i = 0; i < this.readBooks.length; i++) {
        this.numberPageread += parseInt(this.readBooks[i].book_page_number);
        this.totalTimemin += parseInt(
          this.readBooks[i].book_hours * 60 + this.readBooks[i].book_minutes
        );
        cat.push(this.readBooks[i].book_category);
      }
      //console.log(this.bookCategory);

      this.bookCategory = [
        ...new Map(cat.map((item) => [JSON.stringify(item), item])).values(),
      ];
      // console.log(this.bookCategory);

      for (let i = 0; i < this.bookCategory.length; i++) {
        //console.log(this.bookCategory[i]);
        let newCatdata = this.readBooks.filter((el) => {
          return el.book_category == this.bookCategory[i];
        });
        let datacat = {
          category_name: this.bookCategory[i],
          number: newCatdata.length,
        };
        this.CategoryData.push(datacat);
      }
    },
  },
};
</script>
<style scoped>
span {
  text-transform: capitalize;
}
.block {
  width: 100%;
  height: 10px;
  background: lightblue;
  border-radius: 20px;
}
.w-c {
  width: 50%;
  height: 10px;
  background: red;
  border-radius: 0 20px 20px 0;
}
</style>