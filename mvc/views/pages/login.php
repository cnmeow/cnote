<link rel="stylesheet" href="./../public/css/signup.css" />
<div class="containerContent">
  <div class="rightContainer">
    <h1 class="rightTitle">Welcome back</h1>
    <span class="rightSubtitle">
      Sign in with Username and Password
      <br />
    </span>
    <form method="POST" action="" class="rightForm">
      <input name="username" type="text" placeholder="Username"
        value="<?php echo (isset($_POST["username"]) ? $_POST["username"] : "") ?>" class="inpForm input" />
      <input name="password" type="password" id="inpPassword" placeholder="Password"
        value="<?php echo (isset($_POST["password"]) ? $_POST["password"] : "") ?>" class="inpForm input" />
      <div class="showPass">
        <input type="checkbox" onclick="showPassword()" /> <label>Show Password</label>
      </div>
      <input name="submit" type="submit" class="rightBtn button" value="Login" />
    </form>
  </div>
  <div class="leftContainer">
    <h1 class="leftTitle">New to CNote?</h1>
    <span class="leftSubtitle">
      Please sign up to continue
    </span>
    <a href="/index.php?url=Signup" class="leftBtn button">Sign up</a>
  </div>
</div>

<script>
  function showPassword() {
    var password = document.getElementById('inpPassword');
    if (password.type == "password") {
      password.type = "text";
    } else {
      password.type = "password";
    }
  }
  <?php if ($data["Error"] != ''): ?>
    // Call a JavaScript function when data['error'] is not null
    alert("Login failed. " + "<?php echo $data['Error']; ?>");
  <?php endif; ?>
</script>