<div class="row  project-border" style="margin-bottom: 20px">
    <div class="container-fluid" >
        <div class="row project-top show-buttons">
            <div style="padding-top:15px">
                <div class="col-md-1" >
                    <img src="lib/img/todolist.png">
                </div>
                <div class="col-md-9 change-to-inp">
                    <span>{name_of_list}</span>
                </div>
                <div class="col-md-2 text-right hiding-buttons" style="display: none">
                    <img src="lib/img/big_pen.png" onclick="clickPen(this)">
                    <span style="padding: 12px">|</span>
                    <img src="lib/img/big_trash.png" onclick="clickBigTrash(this)">
                </div>
            </div>
        </div>
        <div class="row project-back">
            <div class="col-md-1" style="padding-top: 12px">
                <img src="lib/img/green_plus.png">
            </div>
            <div class="input-group col-md-11" style="padding-top: 10px; padding-right: 10px">
                <input type="text" class="form-control" placeholder="Start typing here to create a task...">
                <span class="input-group-btn">
                    <input class="green-button" type="button" value="Add Task" onclick="addTask(this)">
                </span>
            </div>
        </div>
        <div class="draggable">
            <!-- put tasks here! -->
            {tasks}
        </div>
        <div class="row my-task my-border-radius">
            <div class="col-md-1 my-task-cell-left">
                &nbsp;
            </div>
            <div class="col-md-9 my-task-cell-center">
                &nbsp;
            </div>
            <div class="col-md-2 my-task-cell-right">
                &nbsp;
            </div>
        </div>
    </div>
</div>
