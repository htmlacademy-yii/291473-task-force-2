var ESC_KEYCODE = 27;

const responseButton = document.querySelector('.response-button');

if (responseButton) {
    const form = document.querySelector('.form-modal');
    const modalCloseButton =  document.querySelector('.modal-close'); 

    responseButton.addEventListener('click', (evt) => {
        evt.preventDefault();
        form.classList.remove('modal-hide')
    });
    
    modalCloseButton.addEventListener('click', function(evt) {
        form.classList.add('modal-hide')
    });

    document.addEventListener('keydown', function(evt) {
        if (evt.keyCode === ESC_KEYCODE) {
            form.classList.add('modal-hide')
        }
    });
}
