<div class="row my-task my-task-border-top show-buttons">
    <div class="col-md-1 my-task-cell-left my-task-cell">
        <input type="checkbox" {task_checked} onchange="saveAll()"/>
    </div>
    <div class="col-md-9 my-task-cell-center my-task-cell change-to-inp">
        <span>{task_name}</span>
    </div>
    <div class="col-md-2 my-task-cell-right my-task-cell hiding-buttons" style="display: none">
        <img src="lib/img/up_down.png">
        <span style="padding: 4px">|</span>
        <img src="lib/img/little_pen.png"  onclick="clickPen(this)">
        <span style="padding: 4px">|</span>
        <img src="lib/img/little_trash.png" onclick="clickLittleTrash(this)">
    </div>
</div>