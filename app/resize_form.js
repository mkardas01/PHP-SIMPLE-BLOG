textarea = document.querySelectorAll("textarea");

for (let i=0; i< textarea.length; i++){
    textarea[i].addEventListener('input', autoResize, false);
    textarea[i].addEventListener('click', autoResize, false);
    textarea[i].click();
}

function autoResize() {
        this.style.height = 'auto';
        this.style.height = this.scrollHeight + 'px';
}