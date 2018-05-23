$(document).ready(function(){

    $('.value').on('focus',function(){
        $(this).parent().addClass('hide-placeholder');
    });
    $('.value').on('blur',function(){
        if ($(this).text().length <= 0){
            $(this).parent().removeClass('hide-placeholder');
        }
    });

    $('.description-textarea').on('click',function(){
        $(this).find('.value').focus();
    });
    $('.value').on('keyup',function(){
        let id = $(this).data('input');
        $('#'+id).attr('value',$(this).html());
    });


    $('#input-file').on('change',function(){
        let file = $(this)[0].files[0];

        let reader = new FileReader();
        reader.onloadend = function(){
            let parent = $('#container-cover');

            parent.find('.cover-img').remove();
            parent.prepend('<img src="'+this.result+'" class="cover-img" />');

            $('.cover-img').on('load',function(){
                setTimeout(img_replacement,20);
            });
        };
        reader.readAsDataURL(file);
    });
});