function clearVoting() {
    $('.vote__minus').removeClass('voting_active')
    $('.vote__plus').removeClass('voting_active')
}

function getUserIdThen(id_post) {
    $.ajax({
        url: 'action/get-user-id.php',
        dataType: 'JSON',
    }).done(res => {
        checkUserVote(id_post, res)
    })
}

function checkUserVote(id_post, id_user) {
    $.ajax({
        url: 'action/check-user-vote.php',
        type: 'POST',
        data: { post: id_post, id_user: id_user },
        dataType: 'JSON',
    }).done(res => {
        if (res != null) {
            if (res.vote == 1) {
                clearVoting()
                $('.vote__plus').addClass('voting_active')
            } else {
                clearVoting()
                $('.vote__minus').addClass('voting_active')
            }
        } else {
            clearVoting()
        }
    })
}


function showVote(id_post){

    $.ajax({
        url: 'action/get-vote.php',
        type: 'POST',
        data: { post: id_post },
        dataType: 'JSON'
    }).done(res => {
        $('.vote__sum').text(res.votes_sum)
        if (res.votes_sum > 0) {
            $('.vote__sum').removeClass('vote__sum_less')
            $('.vote__sum').addClass('vote__sum_more')
        } else if (res.votes_sum < 0) {
            $('.vote__sum').removeClass('vote__sum_more')
            $('.vote__sum').addClass('vote__sum_less')
        } else {
            $('.vote__sum').text(0)
            $('.vote__sum').removeClass('vote__sum_less')
            $('.vote__sum').removeClass('vote__sum_more')
        }
        getUserIdThen(id_post)
    })

    
}

$('.voting').click(function() {
    let vote
    if ($(this).hasClass('vote__plus')) {
        vote = 1
    } else if ($(this).hasClass('vote__minus')) {
        vote = -1
    }
    let id_post = $('.id_post').val();
    $.ajax({
        url: 'action/voting.php?post=' + id_post,
        type: 'POST',
        data: { vote: vote },
        dataType: 'JSON'
    }).done(res => {
        showVote($('.id_post').val())
    }).fail(err => {
        console.log('err');
    })
})

showVote($('.id_post').val())