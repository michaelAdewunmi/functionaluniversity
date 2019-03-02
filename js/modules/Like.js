import $ from 'jquery';

class Like {
    constructor() {
        this.events();
    }

    events() {
        $(".like-box").on("click", this.ourClickDispatcher.bind(this));
    }

    ourClickDispatcher(e) {
        var currentLikeBox = $(e.target).closest(".like-box");

        if(currentLikeBox.attr('data-exists') == 'yes') {
            this.deleteLike(currentLikeBox);
        } else {
            this.createLike(currentLikeBox);
        }
    }


    //Methods
    createLike(currentLikeBox) {
        $.ajax({
            beforeSend: (xhr) => {
                xhr.setRequestHeader('X-WP-Nonce', fictionUniversityData.fu_user_nonce);
            },
            url: fictionUniversityData.baseUrl + '/wp-json/fiction-university/v1/manage-like',
            type: 'POST',
            data: {'professorId': currentLikeBox.data('prof'), 'userName': currentLikeBox.data('user')},
            success: (res) => {
                currentLikeBox.attr('data-exists', 'yes');
                var likeCount = parseInt(currentLikeBox.find(".like-count").html(), 10);
                likeCount++;
                currentLikeBox.find(".like-count").html(likeCount);
                currentLikeBox.attr('data-like', res);
            },
            error: () => {
                console.log("There was an error");
            }
        })
    }

    deleteLike(currentLikeBox) {
        $.ajax({
            beforeSend: (xhr) => {
                xhr.setRequestHeader('X-WP-Nonce', fictionUniversityData.fu_user_nonce);
            },
            url: fictionUniversityData.baseUrl + '/wp-json/fiction-university/v1/manage-like',
            type: 'DELETE',
            data: {'likeId': currentLikeBox.attr('data-like')},
            success: () => {
                currentLikeBox.attr('data-exists', 'no');
                var likeCount = parseInt(currentLikeBox.find(".like-count").html(), 10);
                likeCount--;
                currentLikeBox.find(".like-count").html(likeCount);
                currentLikeBox.attr('data-like', '');
            },
            error: (err) => {
                console.log(err);
            }
        })
    }
}

export default Like;