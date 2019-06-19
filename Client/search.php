<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="searchstyle.css">
    <title>search box</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <style>
    
    @import url('https://fonts.googleapis.com/css?family=Quicksand|Rubik');
      .page {
        display: flex;
        justify-content: center;
        align-items: center;
      }
    input{
      background: transparent;
      border: none;
      font-size: 15px;
    }
    .symr,
    .syml{
      font-size: 50px;
      color: #2196f3;
      transition-duration: 0.5s;
      padding: 0px 4px;
    }
    .syml:hover{
      text-shadow: 5px 1px 5px #000000c2;
    }
    .symr:hover{
      text-shadow: -5px 1px 5px #000000c2;
    }
    .area{
      width: 100px;
      height:50px;
      font-size: 30px;
      text-align: center;
      margin-left: 20px;
      margin-right: 20px;
    }
    .loading {
      height: 400px;
      width: 100%;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    @keyframes spin {
      0% {
        transform: rotate(0deg);
      }
      100% {
        transform: rotate(360deg);
      }
    }
    .loader {
      height: 50px;
      width: 50px;
      border-radius: 50%;
      animation: spin 2s linear infinite;
      border: 8px solid #f3f3f3;
      border-top: 8px solid #3498db;
    }
    

section {
  width: 100%;
}

.books {
  width: 100%;
  display: flex;
  flex-direction: row;
  flex-wrap: wrap;
  justify-content: center;
  text-decoration: none !important;
}

.book-link {
  text-decoration: none;
  color: inherit;
}

.book-title {
  margin: 20px 30px;
}

.book {
  flex-flow: wrap;
  display: flex;
  width: 220px;
  margin: 20px 30px;
  flex-direction: column;
}

.author {
  font-size: 0.8em;
}

#search-item {
  position: relative;
}

@keyframes float {
  0% {
    top: -100px;
  }
  50% {
    top: -120px;
  }
  100% {
    top: -100px;
  }
}

#below-arrow {
  font-size: 2em;
  text-align: center;
  position: absolute;
  width: 100%;
  top: -100px;
  animation-name: float;
  animation-duration: 2s;
  animation-timing-function: ease-in-out;
  animation-iteration-count: infinite;
  color: #2196f3;
}

    </style>
  </head>
  <body>
    <?php include_once("./header.php")?>
    <!-- <div class="nav1">
      <ul>
        <li><a>Title</a></li>
        <li><a>Author</a></li>
      </ul>
    </div> -->
    <div class="box">
      <form action="./search.php" method="GET">
        <input type="text" id="searchtext"class="searchtext" name="q" placeholder="search here....">
        <input type="submit" class="searchbut" value="search">
      </form>
    </div>

    <div id="search-item">
      <i id="below-arrow" class="fas fa-angle-double-down"></i>
      <h1 style="margin-left: 100px;">Search Results</h1>
      <section>
          <div class="books">
            <div class="loading">
              <div class="loader"></div>
            </div>
          </div>
      </section>
    </div>

    <?php include_once('./footer.php'); ?>



    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
      const params = new window.URLSearchParams(window.location.search);
      const genre = params.get('q');
      if(genre) {
        $('#searchtext').val(genre);
        populateItems = () => {
          $.get(`http://localhost:5001/book/search?q=${genre}`, data => {
            const parsedData = JSON.parse(data);
            const totalData = parsedData;
            let body = '';
            if (totalData.length) {
              for(let i=0;i<totalData.length;i++) {
                body += `<a class="book-link" href="./view.php?book=${totalData[i].id}"><div class="book">
                            <img class="image" src="${totalData[i].image_url}" width="220px" height="300px">
                            <div>${totalData[i].original_title}</div>
                            <div class="author">${totalData[i].authors}</div>
                        </div></a>`
              }
            }else {
              body += `<div class="author">No Results Found</div>`;
            }
            const books = $('.books');
            books.html(body);
          });
        }
        populateItems();
        $('#search-item').show();
      }else {
        $('#search-item').hide();
      }
      $('#below-arrow').click(e => {
        $('html, body').animate({
          scrollTop: $("#search-item").offset().top-70
        }, 1000);
      });
    </script>
  </body>
</html>
