<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="trending.css">
    <title>Trending</title>
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
    </style>
  </head>
  <body>
    <?php include_once('./header.php') ?>
    <div class="top">
      <h1>Trending Books</h1>
      <p>Here's a list of the trending books. Save movies to the watchlist to track
        streaming availability or rate the ones you’ve seen to build your taste profile.</p>
    </div>

    <section>
        <div class="books">
          <div class="loading">
            <div class="loader"></div>
          </div>
        </div>
        <div class="page">
          <form name="form1">
            <input type="button" name="butl" class="syml" value="<" onClick="left()">
            <input type="text" name="display" class="area" value="1 / 5" >
            <input type="button" name="butr" class="symr" value=">" onClick="right()">
          </form>
        </div>
    </section>
    <?php include_once('./footer.php'); ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
      let pg_no=1;
      let total=5;
      let cur_page=1;
      populateItems = () => {
        $.get(`http://localhost:5000/books?page=${cur_page}`, function( data ) {
          const parsedData = JSON.parse(data);
          const totalData = parsedData['data'];
          let body = '';
          total = parsedData['pages'];
          document.form1.display.value=cur_page+" / "+total;
          for(let i=0;i<totalData.length;i++) {
            body += `<a class="book-link" href="./view.php?book=${totalData[i].id}"><div class="book">
                        <img class="image" src="${totalData[i].image_url}" width="220px" height="300px">
                        <div>${totalData[i].original_title}</div>
                        <div class="author">${totalData[i].authors}</div>
                    </div></a>`
          }
          const books = $('.books');
          books.html(body);
        });
      }
      function right()
      {
        if(cur_page<total)
        {
          cur_page=cur_page+1;
          document.form1.display.value=cur_page+" / "+total;
          populateItems();
        }
      }
      function left()
      {
        if(cur_page>1)
        {
          cur_page=cur_page-1;
          document.form1.display.value=cur_page+" / "+total;
          populateItems();
        }
      }
      populateItems();
    </script>
  </body>
</html>
