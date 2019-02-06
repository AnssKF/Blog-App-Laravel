$(document).ready( ()=>{


    $( "#POST-LIKE" ).click(function() {
        post_id = $(this).data('post-id');     
        
        if( $(this).hasClass('like') ){
            $.ajax({
                url:"/like/"+post_id,
                type: 'POST',
                dataType: 'json',
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content')
                }
            })
            .done(( response )=>{
                likesCount = $('small',this);
                likesCount.text( (+likesCount.text())+1 );
                
                $('span',this).text('unlike');
                $(this).toggleClass('like unlike');
            })
            .fail(( error )=>{
                console.log(error);
            });
        }else if($(this).hasClass('unlike')){
            $.ajax({
                url:"/like/"+post_id,
                type: 'POST',
                dataType: 'json',
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    '_method': 'DELETE'
                }
            })
            .done(( response )=>{
                likesCount = $('small',this);
                likesCount.text( (+likesCount.text()) - 1 );
                
                $('span',this).text('like');
                $(this).toggleClass('like unlike');
            })
            .fail(( error )=>{
                console.log(error);
            });
        }
        
    });
    
    $( "#POST-SUBSCRIBE" ).click(function() {
        post_id = $(this).data('post-id'); 
        
        if($(this).hasClass('subscribe')){
            
            $.ajax({
                url:"/subscribe/"+post_id+"/post",
                type: 'POST',
                dataType: 'json',
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content')
                }
            })
            .done(( response )=>{
                $(this).text('unsubscribe');
                $(this).toggleClass('subscribe unsubscribe');
            })
            .fail(( error )=>{
                console.log(error);
            });
            
        }else if($(this).hasClass('unsubscribe')){
            $.ajax({
                url:"/subscribe/"+post_id+"/post",
                type: 'POST',
                dataType: "json",
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    '_method': 'DELETE'
                }
            })
            .done(( response )=>{
                $(this).text('subscribe');
                $(this).toggleClass('subscribe unsubscribe');
            })
            .fail(( error )=>{
                console.log(error);
            });
        }
    });


    $( "#CATEGORY-SUBSCRIBE" ).click(function() {
        category_id = $(this).data('category-id');
        
        if($(this).hasClass('subscribe')){
            $.ajax({
                url:"/subscribe/"+category_id+"/category",
                type: 'post',
                dataType: 'json',
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content')
                }
            })
            .done(( response )=>{
                $(this).text('unsubscribe from category');
                $(this).toggleClass('subscribe unsubscribe');
            })
            .fail(( error )=>{
                console.log(error);
            });
            
        }else if($(this).hasClass('unsubscribe')){
            $.ajax({
                url:"/subscribe/"+category_id+"/category",
                type: 'post',
                dataType: 'json',
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    '_method': 'DELETE'
                }
            })
            .done(( response )=>{
                $(this).text('subscribe to this category');
                $(this).toggleClass('subscribe unsubscribe');
            })
            .fail(( error )=>{
                console.log(error);
            });
        }
    });


    $('#AddCommentForm').submit((event)=>{
        event.preventDefault();
        post_id = $('#AddCommentForm button[type=submit]').data('post-id');
        comment = $('#AddCommentForm input[name=body]').val();
        
        $("#AddCommentForm button[type=submit]").toggleClass('disabled');
        
        $.ajax({
            url:"/comments/"+post_id,
            type: 'POST',
            dataType: 'json',
            data: {
                'body': comment,
                '_token': $('meta[name="csrf-token"]').attr('content')
            }
        })
        .done(( response )=>{
            
            html = `
            <li class="list-group-item">
            `+ comment +` ...
            <small> By: `+ response.user_name + ` </small>
            <small> at: ` + response.created_at +` </small>
            </li>
            `
            
            $('#COMMENTS-LIST').prepend(html);
            $('#AddCommentForm input[name=body]').val("")
            $("#AddCommentForm button[type=submit]").toggleClass('disabled');
            comment_skip++;
        })
        .fail(( error )=>{
            console.log(error);
        });
    })
    
    comments_next_page = 2;
    comment_skip = 0;
    $('#COMMENTS-LOAD-MORE').click((e)=>{
        e.preventDefault();
        last_page = $('#COMMENTS-LOAD-MORE').data('comments-lastpage');
        post_id = $('#COMMENTS-LOAD-MORE').data('post-id');
        
        $.ajax({
            url:"/comments/"+post_id,
            type: 'GET',
            dataType: 'json',
            data: {
                'page': comments_next_page,
                'skip': comment_skip,
                '_token': $('meta[name="csrf-token"]').attr('content')
            }
        })
        .done(( response )=>{
            
            console.log(comments_next_page);
            console.log(response);

            if( last_page == comments_next_page){
                $('#COMMENTS-LOAD-MORE').remove();
            }

            comments_next_page++;

            response.forEach(function(comment) {
                $('#COMMENTS-LIST').append(`
                    <li class="list-group-item">
                        `+ comment.body +` ...
                        <small> By: `+ comment.user.name +` </small>
                        <small> at: `+ comment.created_at +` </small>
                    </li>
                `);
            });
            
        })
        .fail(( error )=>{
            console.log(error);
        });

    });

});
    