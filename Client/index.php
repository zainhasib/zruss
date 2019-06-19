<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Project</title>
    <link rel="stylesheet" href="style.css" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
</head>
<body>
    <?php include_once('./header.php'); ?>
    <div class="header-gap"></div>
    <section>
        <div class="wrapper">
            <div class="user">
                <i class="fas fa-user fa-2x"></i>
            </div>
            <div class="image">
                <h2>Book Recommendation based on your Interest.</h2>
                <button class="btn" id="tastecalc"> <i class="fas fa-puzzle-piece"></i> Know Your Interest</button>
            </div>
        <div>
    </section>
    <div id="taste" style="display: none;">
        <?php include_once('./overlay.php'); ?>
    </div>
    <section>
        <div class="book-title">
            <h2>POPULAR BOOKS</h2>
        </div>
            <?php  
                $content = file_get_contents('http://localhost:5000/'); 
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
    </section>
    <section>
        <div class="book-title">
            <h2>TRENDING BOOKS</h2>
        </div>
            <?php  
                $content = file_get_contents('http://localhost:5000/trend'); 
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
    </section>
    <?php include_once('./footer.php'); ?>
    
    <script>
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
                answers.push(document.querySelector('input[name="option"]:checked').previousElementSibling.innerHTML);
            }
            console.log(answers);
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