
var postId = 0;
var postBodyElement = null;
$('.post').find('.interaction').find('.edit').on('click', function(event) {
    event.preventDefault();
    postBodyElement = event.target.parentNode.parentNode.childNodes[1];
    var postBody = postBodyElement.textContent;
    postId = event.target.parentNode.parentNode.dataset['postid'];
    $('#post-body').val(postBody);
    $('#edit-modal').modal();
});

$('#modal_save').on('click', function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        }
    });
    var body = $('#post-body').val();
    $.ajax({
        type: 'PUT',
        url: '/posts/' + postId,
        data: {body: body,postId: postId}
    })
    .done(function (msg){
        $(postBodyElement).text(msg['new_body']);
        $('#edit-modal').modal('hide');
    });
});

$('.like').on('click', function (event) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        }
    });
    event.preventDefault();
    //if click on like anchor tag return true(there is no element before it)
    //if click on Dislike anchor tag return false(there is element before it)
    var isLike = event.target.previousElementSibling == null;
    postId = event.target.parentNode.parentNode.dataset['postid'];
    $.ajax({
        type: 'PUT',
        url: '/posts/' + postId + '/like',
        data: {isLike: isLike}
    })
    .done(function (msg) {
        // console.log(msg['likeCount'],msg['dislikeCount']);
        // console.log(isLike);
        // console.log($(event.target).hasClass('text-primary'));

        $(event.target).hasClass('text-dark') ? $(event.target).removeClass('text-dark').addClass('text-primary') : $(event.target).removeClass('text-primary').addClass('text-dark');
        
        // event.target.innerText = 
        // isLike ? event.target.innerText == 'Like' ? 'You Like this post' : 'Like' : event.target.innerText == 'Dislike' ? 'you don\'t like this post' : 'Dislike';

         if(isLike){
            $(event.target.nextElementSibling.nextElementSibling).removeClass('text-primary').addClass('text-dark');
            $(event.target.nextElementSibling).text(msg['likeCount']);
            $(event.target.nextElementSibling.nextElementSibling.nextElementSibling).text(msg['dislikeCount']);
            //  event.target.nextElementSibling.nextElementSibling.innerText = 'Dislike';
         }
         else{
            $(event.target.previousElementSibling.previousElementSibling).removeClass('text-primary').addClass('text-dark');
            $(event.target.nextElementSibling).text(msg['dislikeCount']);
            $(event.target.previousElementSibling).text(msg['likeCount']);
            //  event.target.previousElementSibling.previousElementSibling.innerText = 'Like';
         }
    });
})

// $('#post-input').on('click', function () {
//     $('#addPostModal').modal();
// });

// $('#addPostModal-save').on('click', function () {
//     //get the value of the text area in the addPostModal
//     var post = $('#po-body').val();
//     //
//     $.ajaxSetup({
//         headers: {
//             'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
//         }
//     });
//     //send data to the server using ajax request
//     $.ajax({
//         type: 'POST',
//         url: urlCreate,
//         data: {body: post},
//         dataType: 'json'
//     ,
//     success: function(data){

//         var article = $('<article></article>').addClass('pl-2 mb-4 border-danger border-3 post');
//         var para = $('<p></p>').text(data['post-body']);
//         var div1 = $('<div></div>').addClass('font-italic text-muted');
//         div1.append('Posted by '+ data['user']);
//         div1.append(' on ' + data['post-created-at']);
//         var div2 =$('<div></div>').addClass('row pl-3 interaction');
//         var a1 = $('<a>').addClass('active');
//         a1.text('Like');
//         var a2 = $('<a>').addClass('active');
//         a2.text('Dislike');
//         var a3 = $('<a>').addClass('edit');
//         a3.text('Edit');
//         var a4 = $('<a>').addClass('active');
//         a4.text('Delete');
//         div2.append(a1).append('&nbsp;|&nbsp;').append(a2).append('&nbsp;|&nbsp;').append(a3).append('&nbsp;|&nbsp;').append(a4);
//         article.append(para).append(div1).append(div2);
//         var row = '<a class="edit">' + 'Edit' + '</a>'; 
//         article.append(row);

//         $("#head").after(article);
//         $('#po-body').val('');
//         $('#addPostModal').modal('hide');            
//     },
//     error: function(response) {
//         if (response.status == 401) {
//             window.location.href = '/login';
//           }
//         }
// });
// });

