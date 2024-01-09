$(document).ready(function() {
    //Открытие окна загрузки в личном кабинете
    $('.lk__btn__upload').click(function() {
        document.getElementById('upload__window').classList.remove("upload__window__closed");
    });

    //Закрытие окна загрузки в личном кабинете
    $('.upload__close__btn').click(function() {
        document.getElementById('upload__window').classList.add("upload__window__closed");
        location.reload();
    });

    //Закрытие окна загрузки
    $('#close__upload').click(function(){
        document.getElementById('upload__window').classList.add("upload__window__closed");
        location.reload();
    });

    //Открытие окна создания папки в личном кабинете
    $('#create__folder').click(function() {
        document.getElementById('create__folder__window').classList.remove("upload__window__closed");
    });

    //Закрытие окна создания папки в личном кабинете
    $('#folderCreate__close__btn').click(function() {
        document.getElementById('create__folder__window').classList.add("upload__window__closed");
    });
        
        


});