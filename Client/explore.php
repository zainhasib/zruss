<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="explore.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <title>explore the page</title>
  </head>
  <body>
    <?php include_once('./header.php'); ?>
    <div class="cont1" id='taste-wrapper'>
      <div class="icon">
        <i class="fas fa-user fa-2x"></i>
      </div>
      <div class="heading">
        <h3>INTEREST PROFILE</h3>
      </div>
      <div class="percent">
        <span>0%</span>
      </div>
      <div class="calctaste">
        <input type="submit" value="Calculate your interest" class="interestbut" id="tastecalc">
      </div>
    </div>
    <div id="taste" style="display: none;">
        <?php include_once('./overlay.php'); ?>
    </div>
    <br/>
    <div class="cont2">
      <div class="heading2">
        <h1>All Books</h1>
      </div>
      <div class="para">
          <p>Collection of books</p>
      </div>
    </div>
    <div class="container-1">
      <a href="./explorenew.php" class="item">
          <img src="https://images.pexels.com/photos/415061/pexels-photo-415061.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940">
          <div>New Arrivings</div>
      </a>
      <a href="./exploretrend.php" class="item">
          <img src="https://images.pexels.com/photos/1906437/pexels-photo-1906437.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940" >
          <div>In Trend</div>
      </a>
      <a href="./explorepopular.php" class="item">
          <img src="https://images.pexels.com/photos/2099265/pexels-photo-2099265.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940" >
          <div>Most Popular</div>
      </a>
    </div>

    <div class="cont2">
      <div class="heading2">
        <h1>Browse</h1>
      </div>
      <div class="para">
          <p>by Genre</p>
      </div>
    </div>
    <div class="genre-container">
        <?php 
            $genre = array("Action", "Adventure", "Comedy", "Fiction", "History", "Horror", "Thriller", "Sports", "Kids");
            foreach($genre as $g) {
                echo '<a class="genre" href="./exploregenre.php?genre='.strtolower($g).'">'.$g.'</a>';
            }
        ?>
    </div>

    <?php include_once('./footer.php'); ?>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
    const tasteWrapper = document.querySelector('#taste-wrapper');
    const tasteFromStorage = localStorage.getItem("TASTE");
    if(tasteFromStorage !== null) {
        tasteWrapper.style.display = "none";
    }
    const HttpClient = () => {
        this.get = function(url, callback) {
            var anHttpRequest = new XMLHttpRequest();
            anHttpRequest.onreadystatechange = function() { 
                if (anHttpRequest.readyState == 4 && anHttpRequest.status == 200)
                    callback(anHttpRequest.responseText);
            }

            anHttpRequest.open("GET", url, true);            
            anHttpRequest.send(null);
        }
    }
    const tasteBtn = document.querySelector('#tastecalc');
    const taste = document.querySelector('#taste');
    tasteBtn.addEventListener('click', () => {
        taste.style.display = "flex";
    });
    const items = [
        {
            q: "Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quibusdam beatae laborum, sunt totam doloribus error accusantium reiciendis iure voluptate quasi?",
            a: ['Action', 'Adventure', 'Comedy', 'Horror']
        },
        {
            q: "Reprehenderit ad tempora quam quia. Omnis nesciunt quia soluta exercitationem. Impedit autem animi nostrum illum officiis veritatis?",
            a: ['Sorrow', 'Adventure', 'Comedy', 'Horror']
        },
    ]
    const tasteContainer = document.getElementById('tasteContainer');
    const tasteOverlay = document.getElementById('tasteOverlay');
    const itemTitle = document.getElementById('itemTitle');
    const next = document.getElementById('next');
    const options = document.querySelectorAll('.item-option');
    let presentItem = 0;
    let finish = 0;
    let answers = [];
    let selected;
    // Check click on overlay but not on container
    tasteOverlay.addEventListener('click', (e) => {
        if(!tasteContainer.contains(e.target)) {
            presentItem = 0;
            populateItem();
            taste.style.display = "none";
            next.innerText = "Next";
        }
    });
    // Load the item on DOM ready
    const populateItem = () => {
        let opt = 0;
        options.forEach(option => {
            itemTitle.innerHTML = items[presentItem].q;
            option.nextElementSibling = items[presentItem].a[opt];
            option.innerHTML = items[presentItem].a[opt];
            opt++;
        })
    }
    // Options event listener
    options.forEach(option => {
        option.addEventListener('click', e => {
            selected = e.target.innerHTML;
            e.target.classList.add('selected');
        })
    });
    next.addEventListener('click', (e) => {
        if(finish) {
            taste.style.display = "none";
            if(document.querySelector('input[name="option"]:checked')) {
                answers.push(document.querySelector('input[name="option"]:checked').previousElementSibling.innerHTML.toLowerCase());
            }
            localStorage.setItem("TASTE", JSON.stringify(answers));
            tasteWrapper.style.display = "none";
            console.log(answers);
                window.location.replace('./index.php');
        }
        presentItem = presentItem+1;
        if(presentItem<items.length) {
            if(document.querySelector('input[name="option"]:checked')) {
                answers.push(document.querySelector('input[name="option"]:checked').previousElementSibling.innerHTML);
            }
            populateItem();
        }
        if(presentItem===items.length-1) {
            next.innerText = "Finish";
            finish = 1;
        }
        document.querySelectorAll('input[name="option"]').forEach(e => e.checked = false);
    });
    populateItem();
    </script>
  </body>
</html>
