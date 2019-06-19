<head>
  <link rel="stylesheet" type="text/css" href="./footer.css">
</head>
<footer class="footer">
  <div class="footer-wrapper">
    <div class="footer-left">
      <div class="footer-item-list">
        <div class="footer-item-head">About</div>
        <div class="footer-item">FAQ</div>
        <div class="footer-item">Contact</div>
      </div>
      <div class="footer-item-list">
        <div class="footer-item-head">Books</div>
        <div class="footer-item">Explore</div>
        <div class="footer-item">Search</div>
      </div>
      <div class="footer-item-list">
        <div class="footer-item-head">Profile</div>
        <div class="footer-item login-option">Login</div>
        <div class="footer-item login-option">Sign Up</div>
        <div class="footer-item loggedin-option">View</div>
      </div>
    </div>
    <div class="footer-right">
      <div class="footer-brand">Twitter</div>
      <div class="footer-brand">Facebook</div>
      <div class="footer-brand">Instagram</div>
    </div>
  </div>
</footer>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
$('.loggedin-option').hide();
  if(userData) {
    $('.login-option').hide();
    $('.loggedin-option').show();
  }
</script>
