

const addLikeAjax = (event) => {
    event.preventDefault();
    
    const buttonLikeID = event.target.closest('.blog-post-favorite');
    const star = buttonLikeID.querySelector('.fa-solid');
    let clickCount = 0;
    let checkedStar = 0;
    let likeCounter;
    let likeCounterElement = event.target.closest('.post').querySelector('.blog-post-info-right'); 

    if (buttonLikeID) {
  
  if(star && checkedStar == 0){ // check once if post is already liked
        clickCount += 1;
        checkedStar = 1;
    }

    const type = (clickCount % 2 === 0) ? 'add' : 'delete';  // Toggle the type based on the click count
    
  
    if(likeCounterElement){ //check if it's main view or detail view where the liker counter doesnt exist
        likeCounterElement = likeCounterElement.lastElementChild;
        likeCounter = parseInt(likeCounterElement.innerText.trim());
        likeCounter += (clickCount % 2 === 0) ? 1 : -1; //add 1 or -1 to counter
    }

    clickCount++;
  
        const postID = buttonLikeID.id;

        $.ajax({
            type: "POST",
            url: "likepost",
            data: {
                type: type,  // Ensure type is 'add' or 'delete'
                postID: postID
            },
            dataType: "json",
            success: function(data) {

                const starIcon = buttonLikeID.querySelector('i.fa-star');
                if (starIcon) {
                    starIcon.classList.toggle('fa-solid');
                    starIcon.classList.toggle('fa-regular');
                }
                
                if(likeCounterElement)
                    likeCounterElement.innerHTML = `<i class="fa-regular fa-heart"></i> ${likeCounter}`;
            },
            error: function (data) {
            }
        });
    }
};


document.addEventListener('DOMContentLoaded', () => {
    const likeButtons = document.querySelectorAll('.blog-post-favorite');

    if (likeButtons) {
        likeButtons.forEach((likeButton) => {
            likeButton.addEventListener('click', addLikeAjax);
        });
    }
});
