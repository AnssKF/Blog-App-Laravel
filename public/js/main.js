$(document).ready( ()=>{
    

    $( ".LIKE" ).click(function() {
        post_id = $(this).attr('id');
        $.ajax({
            url:"/like/"+post_id,
            type: 'post',
            dataType: 'json',
            data: {
                '_token': $('meta[name="csrf-token"]').attr('content')
            }
        })
        .done(( response )=>{
            $(this).prop('disabled',(name,value)=>{return !value});

            likesCount = $('small',this);
            likesCount.text( (+likesCount.text())+1 );
            
            btnTxt = $('span',this);
            btnTxt.text('You Liked This');
        })
        .fail(( error )=>{
            console.log(error);
        });

    });

    $( ".SUBSCRIBE" ).click(function() {
        post_id = $(this).attr('id');
        $.ajax({
            url:"/subscribe/"+post_id+"/post",
            type: 'post',
            dataType: 'json',
            data: {
                '_token': $('meta[name="csrf-token"]').attr('content')
            }
        })
        .done(( response )=>{
            $(this).prop('disabled',(name,value)=>{return !value});
            
            btnTxt = $('span',this);
            btnTxt.text('Subscribed');
        })
        .fail(( error )=>{
            console.log(error);
        });

    });

    $( "#CATEGORY-SUBSCRIBE" ).click(function() {
        category_id = $(this).data('category-id');
        $.ajax({
            url:"/subscribe/"+category_id+"/category",
            type: 'post',
            dataType: 'json',
            data: {
                '_token': $('meta[name="csrf-token"]').attr('content')
            }
        })
        .done(( response )=>{
            $(this).prop('disabled',(name,value)=>{return !value});
            $(this).text('Subscribed');
        })
        .fail(( error )=>{
            console.log(error);
        });

    });

    $("#AddCommentForm input[type=submit]").click(()=>{
        post_id = $('#AddCommentForm input[type=submit]').data('post-id');
        comment = $('#AddCommentForm input[name=body]').val();
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
        })
        .fail(( error )=>{
            console.log(error);
        });
    });

});
    