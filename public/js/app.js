function img_replacement_contain(){
    let img = $('.contain-img');
    for(let i=0;i<img.length;i++){
        let el = img.eq(i);
        let parent = el.parent();

        let container_height,container_width,container_ratio,img_ratio;

        container_width = parent.width();
        container_height = parent.height();

        img_height = el.height();
        img_width = el.width();

        container_ratio = container_width / container_height;
        img_ratio = img_width / img_height;

        if(container_ratio < img_ratio){
            img_height = container_width / img_ratio;
            img_width = container_width;
        }else{
            img_height = container_height;
            img_width = container_height / img_ratio;
        }

        el.css({height: img_height+'px',width: img_width+'px'});
    }
}

function img_replacement(){
    let img = $('.cover-img');
    for(let i=0;i<img.length;i++){
        let el = img.eq(i);
        let parent = el.parent();

        let container_height,container_width,container_ratio,img_ratio;

        container_width = parent.width();
        container_height = parent.height();

        img_height = el.height();
        img_width = el.width();

        container_ratio = container_width / container_height;
        img_ratio = img_width / img_height;

        if(container_ratio > img_ratio){
            img_height = container_width / img_ratio;
            img_width = container_width;
        }else{
            img_height = container_height;
            img_width = container_height * img_ratio;
        }

        console.log({height: img_height+'px',width: img_width+'px'});

        el.css({height: img_height+'px',width: img_width+'px'});
    }
}

$(document).ready(function(){
    let body = $('body');

    if (body.hasClass('home-view')){
        function scroll(){
            if (!window.matchMedia("(max-width: 1000px)").matches){
                let scrollHeight = $(this).scrollTop();

                $('#container-map').css({transform: 'translate3d(0px,'+scrollHeight+'px,0px)',height: ($('html').height() - 54)+'px'});
            }else{
                $('#container-map').css({transform: 'translate3d(0px,0px,0px)',height: '500px'});
            }

            window.requestAnimationFrame(scroll);
        }

        scroll();
    }

    if(body.hasClass('community-add') || body.hasClass('community-edit') || $('body').hasClass('entreprise-view') || $('body').hasClass('tags-add') || $('body').hasClass('tags-edit') || $('body').hasClass('tag-view') || $('body').hasClass('community-view') || $('body').hasClass('entreprise-add') || body.hasClass('entreprise-edit') || body.hasClass('entreprise-profil')){
        function img_container_replacement(){
            let el = $('#container-cover');
            let container_height;

            if (window.matchMedia("(max-width: 1200px)").matches){
                container_height = 400;
            }else{
                container_height = $(window).height() - 54;
            }

            el.css({height: container_height+'px'});

            img_replacement();
            img_replacement_contain();
        }

        function scroll(){
            if (!window.matchMedia("(max-width: 1200px)").matches){
                let scrollHeight = $(this).scrollTop();

                $('#container-cover').css({transform: 'translate3d(0px,'+scrollHeight+'px,0px)',height: ($('html').height() - 54)+'px'});
            }else{
                $('#container-cover').css({transform: 'translate3d(0px,0px,0px)',height: '500px'});
            }

            window.requestAnimationFrame(scroll);
        }

        $(window).on('resize',function(){
            img_container_replacement();
        });

        img_container_replacement();

        scroll();
    }


    if ($('body').hasClass('entreprise-view') || $('body').hasClass('tags-add') || $('body').hasClass('tags-edit') || body.hasClass('home-view') || body.hasClass('tag-view') || body.hasClass('community-view')){
        img_replacement_contain();

        $('.contain-img').on('load',function(){
            setTimeout(img_replacement_contain,20);
        });
    }
    if(body.hasClass('community-add') || body.hasClass('community-edit') || $('body').hasClass('entreprise-view') || $('body').hasClass('tags-add') || $('body').hasClass('tags-edit') || body.hasClass('tag-view') || body.hasClass('community-view') || body.hasClass('entreprise-add') || body.hasClass('entreprise-edit')){
        img_replacement();

        $('.cover-img').on('load',function(){
            setTimeout(img_replacement,20);
        });
    }

    if(body.hasClass('entreprise-add') || body.hasClass('entreprise-edit') || body.hasClass('community-add') || body.hasClass('community-edit')){
        $('#input-file').on('change',function(){

            let file = $(this)[0].files[0];
            let parent = $(this).parent();

            let reader = new FileReader();
            reader.onloadend = function(){

                parent.find('.cover-img').remove();
                parent.prepend('<img src="'+this.result+'" class="cover-img" />');

                $('.cover-img').on('load',function(){
                    setTimeout(img_replacement,20);
                });
                setTimeout(img_replacement,20);
            };
            reader.readAsDataURL(file);
        });
    }

    if(body.hasClass('tags-add') || body.hasClass('tags-edit')){
        $('#input-file').on('change',function(){

            let file = $(this)[0].files[0];
            let parent = $(this).parent();

            let reader = new FileReader();
            reader.onloadend = function(){

                parent.find('.contain-img').remove();
                parent.prepend('<img src="'+this.result+'" class="contain-img" />');

                $('.cover-img').on('load',function(){
                    setTimeout(img_replacement_contain,20);
                });
                setTimeout(img_replacement_contain,20);
            };
            reader.readAsDataURL(file);
        });
    }

    if (body.hasClass('entreprise-add') || body.hasClass('entreprise-edit')){
        let data_tags = {};
        let tags_ajax = null;
        let tags_select_data = {};

        let data_communities = {};
        let communities_ajax = null;
        let community_select_data = null;

        function communities_search(q){
            if (!q){
                q = "";
            }

            if (communities_ajax !== null){
                communities_ajax.abort();
            }

            if (q.length <= 0){
                data_communities = empty.communities;
                update_communities_list();
            }else{
                data_tags = $.ajax({
                    data:{
                        q: q
                    },
                    cache: false,
                    url: REQUEST_COMMUNITIES,
                    dataType: 'json',
                    method: 'get',
                    success: function(data){
                        communities_ajax = null;
                        data_communities = data;

                        update_communities_list();
                    },
                    error: function(){
                        communities_ajax = null;
                        data_communities = [];

                        update_communities_list();
                    }
                });
            }
        }

        function update_communities_list(){
            let html = '';

            for(let i=0;i<data_communities.length;i++){
                html += ' <div class="community-select" data-id="'+data_communities[i].id+'">'+data_communities[i].name+'</div>';
            }

            $('#communities-append').html(html);

            $('.community-select').on('click',function(evt){

                evt.preventDefault();
                evt.stopPropagation();

                let el = $(this);

                let name = el.text();
                let id = parseInt(el.data('id'));

                community_select_data = {
                    id: id,
                    name: name,
                };

                $('#input-community').attr('value',id);

                let valueEL = $('#community-select-value');

                valueEL.addClass('selected');
                valueEL.text(name);

                $('#community-select').removeClass('open');
            });
        }

        function tags_search(q){
            if (!q){
                q = "";
            }

            if (tags_ajax !== null){
                tags_ajax.abort();
            }

            if (q.length <= 0){
                data_tags = empty.categrories;
                update_tags_list();
            }else{
                data_tags = $.ajax({
                    data:{
                        q: q
                    },
                    cache: false,
                    url: REQUEST_TAGS,
                    dataType: 'json',
                    method: 'get',
                    success: function(data){
                        data_tags = null;
                        data_tags = data;

                        update_tags_list();
                    },
                    error: function(){
                        data_tags = null;
                        data_tags = [];

                        update_tags_list();
                    }
                });
            }
        }

        function update_tags_list(){
            let html = '';

            for(let i=0;i<data_tags.length;i++){

                let clas = 'tag-select';
                if (typeof tags_select_data[parseInt(data_tags[i].id)] !== "undefined"){
                    clas += ' selected';
                }

                html += ' <div class="'+clas+'" data-id="'+data_tags[i].id+'">'+data_tags[i].tag+'</div>';
            }

            $('#tag-append').html(html);

            $('.tag-select').on('click',function(evt){

                evt.preventDefault();
                evt.stopPropagation();
                let el = $(this);

                let id = parseInt(el.data('id'));

                if (el.hasClass('selected')){
                    let keys = Object.keys(tags_select_data);
                    let filtred = {};
                    for(let i=0;i<keys.length;i++){
                        if (parseInt(keys[i]) !== id){
                            filtred[keys[i]] = tags_select_data[keys[i]];
                        }
                    }

                    tags_select_data = filtred;
                }else{
                    tags_select_data[id] = $(this).text();
                }

                $('#input-tags').attr('value',Object.keys(tags_select_data).join('-'));

                $(this).toggleClass('selected');
            });
        }


        let tagsHidden = $('#input-tags').val().split('-');
        for(let i=0;i<tagsHidden.length;i++){
            tagsHidden[i] = parseInt(tagsHidden[i]);
            if (!isNaN(tagsHidden[i])){
                for(let o=0;o<empty.categrories.length;o++){
                    if (empty.categrories[o].id === tagsHidden[i]){
                        tags_select_data[tagsHidden[i]] = empty.categrories[o].tag;
                        break;
                    }
                }
            }
        }

        let community = parseInt($('#input-community').val());
        if (!isNaN(community)){
            for(let o=0;o<empty.communities.length;o++){
                if (empty.communities[o].id === community){
                    community_select_data = {
                        id: community,
                        name: empty.communities[o].name,
                    };

                    let valueEL = $('#community-select-value');

                    valueEL.addClass('selected');
                    valueEL.text(empty.communities[o].name);

                    break;
                }
            }
        }

        tags_search();
        communities_search();

        $('#input-search-communities').on('keyup',function(){
            communities_search($(this).val());
        });

        $('#community-select').on('click',function(){
            if (!$(this).hasClass('open')){

                let valueEL = $('#communities-select-value');

                valueEL.removeClass('selected');
                valueEL.text('Selectionner votre communauté...');

                $(this).addClass('open');
            }
        });

        $('#input-search-tag').on('keyup',function(){
            tags_search($(this).val());
        });
    }

    let search_ajax = null;
    let timerHideSearchResult = null;

    $('#input-search').on('keyup',function(ev){
        if (ev.which != 13){
            search($(this).val(),true);
        }
    });
    $('#input-search').on('focus',function(ev){
        if (timerHideSearchResult !== null){
            clearTimeout(timerHideSearchResult);
            timerHideSearchResult = null;
        }

        updateSearch();
        $('#search-result').addClass('show');
    });
    $('#input-search').on('blur',function(ev){
        let delay = 3000;

        timerHideSearchResult = setTimeout(function(){
            $('#search-result').removeClass('show');
            timerHideSearchResult = null;
        },delay);
    });

    let emptySearchData = null;
    let searchData = {
        community: {},
        entreprises: {},
        tags: {}
    };
    function search(q,update){
        if (search_ajax !== null){
            search_ajax.abort();
        }

        $('#search-result').addClass('loading');

        if (!update){
            update = false;
        }
        if (!q){
            q = "";
        }

        if (q.length <= 0 && emptySearchData!==null){
            searchData = emptySearchData;
        }else{
            search_ajax = $.ajax({
                data:{
                    q: q
                },
                cache: false,
                url: REQUEST,
                dataType: 'json',
                method: 'get',
                success: function(data){
                    search_ajax = null;
                    searchData = data;
                    if (q.length < 0){
                        emptySearchData = data;
                    }

                    if (update === true){
                        updateSearch();
                    }
                },
                error: function(){
                    search_ajax = null;
                    searchData = {
                        community: {},
                        entreprises: {},
                        tags: {}
                    };
                    if (update === true){
                        updateSearch();
                    }
                }
            });
        }
    }

    function updateSearch(){
        let html_entreprise = '';
        let html_communaute = '';
        let html_tag = '';

        let still_entreprise = searchData.entreprises.length;
        let still_community = searchData.community.length;
        let still_tags = searchData.tags.length;

        let nbr_entreprise = 0;
        let nbr_community = 0;
        let nbr_tags = 0;


        while((nbr_entreprise + nbr_community + nbr_tags) < 9){
            if (nbr_entreprise < 3 && still_entreprise > 0){
                still_entreprise -= 1;
                nbr_entreprise += 1;
            }else if(nbr_community < 3 && still_community > 0){
                still_community -= 1;
                nbr_community += 1;
            }else if(nbr_tags < 3 && still_tags > 0){
                still_tags -= 1;
                nbr_tags += 1;
            }else{
                if (still_entreprise > 0 || still_community > 0){
                    if (nbr_entreprise <= nbr_community){
                        if (still_entreprise > 0){
                            still_entreprise -= 1;
                            nbr_entreprise += 1;
                        }else{
                            still_community -= 1;
                            nbr_community += 1;
                        }
                    }else{
                        if (still_community > 0){
                            still_community -= 1;
                            nbr_community += 1;
                        }else{
                            still_entreprise -= 1;
                            nbr_entreprise += 1;
                        }
                    }
                }else if(still_tags > 0){
                    still_tags -= 1;
                    nbr_tags += 1;
                }else{
                    break;
                }
            }
        }


        for(let i=0;i<nbr_entreprise;i++){
            html_entreprise += '<li><a href="'+searchData.entreprises[i].link+'">'+searchData.entreprises[i].name+'</a></li>';
        }
        for(let i=0;i<nbr_community;i++){
            html_communaute += '<li><a href="'+searchData.community[i].link+'">'+searchData.community[i].name+'</a></li>';
        }
        for(let i=0;i<nbr_tags;i++){
            html_tag += '<li><a href="'+searchData.tags[i].link+'">'+searchData.tags[i].name+'</a></li>';
        }

        if (html_communaute.length > 0){
            html_communaute = '<li class="bold"><a>Communautées</a></li>'+html_communaute;
        }
        if (html_tag.length > 0){
            html_tag = '<li class="bold"><a>Catégories</a></li>'+html_tag;
        }
        if (html_entreprise.length > 0){
            html_entreprise = '<li class="bold"><a>Entreprises</a></li>'+html_entreprise;
        }

        $('#search-result').html('<ul>'+html_entreprise+html_communaute+html_tag+'</ul>');
        $('#search-result').removeClass('loading');
    }

    search();
});