$(document).ready(function(){
    $('#input-file-community').on('change',function(){
        let file = $(this)[0].files[0];
        let parent = $(this).parent();

        let reader = new FileReader();
        reader.onloadend = function(){

            parent.find('.cover-img').remove();
            parent.prepend('<img src="'+this.result+'" class="cover-img" />');

            $('.cover-img').on('load',function(){
                setTimeout(img_replacement,20);
            });
        };
        reader.readAsDataURL(file);
    });

    $('#input-file-tag').on('change',function(){

        alert('');

        let file = $(this)[0].files[0];
        let parent = $(this).parent();

        let reader = new FileReader();
        reader.onloadend = function(){

            parent.find('.cover-img').remove();
            parent.prepend('<img src="'+this.result+'" class="contain-img" />');

            $('.contain-img').on('load',function(){
                setTimeout(img_replacement_contain,20);
            });
        };
        reader.readAsDataURL(file);
    });

    $('.contain-img').on('load',function(){
        setTimeout(img_replacement_contain,20);
    });

    $('.cover-img').on('load',function(){
        setTimeout(img_replacement,20);
    });

    img_replacement_contain();
    img_replacement();
});