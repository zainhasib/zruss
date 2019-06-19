<style>
* {
  font-family: 'Quicksand', sans-serif;
}

.loading {
  min-height: 300px;
  height: auto;
  width: 100%;
  display: flex;
  justify-content: center;
  align: center;
}

.book-container {
  margin-top: 80px;
  width: 100%;
  min-height: 300px;
  height: auto;
}

.book-wrapper {
  width: 80%;
  margin: auto;
  padding: 20px;
  display: flex;
  flex-direction: row;
}

.book-image {
  height: 300px;
  width: 220px;
}

.book-desc {
  display: flex;
  flex-direction: column;
  margin: 0px 25px;
}

.title {
  font-size: 1.1em;
  font-family: 'Rubik', sans-serif;
}

.book-item {
  padding: 10px 0px;
}

.like-container {
  width: auto;
  height: auto;
  display: flex;
  flex-direction: row;
  color: #bbb;
}

.like-container .icon {
  height: 20px;
  width: 20px;
  padding: 12px;
  cursor: pointer;
  text-align: center;
  display: flex;
  justify-content: center;
  align-items: center;
  margin: 10px 12px;
  width: 40px;
}

.icon.liked {
  background: rgb(84, 126, 243) !important;
  color: #fff;
  box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);
}

.icon.disliked {
  background: #f00 !important;
  color: #fff;
  box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);
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
    width: 250px;
    margin: 20px 30px;
    flex-direction: column;
}

.author {
    font-size: 0.8em;
}

@media only screen and (max-width: 685px) {

  .book-wrapper {
    width: 90%;
  }

  .book-image {
    height: 240px;
    width: 200px;
  }
}

</style>

<?php include_once('./header.php'); ?>

<div class="book-container">
    <?php  
        $book = file_get_contents('http://localhost:5000/book/'. $_GET['book']); 
        $b = json_decode($book, true);
    ?>
    <div class="book-wrapper">
        <img class="book-image" src="<?php echo $b[0]['image_url']; ?>" />
        <div class="book-desc">
            <div class="title"><?php echo $b[0]['title']; ?></div>
            <div class="book-author">by <?php echo $b[0]['authors']; ?></div>
            <div class="book-item">ISBN : <?php echo $b[0]['isbn']; ?></div>
            <div class="book-item">Rating : <?php echo $b[0]['average_rating']; ?> / 5</div>
            <div class="book-item">Published On : <?php echo $b[0]['original_publication_year']; ?> / 5</div>
        </div>
    </div>
    </div>
    <div class="book-title">
        Recommended Books: 
    </div>
        <?php  
            $content = file_get_contents('http://localhost:5001/book/'. $_GET['book'] .''); 
            $c = json_decode($content, true);
        ?>
    <div class="books">
        <?php 
            foreach($c as $item) {
                echo '<a class="book-link" href="./view.php?book='. $item['id'] .'"><div class="book">
                <img src="' . $item['image_url'] . '" width="220px" height="300px">
                <div>' .  $item['original_title'] . '</div>
                <div class="author">'. $item['authors'] . '</div>
            </div></a>';
            }
        ?>
    </div>
</div>

<?php include_once('./footer.php'); ?>