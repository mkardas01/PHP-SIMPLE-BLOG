let showCommentFormBtn = document.querySelector('#commentControl');
let commentHeader = document.querySelector('.commentsHeader');
let postID = document.querySelector('.blog-post-favorite').id;

var commentAdd;
var commentFormDiv;
var count = 0;

if(showCommentFormBtn){
    showCommentFormBtn.addEventListener("click", () =>{
        if(count%2 == 0)
            showCommentForm();
        else
            deleteCommentForm();

            
        count ++;
        if(count == 6)
            count = 0;
    })
}

const showCommentForm = () =>{ 
    showCommentFormBtn.innerHTML = 'Anuluj dodawanie';
    let commentFormHTML = 
    `<div class="comment_form_div" id="animation">
        <textarea id="comment" name="PostID" class="form-control"></textarea> 
        <div class="form-submit"> 
            <button type="submit" class="btn" id="save_comment" name="save_comment" value="save_comment">Dodaj komentarz</button>
        </div>
    </div>`
    commentHeader.insertAdjacentHTML(
        'afterend',
        commentFormHTML
    )

    resize();

    commentFormDiv = document.querySelector('.comment_form_div');
    setTimeout(() => {
        commentFormDiv.classList.remove("removed");
        commentFormDiv.classList.add("added");
    }, 1);
    commentAdd = document.querySelector('#save_comment');
    commentAdd.addEventListener('click', addCommentAjax);
    
};

const deleteCommentForm = () => {
    showCommentFormBtn.innerHTML = 'Dodaj komentarz';
    commentAdd.removeEventListener('click', addCommentAjax);
    commentFormDiv.classList.remove("added");
    commentFormDiv.classList.add("removed");
    setTimeout(() => {
        commentFormDiv.remove();
    }, 1000);
    
    
};

const addCommentAjax = (event) => {
    event.preventDefault();
    let status = document.querySelector("#save_comment");
    commentTeaxtArea = document.querySelector('#comment');
    
    $.ajax({
        type: "POST",
        url: "addcomment",
        data: {
            type: 'add',
            comment: commentTeaxtArea.value,
            postID: postID
        },
        dataType:"json",
        success: function(data) {
            putStatus(data, status);    
            commentTeaxtArea.value = "";
            updateComments(data['commentSection']);
            commentTeaxtArea.click();
        },
        error: function (data){
            putStatus(data, status);
        }
    })
}

const deleteCommentAjax = (event) => {

    let element = event.target;
    
    let commentID = element.getAttribute('data-commentid');

    $.ajax({
        type: "POST",
        url: "deletecomment",
        data: {
            type: 'delete',
            commentID: commentID,
            postID: postID
        },
        dataType:"json",
        success: function(data) {
            let commentToDelete = document.querySelector(`.comment[id='c${commentID}']`);

            commentToDelete.style.backgroundColor = "#d7d6da";

            setTimeout(() => {  
                commentToDelete.remove();
            }, 1000);
    
            
        },
        error: function (data){
            
        }
    })
}

const editCommentAjax = (event) => {
    event.preventDefault;
    let element = event.target;
    
    let commentID = element.getAttribute('id').slice(1); //cut b from button commentID
    let comment= document.querySelector(`div.comment#c${commentID} textarea`);
    let commentText = document.querySelector(`div.comment#c${commentID} textarea`).value;
    let editButton = document.querySelector(`div.comment#c${commentID} i[data-commentid="${commentID}"]`);

    $.ajax({
        type: "POST",
        url: "editcomment",
        data: {
            type: 'edit',
            comment: commentText,
            commentID: commentID
        },
        dataType:"json",
        success: function(data) {

            comment.textContent = commentText;
            putStatus(data, comment);
            editButton.click(); 
                   
        },
        error: function (data){

            putStatus(data, comment);
            editButton.click(); 
        }
    })
}

const editComment = (event) => {

    let element = event.target;
    let commentID = element.getAttribute('data-commentid');
    let commentSelector = `div.comment#c${commentID}`;

    let pElement = document.querySelector(`${commentSelector} p.pcomment`);
    
    if (pElement) {
        let pElementContent = pElement.textContent;
        let editForm = document.createElement("textarea");
        editForm.textContent = pElementContent;
        editForm.className = 'form-control';
        editForm.style.marginBottom = '5px';

        pElement.replaceWith(editForm);

        let buttonElement = document.createElement('button');
        buttonElement.innerHTML = 'Zapisz';
        buttonElement.className = 'btn';
        buttonElement.setAttribute("id", `b${commentID}`);
        buttonElement.addEventListener('click', editCommentAjax);
        buttonElement.style.marginRight = '20px';

        editForm.after(buttonElement);

        resize();
    } else {
        let textElement = document.querySelector(`${commentSelector} textarea`);
        let buttonElement = document.querySelector(`${commentSelector} button.btn`);

        if (textElement && textElement.textContent) {
            let newpElement = document.createElement("p");
            newpElement.textContent = textElement.textContent;
            newpElement.className = 'pcomment';
            textElement.replaceWith(newpElement);
            buttonElement.remove();
        }
    }
}


const updateComments = (dataBaseComments) =>{
    let webComments = document.querySelectorAll('.comment');
    let webCommentsID =[];

    for(let i=0; i<webComments.length; i++){
        webCommentsID[i] = webComments[i].id.slice(1); // cut C letter from id
    }

    for (let i=0; i <dataBaseComments['comments'].length; i++){
        if(!webCommentsID.includes(dataBaseComments['ID'][i].toString())){
            putNewComment(webComments[0], dataBaseComments['comments'][i], dataBaseComments['ID'][i].toString()); 
        }

            
    }

} 


const putNewComment = (firstWebComment, commentToPut, commentID) => {

    let location = 'beforebegin';

    if(firstWebComment == null){
        firstWebComment = commentFormDiv; //check if any comment exists
        location = 'afterend';
    }
        

    firstWebComment.insertAdjacentHTML(location, commentToPut)

    let newComment = document.querySelector(`.comment#c${commentID}`);

    let orig = newComment.style.getPropertyValue('backgroundColor');

    let editButton = newComment.querySelector('.editButton');
    let deleteButton = newComment.querySelector('.deleteButton');

    newComment.style.backgroundColor = "#d7d6da";

    if(editButton && deleteButton){

        editButton.addEventListener('click', editComment);
        deleteButton.addEventListener('click', deleteCommentAjax);
    }
    
    setTimeout(() => {  
        newComment.style.backgroundColor = orig;
    }, 100);
}

const putStatus = (data, wherePut) => {

    let status = document.createElement('p');
    status.innerHTML = data['info']['status'];
    status.className = data['info']['textColor'];
    status.style.marginTop = '10px';
    wherePut.after(status);

    setTimeout(() => {
        status.remove();
    }, 1500);

}

const resize = async  () => {
    const utilsFile = await fetch("app/resize_form.js");
    const utilsText = await utilsFile.text();
    eval(utilsText);
}

document.addEventListener('DOMContentLoaded', function() {
    const deleteButtons = document.querySelectorAll('.deleteButton');
    const editButtons = document.querySelectorAll('.editButton');

    deleteButtons.forEach((deleteButton) => {
        deleteButton.addEventListener('click', deleteCommentAjax);
    });

    editButtons.forEach((editButton) => {
        editButton.addEventListener('click', editComment);
    });
});