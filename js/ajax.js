$(document).ready(function() {
    //Скрытие сообщения
    $('.msg').delay(3000).slideUp();
    //Выделение пунктов меню при клике в личном кабинете
    $('.lk__menu').click(function(e) {
        let index = [].slice.call(this.children).indexOf(e.target);
        index += 1;

        $.ajax({
            method: "POST",
            dataType: 'json',
            url: "../vendor/filter.php",
            data: {crntActivePnktMenu: index},
            success:function(){},
            error:function(){}
        });
        location.reload();
    });

    //Выделение файлов при клике в личном кабинете
    let crntSelectedFile;
    
    $('.lk__right__content').click(function(e) {
        let index = [].slice.call(this.children).indexOf(e.target);
        index += 1;
        
        if (crntSelectedFile) {
            if (('file' + index) == crntSelectedFile) {
                document.getElementById(crntSelectedFile).classList.remove("lk__right__file__selected");
                crntSelectedFile = null;
            }else{
                document.getElementById('file' + index).classList.add("lk__right__file__selected");
                document.getElementById(crntSelectedFile).classList.remove("lk__right__file__selected");
                
                crntSelectedFile = 'file' + index;
            }
        }else{
            document.getElementById('file' + index).classList.add("lk__right__file__selected");

            crntSelectedFile = 'file' + index;
        }

    });

    //Удаление
    let nameSelectedFile;
    

    $('#delete').click(function(){
        nameSelectedFile = $('#' + crntSelectedFile + '_text').text();

        //Удаление папки
        if ($('#' + crntSelectedFile + ' :first-child').hasClass('folder')) {
            $.ajax({
                method: "POST",
                dataType: 'json',
                url: "../vendor/delete_folder.php",
                data: {folder_name: nameSelectedFile},
                success:function(){},
                error:function(){}
            });
        }else{
            //Удаление файла
            $.ajax({
                method: "POST",
                dataType: 'json',
                url: "../vendor/delete_file.php",
                data: {file_name: nameSelectedFile},
                success:function(){},
                error:function(){}
            });
        };
        location.reload();
    });

    //Открытие папки
    let idForOpenFolder;
    let name_folder;

    //дабл клик для смартфонов
    let touchtime = 0;
    $(".lk__right__content").on("click", function(e) {
        if (touchtime == 0) {
            // первый клик
            touchtime = new Date().getTime();
        } else {
            if (((new Date().getTime()) - touchtime) < 800) {
                // дабл клик сработал
                
                let index = [].slice.call(this.children).indexOf(e.target);
                index += 1;
                idForOpenFolder = 'file' + index + '_text';
        
                name_folder = $('#' + idForOpenFolder).text();
                if ($('#' + idForOpenFolder).prev().hasClass('folder')) {
                    $.ajax({
                        method: "POST",
                        dataType: 'json',
                        url: "../vendor/open_folder.php",
                        data: {name_folder: name_folder},
                        success:function(){},
                        error:function(){}
                    });
                };
                location.reload();        
            
                touchtime = 0;
            } else {
                touchtime = new Date().getTime();
            }
        }
    });

    $('.lk__right__content').dblclick(function open_folder(e) {
        let index = [].slice.call(this.children).indexOf(e.target);
        index += 1;
        idForOpenFolder = 'file' + index + '_text';

        name_folder = $('#' + idForOpenFolder).text();
        if ($('#' + idForOpenFolder).prev().hasClass('folder')) {
            $.ajax({
                method: "POST",
                dataType: 'json',
                url: "../vendor/open_folder.php",
                data: {name_folder: name_folder},
                success:function(){},
                error:function(){}
            });
        };
        location.reload();        
    });

    //кнопка назад
    $('#back').click(function() {
        $.ajax({
            method: "POST",
            dataType: 'json',
            url: "../vendor/back.php",
            success:function(){},
            error:function(){}
        });
        location.reload();
    });


    //Переименование
    let type;

    $('#rename').click(function(){
        nameSelectedFile = $('#' + crntSelectedFile + '_text').text();

        if (!nameSelectedFile == '') {
            //Переименование папки
            if ($('#' + crntSelectedFile + ' :first-child').hasClass('folder')) {
                type = 'folder';
            }else{
                type = 'file'
            };

            $('#rename__window').removeClass('upload__window__closed');
            $('#name_input').val(nameSelectedFile);
            $('#file_type').val(type);
            $('#prevName').val(nameSelectedFile);
        }
    });

    //Закрытие окна переименования
    $('#rename__close__btn').click(function(){
        $('#rename__window').addClass('upload__window__closed');
    });

    //Загрузка файла
    const form = document.querySelector("#upload__form"),
    fileInput = document.querySelector("#upload__file"),
    progressArea = document.querySelector(".progress-area"),
    uploadedArea = document.querySelector(".uploaded-area");
    fileInput.onchange = ({target})=>{
    let file = target.files[0];
    if(file){
        let fileName = file.name;
        if(fileName.length >= 12){
        let splitName = fileName.split('.');
        fileName = splitName[0].substring(0, 13) + "... ." + splitName[1];
        }
        uploadFile(fileName);
        $('#btn__uploadJS').addClass('disable__btn__uploadJS');
    }
    }
    function uploadFile(name){
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "vendor/upload_files.php");
    xhr.upload.addEventListener("progress", ({loaded, total}) =>{
        let fileLoaded = Math.floor((loaded / total) * 100);
        let fileTotal = Math.floor(total / 1000);
        let fileSize;
        (fileTotal < 1024) ? fileSize = fileTotal + " KB" : fileSize = (loaded / (1024*1024)).toFixed(2) + " MB";
        let progressHTML = `<li class="row">
                            <i class="fas fa-file-alt"></i>
                            <div class="content">
                                <div class="details">
                                <span class="name">${name} • Uploading</span>
                                <span class="percent">${fileLoaded}%</span>
                                </div>
                                <div class="progress-bar">
                                <div class="progress" style="width: ${fileLoaded}%"></div>
                                </div>
                            </div>
                            </li>`;
        uploadedArea.classList.add("onprogress");
        progressArea.innerHTML = progressHTML;
        if(loaded == total){
            location.reload();
        }
    });
    let data = new FormData(form);
    xhr.send(data);
    }








    
});