<link rel="stylesheet" href="./../public/css/tasks.css" />
<div class="container">
  <div class="contentContainer">
    <h1 class="txtHeading">All Your Tasks</h1>
    <div class="controlContainer">
      <a href="/index.php?url=Tasks" class="btnControl button">All</a>
      <a href="/index.php?url=Tasks/doneTasks" class="btnControl button">Completed</a>
      <a href="/index.php?url=Tasks/addTask" class="btnControl button">Add</a>

      <form method="POST" action="" id="findForm">
        <input class="btnControl button" type="text" name="findTitle" placeholder="Find task by title"
          value="<?php echo (isset($data["findTitle"]) ? $data["findTitle"] : "") ?>" />
        <input class="btnControl button" type="date" name="findDate"
          value="<?php echo (isset($data["findDate"]) ? $data["findDate"] : "") ?>" />
        <svg id="findIcon" xmlns="http://www.w3.org/2000/svg" height="16" width="16"
          viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
          <path
            d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6 .1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z" />
        </svg>
      </form>
    </div>
    <div class="allTasksContainer">
      <?php
      if (empty($data['Tasks'])) {
        echo "<div class='emptyList'>";
        echo "<p>No tasks to display. Let's add.</p>";
        echo "</div>";
      } else {
        foreach ($data['Tasks'] as $task) {
          echo "<div class='taskContainer'>";
          echo "<div class='headingTask'>";
          echo "<h1 class='hiddenLongText'>" . $task['title'] . "</h1>";
          echo "<div class='btnHeadingContainer'>";
          echo "<a href='/index.php?url=Tasks/editTask/" . $task['id'] . "' class='btnTask button'>Edit</a>";
          echo "<a href='/index.php?url=Tasks/changeStatus/" . $task['id'] . "/0/1' class='btnTask button'>Done</a>";
          echo "</div>";
          echo "</div>";
          echo "<div class='infoTask'>";
          if (isset($task['duedate'])) {
            echo "<span class='contentTask'>" . $task['duedate'] . "</span>";
          }
          if (isset($task['content'])) {
            echo "<span class='contentTask'>" . $task['content'] . "</span>";
          }
          echo "</div>";
          echo "</div>";
        }
      }
      ?>
    </div>
  </div>
</div>

<script>
  document.getElementById('findIcon').addEventListener('click', function () {
    document.getElementById('findForm').submit();
  });
</script>