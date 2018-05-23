$(document).ready(function(){
    if($('body').hasClass('tag') || $('body').hasClass('community')){


        function img_container_replacement(){

            let el = $('img.contain');

            for(let i=0;i<el.length;i++){

                if (el.eq(i).height() > 0 && el.eq(i).width() > 0){
                    let parent = el.eq(i).parent();
                    let container_height = parent.height() - 5;
                    let container_width = parent.width() - 5;

                    let containerRatio = container_width / container_height;
                    let imgRatio = el.eq(i).width() / el.eq(i).height();

                    let img_height,img_width,translateY,translateX;

                    if(containerRatio < imgRatio){
                        img_height = container_width / imgRatio;
                        img_width = container_width;

                    }else{
                        img_height = container_height;
                        img_width = container_height * imgRatio;

                    }

                    el.eq(i).css({height: img_height+'px',width: img_width+'px'});
                }
            }
        }

        function scroll(){
            if (!window.matchMedia("(max-width: 1200px)").matches){
                let scrollHeight = $(this).scrollTop();

                $('#container-cover').css({transform: 'translate3d(0px,'+scrollHeight+'px,0px)'});
            }else{
                $('#container-cover').css({transform: 'translate3d(0px,0px,0px)'});
            }

            window.requestAnimationFrame(scroll);
        }

        $('img.contain').on('load',function(){
            setTimeout(img_container_replacement,20);
        });

        $('.cover-img').on('load',function(){
            setTimeout(img_replacement,20);
        });

        $(window).on('resize',function(){
            img_container_replacement();
        });

        img_replacement();
        img_container_replacement();

        scroll();
    }
    $(window).on('resize',function(){
        middle_margin_replacement();
    });
    middle_margin_replacement();
});

function img_replacement(){
    let coverImg = $('.cover-img').last();

    let parent = $('#container-cover');
    let container_height;
    let container_width = parent.width();

    if (window.matchMedia("(max-width: 1200px)").matches){
        container_height = 400;
    }else{
        container_height = $(window).height() - 54;
    }

    if (coverImg.length > 0){
        let containerRatio = container_width / container_height;
        let imgRatio = coverImg.width() / coverImg.height();

        let img_height,img_width;

        if(containerRatio > imgRatio){
            img_height = container_width / imgRatio;
            img_width = container_width;
        }else{
            img_height = container_height;
            img_width = container_height * imgRatio;
        }

        coverImg.css({height: img_height+'px',width: img_width+'px'});
    }

    parent.css({height: container_height+'px'});
}

function middle_margin_replacement(){
    let el = $('.margin-middle');
    for(let i=0;i<el.length;i++){
        el.eq(i).css({marginTop: (($('#'+el.eq(i).data('target')).height() - el.eq(i).height()) / 2)+'px'});
    }
}