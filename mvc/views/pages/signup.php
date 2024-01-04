<link rel="stylesheet" href="./../public/css/signup.css" />
<div class="containerContent">
  <div class="leftContainer">
    <h1 class="leftTitle">Already have an Account?</h1>
    <span class="leftSubtitle">
      To keep connected with us please login
    </span>
    <a href="/index.php?url=Login" class="leftBtn button">Login</a>
  </div>
  <div class="rightContainer">
    <h1 class="rightTitle">Create Account</h1>
    <span class="rightSubtitle">
      Sign up with Username and Password (alphanumeric only)
      <br />
    </span>
    <form method="POST" action="" class="rightForm">
      <input name="username" type="text" placeholder="Username (1-30 characters)"
        value="<?php echo (isset($_POST["username"]) ? $_POST["username"] : "") ?>" class="inpForm input" />
      <input name="password" type="password" id="inpPassword" placeholder="Password (1-30 characters)"
        value="<?php echo (isset($_POST["password"]) ? $_POST["password"] : "") ?>" class="inpForm input" />
      <div class="showPass">
        <input type="checkbox" onclick="showPassword()" /> <label>Show Password</label>
      </div>
      <input name="submit" type="submit" class="rightBtn button" value="Sign up" />
    </form>
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
    alert("Sign up failed. " + "<?php echo $data['Error']; ?>");
  <?php endif; ?>
</script>