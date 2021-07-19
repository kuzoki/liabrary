<template>
  <div class="p-5 bg-pop">
    <div class="container-fluid">
      <div class="col-6 m-auto warp p-5 position-relative">
        <div class="close" @click="close">X</div>
        <h1 class="display-3 mb-5">Analityc</h1>
        <h3 class="display-6">The readed Book Data Analityc:</h3>

        <div class="row text-center">
          <div class="d-flex flex-column align-items-center col-3">
            <img src="/uploads/book.svg" alt="" />
            <p>
              Number of books readed :<br />
              <strong>{{ readBooks.length }}</strong>
            </p>
          </div>
          <div class="d-flex flex-column align-items-center col-3">
            <img src="/uploads/pages.svg" alt="" />
            <p>
              Number of Pages readed : <strong>{{ numberPageread }}</strong>
            </p>
          </div>
          <div class="d-flex flex-column align-items-center col-3">
            <img src="/uploads/clock.svg" alt="" />
            <p>
              Reading time in minuts : <br />
              <strong> {{ totalTimemin }} Minutes </strong>
            </p>
          </div>
          <div class="d-flex flex-column align-items-center col-3">
            <img src="/uploads/clock.svg" alt="" />
            <p>
              Reading time in hours : <br />
              <strong>
                {{ (totalTimemin - (totalTimemin % 60)) / 60 }} Hours /
                {{ totalTimemin % 60 }} Minutes
              </strong>
            </p>
          </div>
          <div class="d-flex flex-column align-items-center col-3 mt-5">
            <div class="single-chart">
              <svg viewBox="0 0 36 36" class="circular-chart orange">
                <path
                  class="circle-bg"
                  d="M18 2.0845
                    a 15.9155 15.9155 0 0 1 0 31.831
                    a 15.9155 15.9155 0 0 1 0 -31.831"
                />
                <path
                  class="circle"
                  :stroke-dasharray="calcpercentage()"
                  d="M18 2.0845
                    a 15.9155 15.9155 0 0 1 0 31.831
                    a 15.9155 15.9155 0 0 1 0 -31.831"
                />
                <text x="18" y="20.35" class="percentagetext">
                  {{ ((totalTimemin * 100) / 525600).toFixed(2) }} %
                </text>
              </svg>
            </div>
            You have spended over
            <strong>
              {{ ((totalTimemin * 100) / 525600).toFixed(2) }} % of a year in
              reading Books
            </strong>
          </div>
          <div class="text-left col-9 d-flex flex-column cate mt-5">
            All The Categorys You Have readed :<strong
              >You have {{ CategoryData.length }} type of categorys
            </strong>
            <br />
            <span
              v-for="(item, index) in CategoryData"
              :key="index"
              class="row"
            >
              <div class="col-3">
                <p>{{ item.category_name }} : {{ item.number }} Book(s)</p>
              </div>
              <div class="col-9">
                <div class="block">
                  <div
                    class="w-c"
                    :style="widthBlock(item.number, readBooks.length)"
                  ></div>
                </div>
              </div>
              <br />
            </span>
          </div>
        </div>
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
    this.calcpercentage();
  },

  methods: {
    calcpercentage() {
      let percen = ((this.totalTimemin * 100) / 525600).toFixed(2);
      return percen + ", 100";
    },
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
    // Close The Button
    close() {
      this.$emit("closeAnalytice");
    },
  },
};
</script>
<style scoped>
.bg-pop {
  background: rgba(0, 0, 0, 0.8);
  height: 100vh;
  width: 100%;
  /* overflow-y: scroll; */
  position: absolute;
  top: 0;
  z-index: 9;
}
.cate {
  text-align: left !important;
}
.flex-wrapper {
  display: flex;
  flex-flow: row nowrap;
}

.single-chart {
  width: 90%;
  justify-content: space-around;
}

.circular-chart {
  display: block;
  margin: 10px auto;
  max-width: 80%;
  max-height: 250px;
}

.circle-bg {
  fill: none;
  stroke: rgb(226, 226, 226);
  stroke-width: 3.8;
}
.circle {
  fill: none;
  stroke-width: 2.8;
  stroke-linecap: round;
  animation: progress 1s ease-out forwards;
}

@keyframes progress {
  0% {
    stroke-dasharray: 0 100;
  }
}

.circular-chart.orange .circle {
  stroke: #ff9f00;
}

.circular-chart.green .circle {
  stroke: #4cc790;
}

.circular-chart.blue .circle {
  stroke: #3c9ee5;
}

.percentagetext {
  fill: #666;
  font-family: sans-serif;
  font-size: 0.3em;
  text-anchor: middle;
}
img {
  width: 50px;
}
.close {
  position: absolute;
  top: 10px;
  right: 20px;
  font-weight: bold;
  cursor: pointer;
}
.warp {
  background: #eef2f7;
}

span {
  text-transform: capitalize;
}
.block {
  width: 100%;
  height: 20px;
  background: rgb(228, 228, 228);
}
.w-c {
  width: 50%;
  height: 20px;
  background: rgb(5, 191, 82);
}
</style>