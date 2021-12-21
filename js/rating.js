var ratingForm = document.getElementById('detailed-page__rating-form');
var ratingFormSubmitBtn = document.getElementById('detailed-page_selector-button');

async function ratingSend(e) {
    e.preventDefault();

    let ratingFormData = new FormData(ratingForm);

    fetch('rating.php', {
        method: 'POST',
        body: ratingFormData
    }
    )
        .then(response => response.json())
        .then((result) => {
            console.log(result);
            if (result.errors) {
                result.errors.forEach(function callback(currentValue) {

                })
            } else {
                //успешная авторизация, обновляем страницу
                ratingFormSubmitBtn.value = "Готово";
            }
        })
        .catch(error => console.log(error));
}

ratingForm.addEventListener("submit", ratingSend);