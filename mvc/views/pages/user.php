<link rel="stylesheet" href="./../public/css/user.css" />

<div class="container">
  <div class="contentContainer">
    <h1 class="txtHeading">Hello,
      <?php echo $_SESSION['username']; ?>
    </h1>
    <span class="txtsubtitle">
      <span>You can change your password (alphanumeric only) or delete your account</span>
      <br />
    </span>
    <div class="infoContainer">
      <div class="btnContainer">
        <button type="button" class="btnUser button" id="btnWantChange">Change password</button>
        <button type="button" class="btnUser button" id="btnWantDelete">Delete my Account</button>
      </div>
      <div class="formContainer">
        <form method="POST" id="changePassForm" class="formInfo" style="display:none;">
          <input name="oldPassword" type="password" id="inpPassword" placeholder="Old Password" class="inpForm input" />
          <br>
          <input name="newPassword" type="password" id="inpNewPassword" placeholder="New Password"
            class="inpForm input" />
          <div class="showPass">
            <input type="checkbox" onclick="showPassword(0)" class="checkShowPass" /> <label>Show Password</label>
          </div>
          <input type="submit" name="submit" value="Change" class="submitBtn button" />
        </form>
        <form method="POST" id="deleteAccForm" class="formInfo" style="display:none;">
          <input name="curpassword" type="password" id="inpPasswordDlt" placeholder="Password" class="inpForm input" />
          <br>
          <input name="confirmPassword" type="password" id="inpConfirmPassword" placeholder="Confirm Password"
            class="inpForm input" />
          <div class="showPass">
            <input type="checkbox" onclick="showPassword(1)" class="checkShowPass" /> <label>Show Password</label>
          </div>
          <input type="submit" name="submit" value="Delete" class="submitBtn button" />
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  function showPassword(idCheck) {
    var checked = document.getElementsByClassName("checkShowPass")[idCheck].checked;
    if (idCheck == 0) { // check of Change Password
      document.getElementById("inpPassword").type = (checked) ? "text" : "password";
      document.getElementById("inpNewPassword").type = (checked) ? "text" : "password";
    } else { // check of Delete
      document.getElementById("inpPasswordDlt").type = (checked) ? "text" : "password";
      document.getElementById("inpConfirmPassword").type = (checked) ? "text" : "password";
    }
  }
  document.getElementById("btnWantChange").addEventListener("click", function () {
    // Hide delete account form
    document.getElementById("deleteAccForm").style.display = "none";

    // Toggle change password form visibility
    const changePasswordForm = document.getElementById("changePassForm");
    changePasswordForm.style.display = (changePasswordForm.style.display == "none") ? "block" : "none";
  });

  document.getElementById("btnWantDelete").addEventListener("click", function () {
    // Hide change password form
    document.getElementById("changePassForm").style.display = "none";

    // Toggle delete account form visibility
    const deleteAccountForm = document.getElementById("deleteAccForm");
    deleteAccountForm.style.display = (deleteAccountForm.style.display === "none") ? "block" : "none";
  });
  
  <?php if ($data["Error"] != ''): ?>
    // Call a JavaScript function when data['error'] is not null
    alert("<?php echo $data['Error']; ?>");
  <?php endif; ?>
</script>