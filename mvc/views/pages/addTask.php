<link rel="stylesheet" href="./../public/css/addTask.css" />
<div class="container">

  <div class="contentContainer">
    <h1 class="txtHeading">Add new task</h1>
    <button id="btnImportFile" class="importBtn button"> Import from file </button>
    <form id="importContainer" action="/index.php?url=Tasks/importFile" method="post" enctype="multipart/form-data" style="display:none">
      <input type="file" name="fileToUpload" id="fileToUpload" class="selectFileDiv">
      <input type="submit" value="Upload" name="submit" class="uploadBtn button">
    </form>

    <div class="newTaskContainer">
      <div class="controlContainer">
        <a href="/index.php?url=Tasks" type="button" class="btnControl button">Cancel</a>
        <button type="button" class="btnControl button" id="btnAdd">Add</button>
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
            <option value="Not Done">Undone</option>
            <option value="Done">Done</option>
          </select>
        </div>
        <div class="infoContainer">
          <span class="txtInfo">Task description</span>
          <textarea name="content" placeholder="The lesson on page 21, page 6, will have an exam on June 21, 2004" class="longinpTask textarea"
            ><?php if (isset($data["Task"]["content"]) && $data["Task"]["content"] != '') echo $data["Task"]["content"]; ?></textarea>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  document.getElementById('btnAdd').addEventListener('click', function() {
    document.getElementById('infoForm').submit();
  });
    
  document.getElementById('btnImportFile').addEventListener('click', function() {
    if (document.getElementById('importContainer').style.display == 'none') {
      document.getElementById('importContainer').style.display = 'block';
    } else {
      document.getElementById('importContainer').style.display = 'none';
    }
    var txtUrl = './../public/templateFileForImport/sample.txt'; 
    var xlsxUrl = './../public/templateFileForImport/sample.xlsx';
    for (var i = 0; i < 2; i++) {
        var fileUrl = (i == 0) ? txtUrl : xlsxUrl;
        var downloadLink = document.createElement('a');
        downloadLink.href = fileUrl;
        downloadLink.download = 'sample.' + ((i == 0) ? 'txt' : 'xlsx');
        document.body.appendChild(downloadLink);
        downloadLink.click();
        document.body.removeChild(downloadLink);
    }
    alert('You have just downloaded two sample files (txt and xlsx). These files serve as templates for your input and import processes.');
  });

  <?php if ($data["Error"] != '') : ?>
  alert("Add task failed. " + "<?php echo $data['Error']; ?>");
<?php endif; ?>

</script>
