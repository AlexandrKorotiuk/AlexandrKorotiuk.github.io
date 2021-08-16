$(document).on('click', '#btn-comment',function() {
    let commentText = $("#text-comment").val();
    let commentFirstname = $("#firstname-comment-id").val();
    let commentLastname = $("#lastname-comment-id").val();
    let commentCreated = $("#created-comment-id").val();
    let commentEmail = $("#email-comment-id").val();
    let commentRating = $("#star-5").val();
    // let commentRating = $(this).parent('.ratingmodestar').attr('data-star');
    // let commentRating = $(this).parent('.ratingmodestar').data('star');
     console.log(commentRating);
    $.post(
        "/core.php",
        {commentText,commentFirstname,commentLastname,commentCreated,commentRating,commentEmail},
        function( commentResult ) {
            commentResult = JSON.parse(commentResult);
            console.log(commentResult);
            let htmlFirstname = '<p class = "username-comment">'+commentResult[0]+' '+commentResult[1]+":"+'</p>';
            let htmlMessage = '<p class = "message-comment">'+commentResult[2]+'</p>';
            let htmlRating = '<p class = "comment-rating">'+'Оценка:'+commentResult[3]+'</p>';
            let htmlCreated = '<p class = "created-comment">'+commentResult[5]+'</p>';
            let htmlHr = '<hr>';
            let htmlForm = htmlFirstname+htmlMessage+htmlRating+htmlCreated+htmlHr;
            let htmlAllForm = '<div class = "comment-block">'+htmlForm+'</div>';
            $ ('#comments').append(htmlAllForm);
     });
});
