import $ from 'jQuery';

class MyNotes {
    constructor() {

        this.events();
    }

    events() {
        $("#my-notes").on("click", ".delete-note", this.deleteNote);
        $("#my-notes").on("click", ".edit-note", this.editNote.bind(this));
        $("#my-notes").on("click", ".update-note", this.updateNote.bind(this));
        $(".submit-note").on("click", this.createNote.bind(this));


    }

    editNote(e) {
        var thisNote = $(e.target).parents("li");
        if(thisNote.data("state") === "editable") {
            this.makeNoteReadOnly(thisNote);
        } else {
            this.makeNoteEditable(thisNote);
        }

    }

    makeNoteEditable(thisNote) {
        thisNote.find(".edit-note").html('<i class="fas fa-times"></i> Cancel');
        thisNote.find(".note-title-field, .note-body-field").removeAttr("readonly").addClass("note-active-field");
        thisNote.find(".update-note").addClass("update-note--visible");
        thisNote.data("state", "editable");
    }

    makeNoteReadOnly(thisNote) {
        thisNote.find(".edit-note").html('<i class="fas fa-pencil-alt"></i> Edit');
        thisNote.find(".note-title-field, .note-body-field").attr("readonly", "readonly").removeClass("note-active-field");
        thisNote.find(".update-note").removeClass("update-note--visible");
        thisNote.data("state", "cancel");
    }

    createNote() {
        if($(".new-note-title").val()=='' && $(".new-note-body").val()=='') {
            console.log("sorry! You must have a content before saving a note");
            return;
        }
        var ourNewPost = {
            'title': $(".new-note-title").val(),
            'content': $(".new-note-body").val(),
            'status': 'private'
        }

        var OurNewPostHtml = (postId, postTitle, postContent) => {

            return `
                    <li data-id=${postId}>
                        <input readonly type="text" class="note-title-field" value="${postTitle}" />
                        <span class="edit-note"><i class="fas fa-pencil-alt"></i> Edit</span>
                        <span class="delete-note"><i class="fas fa-trash"></i> Delete</span>
                        <textarea readonly class="note-body-field">${postContent}</textarea>
                        <span class="update-note btn btn--blue btn--small"><i class="fas fa-arrow-right"></i> Save</span>
                    </li>
                `
        }
        $.ajax({
            beforeSend: (xhr) => {
                xhr.setRequestHeader('X-WP-Nonce', fictionUniversityData.fu_user_nonce);
            },
            url: `${fictionUniversityData.baseUrl}/wp-json/wp/v2/note/`,
            type: 'POST',
            data: ourNewPost,
            success: (res) => {
                $(".new-note-title, .new-note-body").val('');
                $(OurNewPostHtml(res.id, res.title.raw, res.content.raw)).prependTo("#my-notes").hide().slideDown();
                console.log(res);
            },
            error: (err) => {
                console.log('Error! Sorry there was a problem');
                console.log(err)
            }
        });
    }

    updateNote(e) {
        var thisNote = $(e.target).parents("li");

        var ourUpdatedPost = {
            'title': thisNote.find(".note-title-field").val(),
            'content': thisNote.find(".note-body-field").val()
        }
        $.ajax({
            beforeSend: (xhr) => {
                xhr.setRequestHeader('X-WP-Nonce', fictionUniversityData.fu_user_nonce);
            },
            url: `${fictionUniversityData.baseUrl}/wp-json/wp/v2/note/${thisNote.data("id")}`,
            type: 'POST',
            data: ourUpdatedPost,
            success: () => {
                this.makeNoteReadOnly(thisNote);
            },
            error: () => {
                console.log('Error! Sorry there was a problem');
                this.makeNoteEditable(thisNote);
            }
        });
    }

    deleteNote(e) {
        var thisNote = $(e.target).parents("li");
        $.ajax({
            beforeSend: (xhr) => {
                xhr.setRequestHeader('X-WP-Nonce', fictionUniversityData.fu_user_nonce);
            },
            url: `${fictionUniversityData.baseUrl}/wp-json/wp/v2/note/${thisNote.data("id")}`,
            type: `DELETE`,
            success: () => {
                thisNote.slideUp();
            },
            error: () => {
                console.log('Error! Sorry there was a problem');
            }
        });
    }
}

export default MyNotes;
