
function mu_submit(){
    console.log(123);
   $.getJSON( "requests.php", {'act':'login', 'login':$('#inputEmail').val(), 'pass':$('#inputPassword').val()}, function( data ) {
       if (data['status'] == 'ok') {
           location.reload();
       } else {
           $('#message').html(data['description']).fadeIn(1000).fadeOut(2000);
       }
   });
}

function init() {
    $('#projects').load("requests.php", {'act':'load'}, function() {
        addHoverOnPrgTop();
        makeDragable();
    });
}

function makeDragable() {
    $('.draggable').each(function(index, elem) {
        $(elem).sortable({
            stop: function( ) {
                saveAll();
            }
        });
    });
}

function addHoverOnPrgTop() {
    $('.show-buttons').hover(
        function() {
            $(this).find('.hiding-buttons').fadeIn(150);
        },
        function() {
            $(this).find('.hiding-buttons').fadeOut(150);
        }
    );

}

function clickPen(elem) {
    var text = $(elem).parent().parent().find('.change-to-inp').find('span').text();
    var input = '<input value="'+text+'" class="form-control inp_edit" style="margin-top:-5px;" />';
    $(elem).parent().parent().find('.change-to-inp').html(input);
    $('.inp_edit:last').focus();
    $('.inp_edit').focusout(function(){
        var text = $(this).val();
        text = text.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;");

        $(this).parent().html('<span>'+text+'</span>');
        saveAll();
    });
    $('.inp_edit').each(function(index, elem) {
        $(elem).keypress(function(e){
            if (e.keyCode == 13) {
                var text = $(this).val();
                console.log(text);
                text = text.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;");
                console.log(text);

                $(this).parent().html('<span>'+text+'</span>');
                saveAll();
            }
        });
    });
}

function clickBigTrash(elem) {
    $(elem).parent().parent().parent().parent().parent().remove();
    saveAll();
}

function clickLittleTrash(elem) {
    $(elem).parent().parent().remove();
    saveAll();
}

function addTodoList() {
    $.getJSON( "requests.php", {'act':'get_todo_list'}, function( data ) {
        if (data['status'] = 'ok') {
            $('#projects').append(data['tpl']);
            addHoverOnPrgTop();
            makeDragable();
            saveAll();
        } else {
            //show error
        }
    });
}

function addTask(elem) {
    var text = $(elem).parent().parent().find('.form-control').val();
    var after_task = $(elem).parent().parent().parent().parent().find('.draggable');
    text = text.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;");

    if (text !='') {
        $.getJSON( "requests.php", {'act':'get_task', 'name': text}, function( data ) {
            if (data['status'] = 'ok') {
                $(after_task).append(data['tpl']);
                addHoverOnPrgTop();
                saveAll();
            } else {
                //show error
            }
        });
    } else {
        $(elem).parent().parent().find('.form-control').fadeOut(100);
        $(elem).parent().parent().find('.form-control').fadeIn(100);
        $(elem).parent().parent().find('.form-control').fadeOut(100);
        $(elem).parent().parent().find('.form-control').fadeIn(100);
    }
}

function saveAll() {
    data = {};
    $('#projects').find('.project-top').each(function(index,elem){
        if (typeof(data[index])=='undefined') {
            data[index] = {};
            data[index]['tasks'] = {};
        }
        data[index]['list_name'] = $(elem).find('.change-to-inp').find('span').text();

        $(elem).parent().find('.my-task').each(function(task_ind, task_elem){
            var checkbox = $(task_elem).find('input:first');
            var text = $(task_elem).find('.change-to-inp').find('span').text();
            if (typeof(checkbox[0]) != 'undefined') {
                if (typeof(data[index]['tasks'][task_ind])=='undefined') {
                    data[index]['tasks'][task_ind] = {}
                }
                data[index]['tasks'][task_ind]['checked'] = $(checkbox[0])[0].checked;
                data[index]['tasks'][task_ind]['text'] = text;
            }
        });
    });

    $.getJSON( "requests.php", {'act':'saveData', 'data':data}, function( data ) {
        if (data['status'] = 'ok') {
            //saved
        } else {
            //show error
        }
    });
}

function logout() {
    $.getJSON( "requests.php", {'act':'logout'}, function() {
        console.log(123);
        location.reload();
    });
}