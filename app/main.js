function debounce(func, wait, immediate) {
    var timeout;

    return function () {
        var context = this,
            args = arguments,
            later = function () {
                timeout = null;

                if (!immediate) {
                    func.apply(context, args);
                }
            },
            callNow = immediate && !timeout;

        clearTimeout(timeout);

        timeout = setTimeout(later, wait);

        if (callNow) {
            func.apply(context, args);
        }
    };
};

function inputValidation() {
    $('input').each(function (index, element) {
        element = $(element);

        element.on('keyup', debounce(function (event) {
            var value = element.val(),
                name = element.attr('name');

            var url = '/validate/' + name + '?value=' + value;

            // if ('password[password]' === name || 'password[confirm]') {
            //     var password = $('label[for="password"] input').val(),
            //         confirm = $('label[for="password-confirm"] input').val();

            //     url = '/validate/password?password=' + password + '&confirm=' + confirm;
            // }

            $.ajax(url).done(function (response) {
                insertValidationMessage(element, response.message);
            })


            //
        }, 250));
    });
};

function insertValidationMessage(sibling, message) {
    var aside = sibling.next('aside');

    if (0 === aside.length) {
        $('<aside><p>' + message + '</p></aside>').insertAfter(sibling);
    } else {
        aside.find('p').text(message);
    }
};

$(document).ready(inputValidation);
