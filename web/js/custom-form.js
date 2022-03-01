var ESC_KEYCODE = 27;

const responseButton = document.querySelector('.response-button');
const refuseButton = document.querySelector('.refuse-button');
const finishedButton = document.querySelector('.finished-button');

if (responseButton) {
    const form = document.querySelector('#response-form');
    const modalCloseButton =  document.querySelector('.close-button'); 

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

if (refuseButton) {
    const form = document.querySelector('#refuse-form');
    const modalCloseButton = form.querySelector('.close-button'); 

    refuseButton.addEventListener('click', (evt) => {
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

if (finishedButton) {
    const form = document.querySelector('#finished-form');
    const modalCloseButton = form.querySelector('.close-button'); 

    finishedButton.addEventListener('click', (evt) => {
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