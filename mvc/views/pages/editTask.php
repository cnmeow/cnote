<link rel="stylesheet" href="./../public/css/addTask.css"/>
<div class="container">
  <div class="contentContainer">
    <h1 class="txtHeading">Edit task</h1>
    <div class="newTaskContainer">
      <div class="controlContainer">
        <a href="/index.php?url=Tasks" type="button" class="btnControl button">Cancel</a>
        <button type="button" class="btnControl button" id="btnDelete">Delete</button>
        <button type="button" class="btnControl button" id="btnEdit">Save changes</button>
      </div>

      <form method="POST" action="" id="infoForm">
        <div class="infoContainer">
          <span class="txtInfo">Task title</span>
          <input type="text" name="title" placeholder="Studying..." autofocus="" class="inpTask input"
            <?php echo (isset($data["Task"]["title"]) && $data["Task"]["title"] != '') ? 'value="' . $data["Task"]["title"] . '"' : ''; ?>
          />
        </div>
        <div class="infoContainer2">
    
          <input type="date" name="duedate" class="inpTask input"
            <?php echo (isset($data["Task"]["duedate"]) && $data["Task"]["duedate"] != '') ? 'value="' . $data["Task"]["duedate"] . '"' : ''; ?>
          />
        <select name="status" class="statusSelect inpTask input">
            <option value="Undone"  >Undone</option>
            <option value="Done" >Done</option>
            </select>
        
        </div>
        <div class="infoContainer">
          <span class="txtInfo">Task description</span>
          <textarea name="content" placeholder="The lesson on page 21, page 6, will have an exam on June 21, 2004" class="longinpTask textarea" name="content"
          > <?php echo (isset($data["Task"]["content"]) && $data["Task"]["content"] != '') ? $data["Task"]["content"] : ''; ?></textarea>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  <?php if ($data["Error"] != ''): ?>
      alert("Edit task failed. " + "<?php echo $data['Error']; ?>");
  <?php endif; ?>

  document.getElementById('btnEdit').addEventListener('click', function() {
      document.getElementById('infoForm').submit();
  });
  document.getElementById('btnDelete').addEventListener('click', function() {
      window.location.href = '/index.php?url=Tasks/changeStatus/<?php echo $data['idTask'] ?>/0/2'; 
  });
</script>